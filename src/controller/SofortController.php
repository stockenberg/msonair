<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 03.10.2016
	 * Time: 13:12
	 */

	namespace src\controller;


	use Sofort\SofortLib\Sofortueberweisung;
	use src\core\Core;
    use src\core\Session;

    class SofortController extends Core
	{
		private $configKey = "113319:233311:26978a1abc14fb12fa18a501bd42b78d";
		private $successURL = __SCRIPT__ . "?p=erfolg&token=sofort";
		private $abortUrl = __SCRIPT__ . "?p=abbruch";
		private $notifyUrl = "";

        public function registerURLS($succes, $abort)
        {
            $this->successURL = $succes;
            $this->abortUrl = $abort;
        }

		public function run( $amount, $reason, $reason2 = "" )
		{
			$sofort = new Sofortueberweisung( $this->configKey );
			$sofort->setAmount( $amount );
			$sofort->setCurrencyCode( "EUR" );
			$sofort->setReason( $reason, $reason2 );
			$sofort->setSuccessUrl( $this->successURL, true );
			$sofort->setAbortUrl( $this->abortUrl );
			// $Sofortueberweisung->setSenderSepaAccount('SFRTDE20XXX', 'DE06000000000023456789', 'Max Mustermann');
			// $Sofortueberweisung->setSenderCountryCode('DE');
			// $Sofortueberweisung->setNotificationUrl('YOUR_NOTIFICATION_URL', 'loss,pending');
			// $Sofortueberweisung->setNotificationUrl('YOUR_NOTIFICATION_URL', 'loss');
			// $Sofortueberweisung->setNotificationUrl('YOUR_NOTIFICATION_URL', 'pending');
			// $Sofortueberweisung->setNotificationUrl('YOUR_NOTIFICATION_URL', 'received');
			// $Sofortueberweisung->setNotificationUrl('YOUR_NOTIFICATION_URL', 'refunded');
			//$sofort->setNotificationUrl( $this->notifyUrl );
			//$Sofortueberweisung->setCustomerprotection(true);


			$sofort->sendRequest();

			if ( $sofort->isError() )
			{
				// SOFORT-API didn't accept the data
				echo $sofort->getError();
			}
			else
			{
                Session::set("formvalidation", "sofort", "true");

                // get unique transaction-ID useful for check payment status
				$transactionId = $sofort->getTransactionId();
				// buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
				$paymentUrl = $sofort->getPaymentUrl();

				header('Location: '.$paymentUrl);
				exit();
			}
		}
	}