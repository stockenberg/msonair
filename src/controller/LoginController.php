<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 06.10.2016
 * Time: 21:40
 */

namespace src\controller;


use PHPMailer\PHPMailer\Exception;
use src\core\Core;
use src\core\Session;
use src\core\Status;
use src\helpers\Mails;
use src\model\LoginModel;

class LoginController extends Core
{
    private $token;
    private $login;

    public function __construct()
    {
        parent::__construct();
        $this->login = new LoginModel();
        $this->run();
    }

    public function run()
    {
        if (isset($this->request["success"])) {
            new Status("flash", "Dein Passwort wurde erfolgreich gespeichert.");
        }
        if (isset($this->request["action"])) {
            switch ($this->request["action"]) {
                case "login":
                    if (isset($this->request["data"]["Login"])) {
                        $this->login($this->request["data"]["Login"]);
                    }
                    break;

                case "forgotPw":

                    break;
            }
        }

        $this->checkValidToken();

    }

    /**
     * Log in function with bcrypt
     *
     * @param $data
     */
    private function login($data)
    {

        if (!empty($data)) {
            if (empty($data["username"])) {
                new Status("error", "Bitte deinen Benutzernamen ein.");
            }
            if (empty($data["password"])) {
                new Status("error", "Bitte gib dein Passwort ein.");
            }
            if (empty(Status::read("error"))) {
                $user = $this->login->checkLogin($data);
                if (count($user) > 0) {
                    Session::set("logged_user", $user);
                    $this->redirect("profile");
                } else {
                    new Status("flash", "Benutzername oder Passwort ist falsch.");
                }
            } else {
                new Status("flash", "Bitte fülle beide Felder aus.");
            }
        }
    }

    /**
     * If Email Token is equal to database Token
     */
    private function checkValidToken()
    {
        if (isset($this->request["token"])) {
            if (count($this->login->getUserByToken($this->request["token"])) > 0) {
                if ($this->request["p"] == "firstlogin") {
                    $this->token = $this->request["token"];
                    if (isset($this->request["data"])) {
                        $this->firstLogin($this->request["data"]["Firstlogin"]);
                    }
                }
            } else {
                $this->redirect("login");
            }
        }
    }

    /**
     * If user creates his account, he has to set his password
     *
     * @param $userdata
     *
     * @throws Exception
     */
    private function firstLogin($userdata)
    {
        if (empty($userdata["password"]) || empty($userdata["re_password"])) {
            new Status("flash", "Bitte fülle beide Felder aus.");
        } else {
            if ($userdata["password"] == $userdata["re_password"]) {
                $pwhash = password_hash($userdata["password"], PASSWORD_DEFAULT, ["cost" => 12]);
                if ($this->login->setInitialPassword($pwhash, $this->token)) {
                    $user = $this->login->get("SELECT * FROM msonair_users WHERE user_password = :token",
                        [":token" => $pwhash]);
                    Mails::passwordChanged($user);
                    $this->redirect("login", "success");
                } else {
                    new Status("flash", "Ein Systemfehler ist auftereten. Bitte beschreibe uns dein Problem.");
                }

            } else {
                new Status("flash", "Die Passwörter stimmen nicht überein.");
            }
        }

    }

}