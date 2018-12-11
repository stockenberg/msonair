<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 27.02.17
 * Time: 15:04
 */

namespace src\core;


use src\controller\PaypalController;
use src\helpers\Mails;
use src\interfaces\RegistrationInterface;
use src\model\Invoice;
use src\model\Model;
use src\model\RegistrationModel;
use src\objects\Coupon;
use src\objects\Package;

class Registration implements RegistrationInterface
{
    private $requiredFields = [
        "firstname" => "Bitte fülle deinen Vornamen aus.",
        "lastname" => "Bitte fülle deinen Nachnamen aus.",
        "email" => "Bitte fülle die E-Mail-Adresse aus.",
        "username" => "Bitte fülle deinen Benutzernamen aus.",
        "childsName" => "Bitte fülle deinen Namen des Kindes aus, für das der Account erstellt wird.",
        "street" => "Bitte fülle die Straße aus.",
        "postcode" => "Bitte fülle die Postleitzahl aus.",
        "city" => "Bitte fülle die Stadt aus.",
        "gender" => "Bitte wähle dein Geschlecht.",
        "instrument" => "Bitte wähle dein Instrument.",
        "payment" => "Bitte wähle eine Bezahloption",
        "termsOfUse" => "Bitte bestätige die AGBs",
        "birthDate" => "Du musst mindestens 18 Sein um einen Account zu erstellen.",
        "packageId" => "Wähle bitte erst ein Instrument und anschließend den gewünschten Dozenten.",
        "lessonCount" => "Bitte Wähle, wieviele Stunden du buchen möchten."
    ];

    public function checkInput(array $post = array()): User
    {



        $User = new User();

        if (isset($post["submit"])) {
            unset($post["submit"]);

            foreach ($post as $name => $value) {
                $User->confirmed = true;

                if (array_key_exists($name, $this->requiredFields)) {
                    switch ($name) {
                        case "childsName" :
                            if (isset($post["childsAccount"])) {
                                if (empty($value)) {
                                    $User->confirmed = false;
                                }
                            } else {
                                continue 2;
                            }
                            break;

                        case "birthDate":
                            if ($post[$name] == "") {
                                $User->confirmed = false;
                            }
                            if(strtotime($post[$name]) > strtotime("-18 years", time())){
                                $User->confirmed = false;
                            }
                            break;

                        case "payment":
                        case "lessonCount":
                        case "packageId":
                            if($post["coupon_code"] ?? '' !== ""){
                                $User->setPayment(3);
                                continue 2;
                            }
                            if($post["coupon_code"] ?? '' === ""){
                                if ($post[$name] == "") {
                                    $User->confirmed = false;
                                }
                            }

                            break;

                        default:
                            if ($post[$name] == "") {
                                $User->confirmed = false;
                            }
                            break;
                    }
                }

                if (!$User->confirmed) {
                    Status::setD($name, $this->requiredFields[$name]);
                } else {
                    $setter = "set" . ucfirst($name);
                    $User->$setter(htmlentities($value));
                }
            }

        }
        return $User;

    }

    public function checkUpgradePrivileges( $payment )
    {
        if ( $payment == 1 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upgrade(User $user)
    {

        $user->setUpgrade(true);
        $this->choosePayment($user);
    }

    public function upgradeUser(User $user){
        $model = new Model();

        /**
         * @var \src\model\User $dbuser
         */
        $dbuser = new \src\model\User();
        $sql  = "UPDATE msonair_users 
                SET user_lessoncount = :lessons, user_completed_payment = 0, user_package_id = :package_id 
                WHERE user_id = :id";


        // just values
        $execArray = array(
            ":id"      => $user->getId(),
            ":lessons" => $dbuser->getMyData()[0]["user_lessoncount"] + $user->getLessonCount(),
            ":package_id" => $user->getPackageId()
        );

        // SAVE user to db
        $model->set( $sql, $execArray );
    }

    public static function packagePlusOne(int $packageId = 0){
        $db = new Model();
        /**
         * @var Package $package
         */
        $package = $db->getObj("SELECT * FROM msonair_packages WHERE package_id = :id ", [":id" => $packageId], Package::class);

        $SQL = "UPDATE msonair_packages SET package_booking_count = :count WHERE package_id = :id";
        if($package->getPackageId() != "") {
            $db->set($SQL, [
                ":count" => $package->getPackageBookingCount() + 1,
                ":id" => $packageId
            ]);
        }
    }

    /**
     * Save user to Database
     * GoTo ChoosePayment
     * @param User $user
     */
    public function saveRegistration(User $user)
    {



        $model = new RegistrationModel();

        if($user->getCoupon_code() !== ""){

            $db = new Model();

            $coupon = $db->getObj("SELECT * FROM msonair_coupons WHERE coupon_code = :code", [":code" => $user->getCoupon_code()], Coupon::class);


            if($coupon->activated == 1){
                header("Location: ?p=abbruch&couponFail");
                exit();
            }

            $SQL = "UPDATE msonair_coupons SET coupon_activated = 1 WHERE coupon_id = :id";
            $db->set($SQL, [":id" => $coupon->id]);

            /**
             * @var Package $package
             */
            $package = $db->getObj("SELECT * FROM msonair_packages WHERE package_id = :id ", [":id" => $coupon->packageId], Package::class);

            $user->setPackageId($package->getPackageId());
            $user->setInstrument($package->getPackageInstrument());
            $user->setLessonCount($coupon->lessonCount);

        }


        self::packagePlusOne($coupon->packageId ?? $user->getPackageId());


        $sql = "INSERT INTO msonair_users 
                (user_firstname, user_lastname, user_email, user_username, user_password, 
                user_birthdate, user_street, user_postcode, user_city, user_gender, 
                user_intrested_in, user_package_id, user_lessoncount, user_completed_payment, user_skill) 
                VALUES (:user_firstname, :user_lastname, :user_email, :user_username, :user_password, 
                :user_birthdate, :user_street, :user_postcode, :user_city, :user_gender, 
                :user_intrested_in, :user_package_id, :user_lessoncount, :user_completed_payment, :user_skill)";


        // Save bcrypt hash and Token
        $user->setPassword(password_hash(rand(1, 2000) . time(), PASSWORD_DEFAULT, ["cost" => 12]));

        // just values
        $execArray = array(
            ":user_firstname" => $user->getFirstname(),
            ":user_lastname" => $user->getLastname(),
            ":user_email" => $user->getEmail(),
            ":user_username" => $user->getUsername(),
            ":user_password" => $user->getPassword(),
            ":user_birthdate" => $user->getBirthDate(),
            ":user_street" => $user->getStreet(),
            ":user_postcode" => $user->getPostcode(),
            ":user_city" => $user->getCity(),
            ":user_gender" => $user->getGender(),
            ":user_intrested_in" => $user->getInstrument(),
            ":user_package_id" => $user->getPackageId(),
            ":user_lessoncount" => $user->getLessonCount(),
            ":user_completed_payment" => ($user->getPayment() == __PREPAID__) ? 0 : 1,
            ":user_skill" => 2
        );

        // SAVE user to db
        $model->set($sql, $execArray);
        $user->setId($model->getLastInsertID());
        $this->choosePayment($user);

    }


    public function choosePayment(User $user)
    {


        switch ($user->getPayment()) {
            case __PREPAID__:
                if($user->getUpgrade()){
                    $this->upgradeUser($user);
                }
                $this->sendMailAndGenerateInvoice($user);
                header("Location: ?p=erfolg&prepaid");
                exit();
                break;

            case __PAYPAL__:
                $_SESSION["tmp"]["upgrade"] = true;
                $_SESSION["tmp"]["user"] = $user;
                $_SESSION["tmp"]["userid"] = $user->getId();
                $this->setupPaypal($user);
                break;

            case __COUPON__:
                $this->sendMailAndGenerateInvoice($user);
                header("Location: ?p=erfolg&coupon");
                exit();
            break;
        }

    }

    public function sendMailAndGenerateInvoice(User $user)
    {

        $invoice = new Invoice($user);

        switch ($user->getPayment()) {
            case __PREPAID__:
                if($user->getUpgrade()){
                    Mails::upgradeNeedsConfirmation($user, $invoice->path, $invoice->filename);
                }else{
                    Mails::PrepaidPaymentMail($user, $invoice->path, $invoice->filename);
                }
                Mails::newPrepaidInc($user);
                break;

            case __PAYPAL__:
                if($user->getUpgrade()){
                    Mails::upgraded($user, $invoice->path, $invoice->filename);
                }else{
                    Mails::PrepaidPaymentMail($user, $invoice->path, $invoice->filename);
                }
                Mails::newPaypalInc($user);
                break;

            case __COUPON__:

                // TODO : Rechnung für Gutschein einlösen generieren und mit verschicken
                // TODO : Lars anfunken wie wir das Handhaben wollen.

                Mails::PaymentRecievedMailCoupon($user);


                break;
        }
    }

    private function setupPaypal(User $user, $upgrade = NULL){
        $ppc = new PaypalController();
        $model = new Model();
        $package = $model->get("SELECT * FROM msonair_packages WHERE package_id = :id", [":id" => $user->getPackageId()]);

        // Get ApiContext with Client ID and Secret
        $apiContext = $ppc->getCredentials();
        // Returns Payer-Object with payment-method Paypal - Change in PaypalController function Setup
        $payer = $ppc->setup();

        // Define produkt to buy from shopping-cart
        $_SESSION["total"] = $package[0]["package_price"] * $user->getLessonCount();

        $article = $model->invoiceID . ($model->getLastInvoiceID()[0]["invoice_id"] + 1) . " - " . $package[0]["package_name"];
        $quantity = 1;
        $articlenr = $user->getPackageId();
        $price = $_SESSION["total"];

        // Define Item with Articlename, Quantity set to 1, Articlenumber, and Package-price
        // Return Item-Object
        $item = $ppc->setItem($article, $quantity, $articlenr, $price);
        // Returns Item-List Object with the presetted item
        $itemList = $ppc->setItemList($item);
        // Returns Amount Object with Currency EUR and Price from ProductDefinition
        $amount = $ppc->setAmount($price);
        // Save ProductDescription from ShoppingProgress
        $description = $package[0]["package_description"];
        // Return Transaction Object with Description, ItemlistObject and Amount Object
        $transaction = $ppc->setupTransaction($description, $itemList, $amount);
        // Returns RedirectObject with Approval and Cancle URL - Urls can be edited in PaypalController
        $redirect = $ppc->redirect();
        // Returns Payment Object with all Presettes Objects to be able to process
        $payment = $ppc->setPayment($payer, $redirect, $transaction);

        try {
            $payment->create($apiContext);
        } catch (\Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            $ex->getMessage();
        }

        // Link to Payment
        $approvalUrl = $payment->getApprovalLink();
        $token = explode("token=", htmlentities($approvalUrl));

        Session::set("register", "paypal_token", $token[1]);

        header("Location: " . $approvalUrl);
        exit();
    }


}