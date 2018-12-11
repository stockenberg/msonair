<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 08.10.2016
	 * Time: 01:21
	 */

	namespace src\model;


	use src\objects\Package;

    class CouponInvoice extends Model
	{

		public $path;
		public $filename;
		public $time;

		public function __construct( \src\objects\Coupon $coupon)
		{
			parent::__construct();
			$this->createAndSaveInvoice( $coupon);
		}

		public function createAndSaveInvoice( \src\objects\Coupon $coupon)
		{
			// get next invoice ID
			$this->invoiceID .= $this->getLastInvoiceID()[0]["invoice_id"] + 1;
            // Create Invoice PDF with given credentials

			$this->createPDF( $coupon );
			// Save Invoice to Database

			$this->saveInvoiceToDB(
				$this->invoiceID, $this->filename,
				$coupon
			);
		}


		private function createPDF( \src\objects\Coupon $coupon )
		{
		    $db = new Model();

		    $sql = "SELECT * FROM msonair_packages WHERE package_id = :id";
            /**
             * @var Package $package
             */
		    $package = $db->getObj($sql, [":id" => $coupon->packageId], Package::class);

		    $coupon->price = $package->getPackagePrice() * $coupon->lessonCount;

			$this->filename = "Gutschein_Rechnung_" . $this->invoiceID . ".pdf";
			$this->path     = __INVOICES__ . $this->filename;

            $pdf = new PdfCouponInvoice();
            $pdf->getData( $coupon, $this->invoiceID, $package);
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->TableBody();
			$pdf->Output( "F", $this->path, true );
		}

		protected function saveInvoiceToDB($invoiceID, $filename, \src\objects\Coupon $coupon)
		{
			if ( $coupon->payment == "paypal" )
			{
				$this->time = date( "Y-d-m H:i:s", time() );
			}
			elseif ( $coupon->payment == "prepaid" )
			{
				$this->time = '0000-00-00 00:00:00';
			}
			$sql     = "INSERT INTO msonair_invoices 
                (invoice_number,
                invoice_path, invoice_total, invoice_package_id, invoice_paydate, invoice_coupon) 
                VALUES 
                (:invoice_number, 
                :invoice_path, :invoice_total, :invoice_package_id, :invoice_paydate, :invoice_coupon)";
			$execArr = array(
				":invoice_number"     => $invoiceID,
				":invoice_path"       => $filename,
				":invoice_total"      => number_format($coupon->price, 2, ",", "."),
				":invoice_package_id" => $coupon->packageId,
				":invoice_paydate"    => $this->time,
				":invoice_coupon"    => $coupon->id
			);

			$this->set( $sql, $execArr );
		}


	}