<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 26.10.2016
 * Time: 22:39
 */

namespace src\model;


use src\helpers\Mails;

class LecturerManagementModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLecturers()
    {
        $SQL = "SELECT * FROM msonair_users WHERE user_status = :status";

        return $this->get($SQL, [":status" => __TEACHER__]);
    }

    public function saveLecturer( $data )
    {

        $sql = "INSERT INTO msonair_users 
                (user_firstname, user_lastname, user_email, user_username, user_password, 
                user_birthdate, user_street, user_postcode, user_city, user_gender, 
                user_intrested_in, user_completed_payment, user_skill, user_status) 
                VALUES (:user_firstname, :user_lastname, :user_email, :user_username, :user_password, 
                :user_birthdate, :user_street, :user_postcode, :user_city, :user_gender, 
                :user_intrested_in, :user_completed_payment, :user_skill, :user_status)";

        // Save bcrypt hash and Token
        $passwort      = password_hash( rand( 1, 2000 ) . time(), PASSWORD_DEFAULT, [ "cost" => 12 ] );
        $data["token"] = $passwort;

        // just values
        $execArray = array(
            ":user_firstname"         => $data["user_firstname"],
            ":user_lastname"          => $data["user_lastname"],
            ":user_email"             => $data["user_email"],
            ":user_username"          => $data["user_username"],
            ":user_password"          => $passwort,
            ":user_birthdate"         => $data["user_birthdate"],
            ":user_street"            => $data["user_street"],
            ":user_postcode"          => $data["user_postcode"],
            ":user_city"              => $data["user_city"],
            ":user_gender"            => $data["user_gender"],
            ":user_intrested_in"      => $data["user_intrested_in"],
            ":user_completed_payment" => 1,
            ":user_skill"             => $data["user_skill"],
            ":user_status"            => $data["user_status"]
        );

        // SAVE user to db
        $this->set( $sql, $execArray );
        Mails::newLecturer($data);
    }

}