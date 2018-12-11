<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 28.11.16
 * Time: 23:19
 */

namespace src\model;


use src\core\Status;
use src\helpers\Mails;

class ForgotPWModel extends Model
{

    public function generateResetLink($data)
    {

        $SQL = "SELECT * FROM msonair_users WHERE user_username = :username AND user_email = :email";

        $user = $this->get($SQL, [
            ":username" => $data["username"],
            ":email" => $data["email"]
        ]);

        if(!empty($user)){
            Mails::forgotPassword($user[0]);
            new Status("flash", "Dein Passwort zurücksetzen Link wurde dir per E-Mail zugesandt.");
        }else{
            new Status("flash", "Benutzername und E-Mail-Adresse stimmen nicht überein.");
        }


    }

}