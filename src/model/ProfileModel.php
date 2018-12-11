<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 08.10.2016
 * Time: 23:48
 */

namespace src\model;


use src\core\Session;
use src\helpers\Mails;
use src\objects\Package;

class ProfileModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function changePW($pass)
    {
        $SQL = "UPDATE msonair_users SET user_password = :pass WHERE user_id = :id";

        $this->set($SQL, [":pass" => $pass, ":id" => Session::getID()]);
        return true;
    }

    public function getPassword()
    {
        $SQL = "SELECT user_password FROM msonair_users WHERE user_id = :id";

        return $this->get($SQL, [":id" => Session::getID()]);
    }

    public function getAllInvoicesWithUserdetails()
    {
        $sql = "SELECT packages.*, invoice.*, users.user_firstname, users.user_lastname, users.user_email, users.user_skill, users.user_id
                FROM msonair_invoices AS invoice, msonair_users AS users, msonair_packages AS packages
                WHERE invoice.invoice_user_id = users.user_id AND packages.package_id = invoice.invoice_package_id ORDER BY invoice.invoice_created DESC";

        return $this->get($sql);
    }

    public function getAllCoupons()
    {
        $SQL = "SELECT c.*, i.* FROM msonair_coupons as c, msonair_invoices as i WHERE c.coupon_id = i.invoice_coupon ORDER BY c.coupon_created DESC";

        return $this->get($SQL, [

        ]);
    }

    public function confirmPaymentForCoupons($data)
    {

        $couponModel = new CouponModel();
        $final = array();
        $SQL = "UPDATE msonair_invoices as i, msonair_coupons as c SET i.invoice_paydate = :now, c.coupon_payed = :now WHERE i.invoice_coupon = :id AND c.coupon_id = :id";
        foreach($data as $switch => $id){
            $this->set($SQL, [
               ":now" => date("y-m-d H:i:s", time()),
                ":id" => $id,
                ":payed" => 1
            ]);

            $SQL_COUP = "SELECT * FROM msonair_coupons WHERE coupon_id = :id";

            /**
             * @var \src\objects\Coupon $coupon
             */
            $coupon = $this->getObj($SQL_COUP, [
               ":id" => $id
            ], \src\objects\Coupon::class);

            $sql = "SELECT * FROM msonair_packages WHERE package_id = :ID";

            /**
             * @var Package $package
             */
            $package = $this->getObj($sql, [":ID" => $coupon->packageId], Package::class);

            $couponModel->createCoupon($coupon, $package);
        }



    }

    public function confirmPaymentForUserAndInvoice($request)
    {
        $sql = "UPDATE msonair_users 
                SET user_completed_payment = :completed 
                WHERE user_id = :id";

        foreach ($request as $k => $invoice) {
            if (isset($invoice["invoiceID"])) {
                $this->set($sql, array(
                    ":completed" => 1,
                    ":id" => $invoice["userID"]
                ));
            }
        }
        $sql = "UPDATE msonair_invoices 
                SET invoice_paydate = :dates 
                WHERE invoice_id = :id 
                AND invoice_user_id = :user_id";
        foreach ($request as $k => $value) {
            if (isset($value["invoiceID"])) {
                $this->set($sql, array(
                    ":id" => $value["invoiceID"],
                    ":dates" => date("Y-m-d H:i:s", time()),
                    ":user_id" => $value["userID"]
                ));
                $SQL_user = "SELECT * FROM msonair_users WHERE user_id = :id";
                $user = $this->get($SQL_user, [":id" => $value["userID"]]);
                Mails::paymentDone($user[0]);
            }

        }


    }

}