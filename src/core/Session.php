<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 06.10.2016
 * Time: 23:29
 */

namespace src\core;


class Session extends Core
{

    public function __construct()
    {
        parent::__construct();



        if (!isset($_SESSION["lastdone"])) {
            session_name("msonair");
            session_start();
        }

        $this->checkSession();
        $this->lastdone();
    }

    private function lastdone()
    {
        $_SESSION["lastdone"] = time();
    }

    public static function set($firstKey, $scndKey = false, $thirdKey = false, $fourthKey = false)
    {
        if ($fourthKey) {
            $_SESSION[$firstKey][$scndKey][$thirdKey] = $fourthKey;
        } elseif ($thirdKey) {
            $_SESSION[$firstKey][$scndKey] = $thirdKey;
        } elseif ($scndKey) {
            $_SESSION[$firstKey] = $scndKey;
        } elseif ($firstKey) {
            $_SESSION[] = $firstKey;
        }
    }

    public static function getStatus()
    {
        return self::get("logged_user", 0, "user_status");
    }

    public static function getID()
    {
        return self::get("logged_user", 0, "user_id");
    }

    public static function getCompletedPayment()
    {
        return self::get("logged_user", 0, "user_completed_payment");
    }

    public static function get($firstKey, $scndKey = false, $thirdKey = false, $fourthKey = false)
    {
        if ($fourthKey && isset($_SESSION[$firstKey][$scndKey][$thirdKey][$fourthKey])) {
            return $_SESSION[$firstKey][$scndKey][$thirdKey][$fourthKey];
        } elseif ($thirdKey && isset($_SESSION[$firstKey][$scndKey][$thirdKey])) {
            return $_SESSION[$firstKey][$scndKey][$thirdKey];
        } elseif ($scndKey && isset($_SESSION[$firstKey][$scndKey])) {
            return $_SESSION[$firstKey][$scndKey];
        } elseif ($firstKey && isset($_SESSION[$firstKey])) {
            return $_SESSION[$firstKey];
        }
    }

    public static function resetSession()
    {
        session_unset();
        session_destroy();
    }

    public function checkSession()
    {
        if (isset($this->request["logout"])) {
            if ($this->request["logout"] == "true") {
                self::resetSession();
                $this->redirect("startseite");
            }
        }

    }

}