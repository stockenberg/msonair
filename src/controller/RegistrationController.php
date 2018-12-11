<?php

/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 02.10.2016
 * Time: 17:26
 */
namespace
src\controller;

use src\core\Core;
use src\core\Session;
use src\core\Status;
use src\helpers\Mails;
use src\model\RegistrationModel;

class RegistrationController extends Core
{
    public $payment;
    public $package;
    public $coupon;
    public $status = [];
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->run();
    }


    public function run()
    {

        switch (@$this->request['step']) {
            case "package":
                    $regModel = new RegistrationModel();
                    $this->package = $regModel->getPackages();
                    $this->setPackage($regModel->getPackageById("package"));

                break;

            case "payment":
                    $this->setPayment();
                break;

            case "coupon":
                $this->redeemCoupon();
                break;

            case "success":
                    $this->saveRegistration();

                    Session::resetSession();

                    // prepaid
                    if(!isset($_GET["token"])){
                        $regModel = new RegistrationModel();
                        Session::set("bank", $regModel->getLastInvoiceID());
                        Session::set("prepaid", "true");
                    }

                break;

            case "abort":
                // IN case of hopping forward to another step without acknowledgement
                Session::resetSession();
                break;

            default:
                // $this->validateInput($this->request["data"]["Register"]);
                break;
        }

    }

    private function redeemCoupon()
    {
        // TODO: Implement redeemCoupon() method.
    }


    private function setPackage($package)
    {
        if (isset($this->request["package"]["submit"])) {
            Session::set("register", "package", $package);
            Session::set("formvalidation", "package", "true");
            $this->redirect("registrierung", "step=payment");
        }
        else if(isset($this->request["coupon"]["submit"])) {
            $model = new RegistrationModel();
            $model->registerCoupon($this->request["coupon"]);
        }
    }

    private function setPayment()
    {
        $this->model = new RegistrationModel();

        if (isset($this->request["payment"]["submit"])) {
            switch ($this->request["payment"]["payment_select"]) {
                case "paypal":

                    $ppc = new PaypalController();
                    // Get ApiContext with Client ID and Secret
                    $apiContext = $ppc->getCredentials();
                    // Returns Payer-Object with payment-method Paypal - Change in PaypalController function Setup
                    $payer = $ppc->setup();

                    // Define produkt to buy from shopping-cart

                    $article = $this->model->invoiceID . ($this->model->getLastInvoiceID()[0]["invoice_id"] + 1) . " - " . htmlentities(Session::get("register", "package", 0, "package_name"));
                    $quantity = 1;
                    $articlenr = htmlentities(Session::get("register", "package", 0, "package_id"));
                    $price = (int)htmlentities(Session::get("register", "package", 0,
                        "package_price"));

                    // Define Item with Articlename, Quantity set to 1, Articlenumber, and Package-price
                    // Return Item-Object
                    $item = $ppc->setItem($article, $quantity, $articlenr, $price);
                    // Returns Item-List Object with the presetted item
                    $itemList = $ppc->setItemList($item);
                    // Returns Amount Object with Currency EUR and Price from ProductDefinition
                    $amount = $ppc->setAmount($price);
                    // Save ProductDescription from ShoppingProgress
                    $description = htmlentities(Session::get("register", "package", 0,
                        "package_description"));
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
                    Session::set("formvalidation", "payment", "true");

                    header("Location: " . $approvalUrl);
                    exit();
                    break;

                case "sofort":

                    $sc = new SofortController();
                    $sc->registerURLS(__SCRIPT__ . "?p=registrierung&step=success&token=sofort", __SCRIPT__ . "?p=registrierung&step=abort");
                    $price = (int)htmlentities(Session::get("register", "package", 0,
                        "package_price"));
                    $sc->run($price, htmlentities(Session::get("register", "package", 0, "package_name")), $this->model->invoiceID . ($this->model->getLastInvoiceID()[0]["invoice_id"] + 1));

                    break;

                case "prepaid":
                    Session::set("register", "prepaid", "true");
                    Mails::newPrepaidIncoming(Session::get("register"));
                    $this->redirect("registrierung", "step=success&prepaid");
                    break;
            }

        }
    }

    private function saveRegistration()
    {
        $registerModel = new RegistrationModel();

        // Paypal Routine
        if (isset($_GET["token"])) {
            if ($_GET["token"] == Session::get("register", "paypal_token")) {
                $registerModel->saveUser(Session::get("register"), 1);
            }
            // Sofort Routine
            if (Session::get("formvalidation", "sofort") == "true") {
                $registerModel->saveUser(Session::get("register"), 1);
            }
        }else{
            // Prepaid Routine
            if (isset($_GET["prepaid"])) {
                $registerModel->saveUser(Session::get("register"), 0);
            }
        }

    }
}