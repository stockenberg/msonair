<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 05.05.17
 * Time: 11:58
 */

namespace src\model;


use src\core\Registration;

class Coupon extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function  store(\src\objects\Coupon $coupon)
    {



        $sql = "SELECT * FROM msonair_packages WHERE package_id = :id";

        $price = $this->get($sql, [":id" => $coupon->packageId])[0]["package_price"];
        $price = (float) $coupon->lessonCount * (float) $price;


            $SQL = "INSERT INTO msonair_coupons (coupon_code, coupon_type, coupon_price, coupon_gender, coupon_firstname, coupon_lastname, coupon_street, coupon_city, coupon_postcode, coupon_email, coupon_phone, coupon_for_gender, coupon_for_lastname, coupon_for_firstname, coupon_active, coupon_lessonCount, coupon_packageId) 
    VALUES 
    (:coupon_code, :coupon_type, :coupon_price, :coupon_gender, :coupon_firstname, :coupon_lastname, :coupon_street, :coupon_city, :coupon_postcode, :coupon_email, :coupon_phone, :coupon_friends_gender, :coupon_lastname_recipient, :coupon_firstname_recipient, :coupon_active, :coupon_lessonCount, :coupon_packageId)";


        $this->set($SQL, [
            ":coupon_code" => substr(md5(rand() . password_hash(date("d.m.y H:i:s", time()), PASSWORD_DEFAULT, ["cost" => 12])), 0, 10),
        ":coupon_type" => "regular",
        ":coupon_price" => $price,
        ":coupon_gender" => $coupon->gender,
        ":coupon_firstname" => $coupon->firstname,
        ":coupon_lastname" => $coupon->lastname,
        ":coupon_street" => $coupon->street,
        ":coupon_city" => $coupon->city,
        ":coupon_postcode" => $coupon->postcode,
        ":coupon_email" => $coupon->email,
        ":coupon_phone" => $coupon->phone,
        ":coupon_friends_gender" => $coupon->friends_gender,
        ":coupon_lastname_recipient" => $coupon->lastname_recipient,
        ":coupon_firstname_recipient" => $coupon->firstname_recipient,
        ":coupon_active" => 0,
        ":coupon_lessonCount" => $coupon->lessonCount,
        ":coupon_packageId" => $coupon->packageId
        ]);

        Registration::packagePlusOne($coupon->packageId);



    }

    public function storePayed(\src\objects\Coupon $coupon){
        $sql = "SELECT * FROM msonair_packages WHERE package_id = :id";

        $price = $this->get($sql, [":id" => $coupon->packageId])[0]["package_price"];
        $price = (float) $coupon->lessonCount * (float) $price;

        $SQL = "INSERT INTO msonair_coupons (coupon_code, coupon_type, coupon_price, coupon_gender, coupon_firstname, coupon_lastname, coupon_street, coupon_city, coupon_postcode, coupon_email, coupon_phone, coupon_for_gender, coupon_for_lastname, coupon_for_firstname, coupon_payed, coupon_active, coupon_lessonCount, coupon_packageId) 
    VALUES 
    (:coupon_code, :coupon_type, :coupon_price, :coupon_gender, :coupon_firstname, :coupon_lastname, :coupon_street, :coupon_city, :coupon_postcode, :coupon_email, :coupon_phone, :coupon_friends_gender, :coupon_lastname_recipient, :coupon_firstname_recipient, :coupon_payed, :coupon_active, :coupon_lessonCount, :coupon_packageId)";
        $code = substr(md5(rand() . password_hash(date("d.m.y H:i:s", time()), PASSWORD_DEFAULT, ["cost" => 12])), 0, 10);
        $this->set($SQL, [
            ":coupon_code" =>$code,
            ":coupon_type" => "regular",
            ":coupon_price" => $price,
            ":coupon_gender" => $coupon->gender,
            ":coupon_firstname" => $coupon->firstname,
            ":coupon_lastname" => $coupon->lastname,
            ":coupon_street" => $coupon->street,
            ":coupon_city" => $coupon->city,
            ":coupon_postcode" => $coupon->postcode,
            ":coupon_email" => $coupon->email,
            ":coupon_phone" => $coupon->phone,
            ":coupon_friends_gender" => $coupon->friends_gender,
            ":coupon_lastname_recipient" => $coupon->lastname_recipient,
            ":coupon_firstname_recipient" => $coupon->firstname_recipient,
            ":coupon_payed" => date("Y-m-d H:i:s", time()),
            ":coupon_active" => 0,
            ":coupon_lessonCount" => $coupon->lessonCount,
            ":coupon_packageId" => $coupon->packageId
        ]);

        Registration::packagePlusOne($coupon->packageId);


        return $code;
    }

}