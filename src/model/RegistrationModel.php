<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 02.10.2016
	 * Time: 17:44
	 */

	namespace src\model;

	use src\core\Session;
    use src\core\Status;
    use src\helpers\Mails;

	class RegistrationModel extends Model
	{

        public $heavytones = array(
            "heavytones_full" => 2,
            "heavytones_half" => 1
        );

		public function __construct()
		{
			parent::__construct();
		}

		public function getPackages()
		{
			$sql = "SELECT * FROM msonair_packages";

			return $this->get( $sql );
		}

		public function getPackagesAsObjects(){
            $sql = "SELECT * FROM msonair_packages WHERE package_skill = :skill AND package_register_available = TRUE";

            return $this->getObjArray($sql, [":skill" => 2], "src\\objects\\Package");
        }

        public function getPackagesAsObjectsForCoupon(){
            $sql = "SELECT * FROM msonair_packages WHERE package_skill = :skill AND package_coupon_available = TRUE AND (package_booking_count < package_booking_count_max || package_booking_count_max IS NULL ) ORDER BY package_id DESC";

            return $this->getObjArray($sql, [":skill" => 2], "src\\objects\\Package");
        }

        public function registerCoupon($data)
        {
            $SQL = "SELECT * FROM msonair_coupons WHERE coupon_code = :coupon_code";
            $coupon = $this->get($SQL, [":coupon_code" => $data["code"]]);
            $finaldata = Session::get("register");
            $SQL = "SELECT * FROM msonair_packages WHERE package_id = :id";
            if(preg_match("/HT-/i", $coupon[0]["coupon_code"])){
                $finaldata["package"] = $this->get($SQL, [":id" => ($coupon[0]["coupon_type"] == "heavytones_half") ? 9 : 10]);
            }else{
                $finaldata["package"] = $this->get($SQL, [":id" => 3]);
            }
            if($coupon[0]["coupon_payed"] == 0){
                new Status("flash", "Der Gutschein wurde noch nicht bezahlt und kann nicht eingelöst werden.");
            }else if($coupon[0]["coupon_activated"] == 1){
                new Status("flash", "Der Gutschein wurde bereits aktiviert.");
            }
            else {
                $finaldata["coupon"] = "true";
                $this->saveUser($finaldata, 1);
                $SQL = "UPDATE msonair_coupons SET coupon_activated = :activated WHERE coupon_code = :coupon_code";
                $this->set($SQL, [":activated" => 1, ":coupon_code" => $data["code"]]);
                Session::set("coupon" , "true");
                $this->redirect("registrierung", "step=success");
            }
		}

		public function saveUser( $data, $payment )
		{

			$sql = "INSERT INTO msonair_users 
                (user_firstname, user_lastname, user_email, user_username, user_password, 
                user_birthdate, user_street, user_postcode, user_city, user_gender, 
                user_intrested_in, user_package_id, user_lessoncount, user_completed_payment, user_skill) 
                VALUES (:user_firstname, :user_lastname, :user_email, :user_username, :user_password, 
                :user_birthdate, :user_street, :user_postcode, :user_city, :user_gender, 
                :user_intrested_in, :user_package_id, :user_lessoncount, :user_completed_payment, :user_skill)";

			// Save bcrypt hash and Token
			$passwort      = password_hash( rand( 1, 2000 ) . time(), PASSWORD_DEFAULT, [ "cost" => 12 ] );
			$data["token"] = $passwort;

			// just values
			$execArray = array(
				":user_firstname"         => $data["firstname"],
				":user_lastname"          => $data["lastname"],
				":user_email"             => $data["email"],
				":user_username"          => $data["username"],
				":user_password"          => $passwort,
				":user_birthdate"         => $data["birth_dt"]["day"] . "." . $data["birth_dt"]["month"] . "." . $data["birth_dt"]["year"],
				":user_street"            => $data["street"],
				":user_postcode"          => $data["postcode"],
				":user_city"              => $data["city"],
				":user_gender"            => $data["gender"],
				":user_intrested_in"      => $data["intrested_in"],
				":user_package_id"        => $data["package"][0]["package_id"],
				":user_lessoncount"       => ( $payment == 0 ) ? 0 : $data["package"][0]["package_livelessons"],
				":user_completed_payment" => $payment,
				":user_skill"             => $data["package"][0]["package_skill"]
			);

			// SAVE user to db
			$this->set( $sql, $execArray );

			// Invoice SAVE Routine

			// If Paypal or Sofort was used
			if ( $payment == 1 )
			{
                if($data["coupon"] != "true"){
                    $invoice = new Invoice( $data, $payment, $this->getLastInsertID() );
                    Mails::PaymentRecievedMailPP( $data, $invoice->path, $invoice->filename );
                }else{
                    Mails::PaymentRecievedMailCoupon( $data );
                }
			} // If "Vorkasse" was used
			elseif ( $payment == 0 )
			{
                $invoice = new Invoice( $data, $payment, $this->getLastInsertID() );
                Mails::PrepaidPaymentMail( $data, $invoice->path, $invoice->filename );
			}
		}


	}