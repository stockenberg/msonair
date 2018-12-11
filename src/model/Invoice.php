<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 08.10.2016
 * Time: 01:21
 */

namespace src\model;


use src\core\User as Usr;
use src\objects\Package;

class Invoice extends Model
{

    public $path;
    public $filename;
    public $time;
    public $invoiceID;

    public function __construct(\src\core\User $user)
    {
        parent::__construct();
        $this->createAndSaveInvoice($user);
    }

    public function getPackagesAsObject(int $id): Package
    {
        $sql = "SELECT * FROM msonair_packages WHERE package_id = :id";

        return $this->getObj($sql, [":id" => $id], "src\\objects\\Package");
    }

    public function createAndSaveInvoice(\src\core\User $user)
    {
        $package = $this->getPackagesAsObject($user->getPackageId());

        // get next invoice ID
        $this->invoiceID .= $this->getLastInvoiceID()[0]["invoice_id"] + 1;
        // Create Invoice PDF with given credentials
        $this->createPDF($user, $package);
        // Save Invoice to Database
        $this->saveInvoiceToDB($user->getId(),
            $this->invoiceID, $this->filename,
            $package->getPackagePrice(),
            $package->getPackageId(),
            $user->getPayment()
        );
    }


    private function createPDF(\src\core\User $user, Package $package)
    {
        $this->filename = "Rechnung_" . $this->invoiceID . ".pdf";
        $this->path = __INVOICES__ . $this->filename;

        $pdf = new PdfInvoice();
        $pdf->getData($user, $this->invoiceID, $package);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->TableBody();
        // $pdf->Output();

        $pdf->Output("F", $this->path, true);
    }

    protected function saveInvoiceToDB($userid, $invoiceID, $filename, $price, $package_id, $payment)
    {
        if ($payment == __PAYPAL__) {
            $this->time = date("Y-d-m H:i:s", time());
        }
        if ($payment == __PREPAID__) {
            $this->time = '0000-00-00 00:00:00';
        }
        $sql = "INSERT INTO msonair_invoices 
                (invoice_number, invoice_user_id, 
                invoice_path, invoice_total, invoice_package_id, invoice_paydate) 
                VALUES 
                (:invoice_number, :invoice_user_id, 
                :invoice_path, :invoice_total, :invoice_package_id, :invoice_paydate)";
        $execArr = array(
            ":invoice_number" => $invoiceID,
            ":invoice_user_id" => $userid,
            ":invoice_path" => $filename,
            ":invoice_total" => $price,
            ":invoice_package_id" => $package_id,
            ":invoice_paydate" => $this->time
        );

        $this->set($sql, $execArr);
    }


}