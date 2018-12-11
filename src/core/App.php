<?php

namespace src\core;

use src\controller\CalendarController;
use src\controller\ContactController;
use src\controller\CouponController;
use src\controller\DocumentManagementController;
use src\controller\ForgotPWController;
use src\controller\LecturerManagementController;
use src\controller\LoginController;
use src\controller\PaypalController;
use src\controller\ProfileController;
use src\controller\RoomController;
use src\controller\StudentController;
use src\controller\UpgradeController;
use src\controller\UserController;
use src\controller\VideoManagementController;
use src\helpers\Helper;
use src\helpers\Mails;
use src\model\Coupon;
use src\model\CouponInvoice;
use src\model\CouponPDF;
use src\model\Model;
use src\model\Newsletter;
use src\model\RegistrationModel;
use src\model\User;
use src\objects\Package;
use
    src\view\View,
    src\controller\RegistrationController;


class App extends Core
{
    private $register, $user, $view;


    public function __construct()
    {
        new Session();
        parent::__construct();
        $this->view = new View();
    }

    public function run()
    {
        // Set Userdata to Session and Update with evry Action
        if (isset($_SESSION["logged_user"])) {
            $this->user = new User();
            Session::set("logged_user", $this->user->getMyData());
        }

        $this->loadValidatedPages(Session::getCompletedPayment());

        switch ($this->page) {
            // Load different Controllers for Page-Interaction, Object with public members is saved to view
            case 'registrierung':
                try {
                    Helper::useJS($this->page, "script");
                    Helper::useJS($this->page, "register");

                    $reg = new Registration();

                    if (isset($this->request["register"]["submit"])) {


                        /** Validate User Input
                         * @var \src\core\User $user ;
                         */
                        $user = $reg->checkInput($this->request["register"]);

                        /** Confirm Registration and Save User to DB */
                        if (empty(Status::read())) {
                            $reg->saveRegistration($user);

                        }
                    }

                    $this->view->package = (new RegistrationModel())->getPackagesAsObjects();

                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case "preise":
                Helper::useJS($this->page, "coupons");
                $this->view->package = (new RegistrationModel())->getPackagesAsObjects();
                break;

            case "news":

                if(isset($_POST["newsletter"]) && isset($_POST["newsletter"]["accepted"]) && $_POST["newsletter"]["accepted"] == 1){
                    if($_POST["newsletter"]["email"] != ""){
                        /**
                         * @var \src\core\User $user
                         */
                        $user = new \src\core\User();
                        $user->setEmail(htmlspecialchars($_POST["newsletter"]["email"]));

                        $newsletter = new Newsletter();
                        if($newsletter->save($user)){
                            $_POST["success"] = "Vielen dank für die Anmeldung.";
                        }
                    }
                }

                break;

            case "erfolg":
                if (isset($_GET["success"])) {
                    $paypal = new PaypalController();
                    $paypal->executePayment($_SESSION["total"]);
                    if($_SESSION["tmp"]["coupon"]){

                        $db = new Coupon();
                        $code = $db->storePayed($_SESSION["tmp"]["coupon"]);

                        $invoice = new CouponInvoice($_SESSION["tmp"]["coupon"]);


                        $SQL = "SELECT * FROM msonair_coupons WHERE coupon_code = :code";
                        $coupon = $db->get($SQL, [":code" => $code]);

                        $this->filename = "Coupon_" . $coupon[0]["coupon_code"] . ".pdf";
                        $this->path = __COUPONS__ . $this->filename;

                        /**
                         * @var Package $package
                         */
                        $package = $db->getObj("SELECT * FROM msonair_packages WHERE package_id = :id", [":id" => $_SESSION["tmp"]["coupon"]->packageId], Package::class);

                        $coupon[0]["teacher"] = $package->getPackageName();

                        $pdf = new CouponPDF();
                        $pdf->getData($coupon[0], $_SESSION["tmp"]["coupon"], $package);

                        $pdf->AliasNbPages();
                        $pdf->AddPage("v", "a5");
                        $pdf->SetFont("Arial");
                        try {
                            $pdf->Body();
                            $pdf->Output("F", $this->path, true);
                        } catch (\Exception $e) {
                            echo $e->getMessage();
                        }

                        Mails::couponPayed($_SESSION["tmp"]["coupon"], $invoice->path, $invoice->filename, $this->path, $this->filename);

                    }

                    if($_SESSION["tmp"]["user"]){
                        $reg = new Registration();
                        $reg->sendMailAndGenerateInvoice($_SESSION["tmp"]["user"]);
                    }

                    if ($_SESSION["tmp"]["upgrade"] === true) {
                        $reg->upgradeUser($_SESSION["tmp"]["user"]);
                        (new Model())->activateUser($_SESSION["tmp"]["userid"]);
                        $_SESSION["tmp"] = array();
                        unset($_SESSION["tmp"]);
                    }

                    session_unset();
                }

                break;

            case 'login':
            case 'firstlogin':
                try {
                    Helper::useJS($this->page, "script");
                    new LoginController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'profile':
                try {
                    Helper::useJS($this->page, "script");
                    Helper::useJS($this->page, "register");

                    $this->view->profile = new ProfileController(Session::getStatus());
                    $this->view->package = (new RegistrationModel())->getPackagesAsObjects();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'manage-students':
                try {
                    Helper::useJS($this->page, "manage-students");
                    $this->view->students = new StudentController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'manage-videos':
                try {
                    Helper::useJS($this->page, "global");
                    Helper::useJS($this->page, "manage-videos");
                    $this->view->global = new VideoManagementController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case "manage-documents":
                try {
                    Helper::useJS($this->page, "global");
                    Helper::useJS($this->page, "manage-documents");
                    $this->view->global = new DocumentManagementController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case "manage-calendar":
                Helper::useJS($this->page, "moment.min");
                Helper::useJS($this->page, "fullcalendar.min");
                Helper::useJS($this->page, "manage-calendar");
                break;

            case "manage-lecturers":
                try {
                    Helper::useJS($this->page, "manage-lecturers");
                    $this->view->global = new LecturerManagementController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'kalender':
                $this->view->global = new CalendarController();
                Helper::useJS($this->page, "moment.min");
                Helper::useJS($this->page, "fullcalendar.min");
                Helper::useJS($this->page, Helper::convertStatus(Session::getStatus()) . "-calendar");

                break;

            case 'dateien':
                try {
                    $this->view->global = new UserController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'videos':
                try {
                    Helper::useJS($this->page, "video");
                    $this->view->global = new UserController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'unterrichtsraum':
                try {
                    $this->view->global = new RoomController();
                } catch (\Exception $e) {
                    new Status("flash", $e->getMessage());
                }
                break;

            case 'raum':
                // Helper::useJS($this->page, "simplepeer.min");
                Helper::useJS($this->page, "simplewebrtc-latest-v2");
                Helper::useJS($this->page, "chatroom");
                $this->view->global = new RoomController();
                break;

            case 'gutschein':
                try {
                    Helper::useJS($this->page, "coupons");
                    $this->view->package = (new RegistrationModel())->getPackagesAsObjectsForCoupon();
                    (new CouponController());
                } catch (\Exception $e) {
                    $e->getMessage();
                }
                break;


            case 'kontakt':
                try {
                    $this->view->global = new ContactController();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;

            case 'passwort-vergessen':
                try {
                    new ForgotPWController();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
        }

        // Set Sitecontent and used Template
        $this->view->page = $this->page;
        $this->view->siteContent = $this->page . ".php";
        $this->view->setTemplate("default");

        try {
            $this->view->status = Status::read();
            return $this->view->parse();
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }

}