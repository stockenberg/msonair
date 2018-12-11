<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 08.10.2016
 * Time: 12:15
 */

namespace src\controller;


use src\core\Core;
use src\core\Session;
use src\model\UpgradeModel;

class UpgradeController extends Core
{
    public $upgradeModel;
    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    public function run()
    {
        $this->upgradeModel = new UpgradeModel();

        switch ($this->request["p"]) {
            case "upgrade":
                $this->upgradePackage($this->upgradeModel->getPackageById("upgradePackage"));

                if (isset($this->request["payment"]["submit"])) {
                    $this->setPayment();
                }

                break;

            case "profile":
                if (!empty($_SESSION["register"])) {
                    if (isset($this->request["step"]) && $this->request["step"] == "success") {
                        $this->saveUpgrade();
                        $this->redirect("profile");
                    }
                }
                break;
        }
    }


    private function saveUpgrade()
    {
        $upgradeModel = new UpgradeModel();

        // Paypal Routine
        if (isset($_GET["token"])) {
            if ($_GET["token"] == Session::get("register", "paypal_token")) {
                $upgradeModel->upgrade(Session::get("register"), 1);
            }

            if (Session::get("formvalidation", "sofort") == "true") {
                $upgradeModel->upgrade(Session::get("register"), 1);
            }
        }else{
            if (isset($_GET["prepaid"]) ) {
                $upgradeModel->upgrade(Session::get("register"), 0);
            }
        }

    }

    private function upgradePackage($package)
    {
        if (isset($this->request["upgradePackage"]["submit"])) {
            Session::set("register", "package", $package);
        }
    }

}