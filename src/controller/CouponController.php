<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 29.10.2016
 * Time: 21:44
 */

namespace src\controller;


use PayPal\Exception\PayPalConfigurationException;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Exception\PayPalInvalidCredentialException;
use src\core\Core;
use src\core\Registration;
use src\core\Session;
use src\core\Status;
use src\core\User;
use src\helpers\Mails;
use src\model\CouponInvoice;
use src\model\CouponModel;
use src\model\Invoice;
use src\model\Model;
use src\objects\Coupon;

class CouponController extends Core
{

    private $model;
    public $data;

    private $requiredFields = [
        "firstname" => "Bitte fülle den Vornamen aus.",
        "lastname" => "Bitte fülle den Nachnamen aus.",
        "email" => "Bitte fülle die E-Mail-Adresse aus.",
        "username" => "Bitte fülle den Benutzernamen aus.",
        "childsName" => "Bitte fülle den Namen des Kindes aus, für das der Account erstellt wird.",
        "street" => "Bitte fülle die Straße aus.",
        "postcode" => "Bitte fülle die Postleitzahl aus.",
        "city" => "Bitte fülle die Stadt aus.",
        "gender" => "Bitte wähle dein Geschlecht.",
        "instrument" => "Bitte wähle dein Instrument.",
        "payment" => "Bitte wähle eine Bezahloption",
        "termsOfUse" => "Bitte bestätige die AGBs",
        "birthDate" => "du musst mindestens 18 Sein um einen Account zu erstellen.",
        "packageId" => "Wähle bitte den gewünschten Dozenten.",
        "lessonCount" => "Bitte wähle, wieviele Stunden gebucht werden sollen.",
    ];

    public function checkInput(array $post = array()): Coupon
    {

        $Coupon = new Coupon();


        if (isset($post["submit"])) {
            unset($post["submit"]);

            foreach ($post as $name => $value) {
                $Coupon->confirmed = true;

                if (array_key_exists($name, $this->requiredFields)) {
                    switch ($name) {

                        default:
                            if ($post[$name] == "") {
                                $Coupon->confirmed = false;
                            }
                            break;
                    }
                }

                if (!$Coupon->confirmed) {
                    Status::setD($name, $this->requiredFields[$name]);
                } else {
                    $Coupon->$name = htmlentities($value);
                }
            }

        }

        return $Coupon;

    }


    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    private function run()
    {

        $coupon = $this->checkInput($this->request["coupon"] ?? array());



        if($coupon->confirmed){
           if($this->checkPayment($coupon)){

           }
        }


    }

    private function checkPayment(Coupon $coupon){

        $db = new \src\model\Coupon();
        $coupon->id = $db->getLastCouponID();
        $coupon->id = $coupon->id + 1;

        switch ($coupon->payment){

            case "prepaid":

                $invoice = new CouponInvoice($coupon);

                Mails::PrepaidCouponMail($coupon, $invoice->path, $invoice->filename);

                $db = new \src\model\Coupon();
                $db->store($coupon);

                header("Location: ?p=erfolg");
                exit();
                break;

            case "paypal":

                $_SESSION["tmp"]["upgrade"] = false;
                $_SESSION["tmp"]["coupon"] = $coupon;
                $this->setupPaypal($coupon);
                break;

        }

    }

    private function setupPaypal(Coupon $coupon, $upgrade = NULL){
        $ppc = new PaypalController();
        $model = new Model();
        $package = $model->get("SELECT * FROM msonair_packages WHERE package_id = :id", [":id" => $coupon->packageId]);

        // Get ApiContext with Client ID and Secret
        $apiContext = $ppc->getCredentials();
        // Returns Payer-Object with payment-method Paypal - Change in PaypalController function Setup
        $payer = $ppc->setup();

        // Define produkt to buy from shopping-cart
        $_SESSION["total"] = $package[0]["package_price"] * $coupon->lessonCount;

        $article = $model->invoiceID . ($model->getLastInvoiceID()[0]["invoice_id"] + 1) . " - " . $package[0]["package_name"];
        $quantity = 1;
        $articlenr = $coupon->packageId;
        $price = (float) $_SESSION["total"];

        // Define Item with Articlename, Quantity set to 1, Articlenumber, and Package-price
        // Return Item-Object
        $item = $ppc->setItem($article, $quantity, $articlenr, $price);
        // Returns Item-List Object with the presetted item
        $itemList = $ppc->setItemList($item);
        // Returns Amount Object with Currency EUR and Price from ProductDefinition
        $amount = $ppc->setAmount($price);
        // Save ProductDescription from ShoppingProgress
        $description = "Gutschein für " . $package[0]["package_description"];
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

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($param)
    {
        return $this->data[$param];
    }


}