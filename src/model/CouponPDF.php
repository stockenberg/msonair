<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 11/20/16
 * Time: 8:19 PM
 */

namespace src\model;


use src\core\Session;
use src\helpers\Helper;
use src\objects\Package;

class CouponPDF extends \FPDF
{

    private $firstname;
    private $lastname;
    public $data;
    private $anrede;
    private $text;
    private $datum;
    private $onlineLessons;


    public function getData($data, \src\objects\Coupon $coupon, Package $package)
    {


        $this->data = $data;

        $this->anrede = Helper::translateGenderWithGreeting($coupon->for_gender ?? $coupon->gender);

        if($coupon->lessonCount > 1){
            $this->onlineLessons = "Online-Unterrichtseinheiten ";
        }else{
            $this->onlineLessons = "Online-Unterrichtseinheit ";
        }




        $date = ($package->getPackageDeadline() === NULL ) ? date("d.m.Y", time() + (60*60*24*365)) : date("d.m.Y", strtotime($package->getPackageDeadline()));

        $this->text = "mit folgendem Gutscheincode erhalten Sie " . $coupon->lessonCount . " " . $this->onlineLessons  . "à"." 60 Minuten bei " . utf8_decode($this->data["teacher"]) . " über Musiclessons On Air.";
        $this->datum = 'Einzulösen ist der Gutschein bis zum '. $date .' auf www.musiclessonsonair.de';


        $this->firstname = ($coupon->for_firstname == "") ? $coupon->firstname : $coupon->for_firstname;
        $this->lastname = ($coupon->for_lastname == "") ? $coupon->lastname : $coupon->for_lastname;

    }

    public function Header()
    {
        $this->Image('img/logo/musiclessons_logo.png', 12, 7, 60);
    }

    public function Body()
    {

        $this->SetY(42);
        $this->SetTextColor(204, 18, 18);
        $this->SetFontSize(20);
        $this->Cell(0, 0, 'Gutschein');
        $this->Ln(13);
        $this->SetTextColor(80, 80, 80);
        $this->SetFontSize(11);
        $this->Cell(0, 6, utf8_decode($this->anrede . " " . $this->lastname .", "));
        $this->Ln(9);
        $this->MultiCell(0, 6, utf8_decode($this->text));
        $this->Ln(6);
        $this->Cell(58, 0, utf8_decode($this->datum));
        $this->Ln(6);
        $this->Ln(6);
        $this->SetFillColor(230, 230, 230);
        $this->SetTextColor(204, 18, 18);
        $this->SetFont('Arial', 'B');
        $this->Cell(0, 30, 'Gutscheincode: ' . $this->data["coupon_code"] . '', 0, 0, 'C', 1);
    }


}