<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 03.10.2016
	 * Time: 12:07
	 */

	namespace src\controller;


	use PayPal\Api\Amount;
    use PayPal\Api\Details;
    use PayPal\Api\Item;
	use PayPal\Api\ItemList;
	use PayPal\Api\Payer;
	use PayPal\Api\Payment;
    use PayPal\Api\PaymentExecution;
    use PayPal\Api\RedirectUrls;
	use PayPal\Api\Transaction;
	use PayPal\Auth\OAuthTokenCredential;
	use PayPal\Rest\ApiContext;
	use src\core\Core;
    use src\core\User;

    class PaypalController
	{

		public $redirectUrl;
		public $cancleUrl;

		private $clientId = __PPCLIENTID__;
		private $clientSecret = __PPCLIENTSECRET__;

		public function __construct()
		{
			$this->redirectUrl = __SCRIPT__ . "?p=erfolg&success=true";
			$this->cancleUrl   = __SCRIPT__ . "?p=abbruch";
		}

		public function getCredentials()
		{
			return $this->setCredentials();
		}

		public function setItem( $article, $quantity, $articlenumber, $price )
		{
			$this->price = $price;
			$item        = new Item();
			$item->setName( $article )
			     ->setCurrency( 'EUR' )
			     ->setQuantity( $quantity )
			     ->setSku( $articlenumber )// Similar to `item_number` in Classic API
			     ->setPrice( $price );

			return $item;

		}

		public function setAmount( $price )
		{
			$amount = new Amount();
			$amount->setCurrency( "EUR" )
			       ->setTotal( $price );

			return $amount;
		}

		public function setItemList( $item )
		{
			$itemList = new ItemList();
			$itemList->setItems( array( $item ) );

			return $itemList;
		}

		public function setup()
		{
			$payer = new Payer();
			$payer->setPaymentMethod( "paypal" );

			return $payer;
		}

		public function redirect()
		{
			$redirect = new RedirectUrls();
			$redirect->setReturnUrl( $this->redirectUrl )
			         ->setCancelUrl( $this->cancleUrl );

			return $redirect;
		}

		public function setPayment( $payer, $redirectUrls, $transaction )
		{
			$payment = new Payment();
			$payment->setIntent( "sale" )
			        ->setPayer( $payer )
			        ->setRedirectUrls( $redirectUrls )
			        ->setTransactions( array( $transaction ) );

			return $payment;
		}

		public function setupTransaction( $description, $itemList, $amount )
		{
			$transaction = new Transaction();
			$transaction->setAmount( $amount )
			            ->setItemList( $itemList )
			            ->setDescription( $description )
			            ->setInvoiceNumber( uniqid() );

			return $transaction;
		}

		private function setCredentials()
		{
			// ### Api context
			// Use an ApiContext object to authenticate
			// API calls. The clientId and clientSecret for the
			// OAuthTokenCredential class can be retrieved from
			// developer.paypal.com

			$apiContext = new ApiContext(
				new OAuthTokenCredential(
					$this->clientId,
					$this->clientSecret
				)
			);

			// Comment this line out and uncomment the PP_CONFIG_PATH
			// 'define' block if you want to use static file
			// based configuration

			$apiContext->setConfig(
				array(
                    'mode' => PPSTATE,
                    'log.LogEnabled' => true,
                    'log.FileName' => '../PayPal.log',
                    'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                    'cache.enabled' => true,
					// 'http.CURLOPT_CONNECTTIMEOUT' => 30
					// 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
					//'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
				)
			);

			// Partner Attribution Id
			// Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
			// To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
			// $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');

			return $apiContext;
		}

		public function executePayment(float $total){
            if (isset($_GET['success']) && $_GET['success'] == 'true') {
                $apiContext = $this->getCredentials();
                // Get the payment Object by passing paymentId
                // payment id was previously stored in session in
                // CreatePaymentUsingPayPal.php
                $paymentId = $_GET['paymentId'];
                $payment = Payment::get($paymentId, $apiContext);

                // ### Payment Execute
                // PaymentExecution object includes information necessary
                // to execute a PayPal account payment.
                // The payer_id is added to the request query parameters
                // when the user is redirected from paypal back to your site
                $execution = new PaymentExecution();
                $execution->setPayerId($_GET['PayerID']);

                // ### Optional Changes to Amount
                // If you wish to update the amount that you wish to charge the customer,
                // based on the shipping address or any other reason, you could
                // do that by passing the transaction object with just `amount` field in it.
                // Here is the example on how we changed the shipping to $1 more than before.
                $transaction = new Transaction();
                $amount = new Amount();
                /*
                $details = new Details();

                $details->setShipping(2.2)
                    ->setTax(1.3)
                    ->setSubtotal(17.50);
                */
                $amount->setCurrency('EUR');
                $amount->setTotal($total);
                //$amount->setDetails($details);
                $transaction->setAmount($amount);

                // Add the above transaction object inside our Execution object.
                $execution->addTransaction($transaction);

                try {
                    // Execute the payment
                    // (See bootstrap.php for more on `ApiContext`)
                    $result = $payment->execute($execution, $apiContext);

                    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                    //ResultPrinter::printResult("Executed Payment", "Payment", $payment->getId(), $execution, $result);

                    try {
                        $payment = Payment::get($paymentId, $apiContext);
                    } catch (\Exception $ex) {
                        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                        //ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
                        exit(1);
                    }
                } catch (\Exception $ex) {
                    echo '<pre>';
                    print_r($ex);
                    echo '</pre>';
                    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                    //ResultPrinter::printError("Executed Payment", "Payment", null, null, $ex);
                    exit(1);
                }

                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                //ResultPrinter::printResult("Get Payment", "Payment", $payment->getId(), null, $payment);

                return $payment;
            } else {
                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                //ResultPrinter::printResult("User Cancelled the Approval", null);
                exit;
            }
        }

	}