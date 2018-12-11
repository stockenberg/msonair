<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 10.05.17
 * Time: 20:43
 */

namespace src\model;


class Newsletter extends Model
{

    public function save(\src\core\User $user)
    {
        $SQL = "SELECT * FROM msonair_newsletter WHERE newsletter_email = :email";
        $res = $this->get($SQL, [":email" => $user->getEmail()]);

        if(count($res) > 0){
            $_POST["success"] = "Du bist bereits für den Newsletter angemeldet.";
            return false;
        }

        $SQL = "INSERT INTO msonair_newsletter (newsletter_email) VALUES (:email)";
        $this->set($SQL, [":email" => $user->getEmail()]);

        return true;
    }

}