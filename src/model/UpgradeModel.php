<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 08.10.2016
	 * Time: 12:15
	 */

	namespace src\model;


	use src\core\Session;

	class UpgradeModel extends Model
	{

		public function checkUpgradePrivileges( $payment )
		{
			if ( $payment == 1 )
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function upgrade( $data, $payment )
		{
			if ( $this->checkUpgradePrivileges( $payment ) )
			{
				$user = new User();
				$sql  = "UPDATE msonair_users SET user_lessoncount = :lessons WHERE user_id = :id";


				// just values
				$execArray = array(
					":id"      => Session::get( "logged_user", 0, "user_id" ),
					":lessons" => $user->getMyData()[0]["user_lessoncount"] + $data["package"][0]["package_livelessons"],
				);


				// SAVE user to db
				$this->set( $sql, $execArray );

				$invoice = new Invoice( $data, $payment, Session::get( "logged_user", 0, "user_id" ) );
                $SQL = "UPDATE msonair_invoices SET invoice_paydate = :paydate WHERE invoice_number = :invoice_number";
                $this->set($SQL, [":invoice_number" => $this->invoiceID . $this->getLastInvoiceID()[0]["invoice_id"], ":paydate" => date("Y-m-d H:i:s", time())]);


                // TODO "Upgrade Paypal Erfolgreich - Mail";
				//echo "Upgrade Paypal Erfolgreich - Mail";
				$_SESSION["register"] = array();
			}
			else
			{
				$invoice = new Invoice( $data, $payment, Session::get( "logged_user", 0, "user_id" ) );

                // TODO "Upgrade Vorkasse Erfolgreich - Mail";
                //echo "Upgrade Vorkasse Erfolgreich - Mail";
				$_SESSION["register"] = array();
			}
		}

	}