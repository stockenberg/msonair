<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 29.10.2016
 * Time: 21:44
 */

namespace src\model;


use src\core\Session;
use src\helpers\Mails;
use src\objects\Package;

class CouponModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function saveCoupon($data, $payed)
    {

        $SQL = "INSERT INTO msonair_coupons (coupon_gender, coupon_buyer_firstname, coupon_buyer_lastname, coupon_buyer_street, 
        coupon_buyer_postcode, coupon_buyer_city, coupon_buyer_email,
        coupon_buyer_phone, coupon_buyer_for_gender ,coupon_buyer_for_lastname, coupon_buyer_for_firstname, coupon_code, coupon_price, coupon_type, coupon_payed, coupon_payed_at, coupon_ht_teacher) 
        VALUES (:coupon_buyer_gender, :coupon_buyer_firstname, :coupon_buyer_lastname, :coupon_buyer_street, :coupon_buyer_postcode, 
        :coupon_buyer_city, :coupon_buyer_email, :coupon_buyer_phone, :coupon_buyer_for_gender,
        :coupon_buyer_for_lastname, :coupon_buyer_for_firstname, :coupon_code, :coupon_price, :coupon_type, :coupon_payed, :coupon_payed_at, :coupon_ht_teacher)";

        $this->set($SQL, [
            ":coupon_buyer_gender" => $data["gender"],
            ":coupon_buyer_firstname" => $data["firstname"],
            ":coupon_buyer_lastname" => $data["lastname"],
            ":coupon_buyer_street" => $data["street"],
            ":coupon_buyer_postcode" => $data["postcode"],
            ":coupon_buyer_city" => $data["city"],
            ":coupon_buyer_email" => $data["email"],
            ":coupon_buyer_phone" => $data["phone"],
            ":coupon_buyer_for_gender" => $data["gender_recipient"],
            ":coupon_buyer_for_lastname" => @$data["lastname_recipient"],
            ":coupon_buyer_for_firstname" => @$data["firstname_recipient"],
            ":coupon_type" => $data["type"],
            ":coupon_price" => (int) $data["package_price"],
            ":coupon_code" => $data["code"],
            ":coupon_payed" => $data["payed"],
            ":coupon_payed_at" => ($data["payed"] == 1) ? date("Y-m-d H:i:s", time()) : "",
            ":coupon_ht_teacher" => Session::get("coupon", "heavytone_teacher")
        ]);

        $coupon_id = $this->getLastInsertID();

        $data["package"][0]["package_name"] = $data["package_name"];
        $data["package"][0]["package_price"] = $data["package_price"];
        $data["teacher"] = Session::get("coupon", "heavytone_teacher");

        $invoice = new CouponInvoice($data, $data["payed"], 0, $coupon_id);
        Session::set("bank", $this->getLastInvoiceID());

        if ($payed == 1) {
            Mails::PaypalSofortCouponMail($data, $invoice->path, $invoice->filename);
        }
        if ($payed == 0) {
            Mails::PrepaidCouponMail($data, $invoice->path, $invoice->filename);
        }

    }

    public function getHTCouponCount()
    {
        $SQL = "SELECT coupon_ht_teacher FROM msonair_coupons";
        $res = $this->get($SQL);

        $array = ["sax" => 0, "guitar" => 0, "bass" => 0, "trumpet" => 0];

        foreach ($res as $k => $coupon) {
            if ($coupon["coupon_ht_teacher"] != "") {
                $array[$coupon["coupon_ht_teacher"]] += 1;
            }
        }

        return $array;
    }


    public function createCoupon(\src\objects\Coupon $coupon, Package $package)
    {


        $this->filename = "Coupon_" . $coupon->code . ".pdf";
        $this->path = __COUPONS__ . $this->filename;

        $data[0]["teacher"] = $package->getPackageName();
        $data[0]["coupon_code"] = $coupon->code;


        $pdf = new CouponPDF();
        $pdf->getData($data[0], $coupon, $package);

        $pdf->AliasNbPages();
        $pdf->AddPage("v", "a5");
        $pdf->SetFont("Arial");
        try {
            $pdf->Body();
            $pdf->Output("F", $this->path, true);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        Mails::couponPayed($coupon, null, null, $this->path, $this->filename);
        unlink($this->path);
    }

}