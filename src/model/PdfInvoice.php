<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 03.10.2016
	 * Time: 16:04
	 */

	namespace src\model;


	use src\core\User as Usr;
    use src\objects\Package;

    class PdfInvoice extends \FPDF
	{

		private $headerY;
        /**
         * @var Usr $data
         */
		private $data;
        /**
         * @var Package $package
         */
		private $package;
		public $path;
		private $invoiceID;
		private $prepaid;

		public function getData(Usr $user, $invoiceID, Package $package )
		{
			$this->data      = $user;
			$this->package = $package;
            //$heavytones_teacher = (!empty($this->data["teacher"])) ? "bei " . $this->data["teacher"] : "";
			$this->invoiceID = $invoiceID;
			$this->prepaid   = $user->getPayment();
		}

		public function Header()
		{
			$this->SetFont( 'Arial', 'B', 15 );
			// Move to the right
			$this->Cell( 80 );
			// Title
			//$this->Cell(30,10,ES,1,0,'C');

			$this->Image( $this->path . 'img/logo/musiclessons_logo.png', 12, 7, 70 );

			// Line break
			$this->Ln( 40 );
			$this->SetFont( 'Arial', '', 12 );
			$this->Ln( 12 );

			$this->MultiCell( 80, 5,
				ucfirst( utf8_decode( html_entity_decode( $this->data->getFirstname() ) ) ) . ' ' .
				ucfirst( utf8_decode( html_entity_decode( $this->data->getLastname() ) ) ) . "\n" .
				ucfirst( utf8_decode( html_entity_decode( $this->data->getStreet() ) ) ) . ' ' . "\n" .
				utf8_decode( html_entity_decode( $this->data->getPostcode() ) ) . ' ' .
				ucfirst( utf8_decode( html_entity_decode( $this->data->getCity() ) ) ), 0, '', false );

			$this->SetXY( 140, 52 );
			$this->MultiCell( 80, 5,
				utf8_decode( 'Musikschule On Air UG' . "\n" . '(haftungsbeschränkt)' . "\n" . '' . "\n" . 'Am Hange 86' . "\n" . '22844 Norderstedt' . "\n" . 'E-Mail: info@musiclessonsonair.de' ),
				0, '', false );
			$this->SetX( 10 );
			$this->Ln( 15 );
			$this->SetFontSize( 16 );
			$this->Cell( 45, 10, utf8_decode( 'Rechnung' ), 0, 0, '', false, '' );
			$this->Ln( 8 );
			$this->SetFontSize( 10 );
			$this->Cell( 45, 10, utf8_decode( 'Rechnungsdatum: ' . date( 'd.m.Y',
					time()) . ' | Rechnungsnummer: ' . $this->invoiceID ), 0, 0, '', false,
				'' );
			$this->headerY = $this->GetY();
		}

		public function TableBody( $header = array( 'Position', 'Artikel / Leistung', 'Anzahl', 'Preis pro Stunde' ) )
		{
			$this->SetY( $this->headerY );
			$this->Ln( 10 );

			// Column widths
			$w = array( 20, 110, 30, 30 );
			// Header
			$this->SetTextColor( 255, 255, 255 );
			$this->SetFillColor( 204, 18, 18 );
			$this->SetDrawColor( 204, 18, 18 );
			for ( $i = 0; $i < count( $header ); $i ++ )
			{
				$this->Cell( $w[ $i ], 7, $header[ $i ], 1, 0, 'L', 1 );
			}
			$this->Ln();
			// Data
			$this->SetTextColor( 0, 0, 0 );
			$count  = 1;
			$result = 0;
			$mwst   = 0;

            $price = str_replace( ',', '.', $this->package->getPackagePrice());
            $this->Cell( $w[0], 12, 1, 'B' );
            $this->Cell( $w[1], 12, utf8_decode( "Online-Unterricht bei " . $this->package->getPackageName() ), 'B' );
            $this->Cell( $w[2], 12, utf8_decode( $this->data->getLessonCount() . " x 60 Minuten" ), 'B' );
            $this->Cell( $w[3], 12,
                str_replace( '.', ',', number_format( ( $price / 1.19 ), 2 ) ) . ' ' . chr( 128 ) . '   ',
                'B', 0, 'R' );
            $this->Ln();
            $count ++;
            $result = $price * $this->data->getLessonCount();
            $mwst = $result - ( $result / 1.19 );


			// Closing line
			$this->Cell( array_sum( $w ), 0, '', 'T' );
			$this->headerY = $this->GetY();
			$this->Ln( 15 );
			$this->SetX( 120, $this->headerY + 10 );
			$this->Cell( 45, 10, '       Gesamtpreis ohne USt:                 ' . str_replace( '.', ',',
					number_format( $result / 1.19, 2, ",", ".") ) . ' ' . chr( 128 ), 0, 0, '', false, '' );
            $this->Ln( 5 );
            $this->SetX( 120, $this->headerY + 10 );
            $this->Cell( 45, 10, '             19% Umsatzsteuer:                   ' . str_replace( '.', ',',
					number_format( $mwst, 2 ) ) . ' ' . chr( 128 ), 0, 0, '', false, '' );
			$this->Ln( 10 );

			$this->SetFillColor( 204, 18, 18 );
			$this->SetTextColor( 255, 255, 255 );
			$this->Cell( 0, 10, 'Gesamt:                  ' . str_replace( '.', ',',
					number_format( $result, 2 ) ) . ' ' . chr( 128 ) . '    ', 0, 0, 'R', 1, '' );

		}

		public function Footer()
		{
			$this->SetTextColor( 0, 0, 0 );
			$this->SetY( - 115 );
			// Arial italic 8
			$this->SetFont( 'Arial', '', 11 );
			// Page number

			$this->SetFont( 'Arial', '', 12 );
			if ( $this->prepaid == __PREPAID__ )
			{
				$this->MultiCell( 180, 5,
					utf8_decode( 'Das Unterrichtsguthaben ist bis zum ' . date("d.m.Y", strtotime("+1 year")) . " gültig. \n" . 'Bitte überweisen Sie den Rechnungsbetrag unter Angabe der Rechnungsnummer ' . $this->invoiceID . ' bis zum ' . date( 'd.m.Y', strtotime( "+14 days" ) ) . ' auf folgendes Konto.' ),
					0, "L", false);
				$this->Ln( 12 );
				$this->MultiCell( 120, 5,
					utf8_decode( 'Kontoinhaber: Musikschule On Air UG (haftungsbeschränkt)' . "\n" . 'Kreditinstitut: Fidor-Bank' . "\n" . 'IBAN: DE55 7002 2200 0020 2222 98' . "\n" . 'BIC: FDDODEMMXXX' ),
					0, 'L', false );
			}
			$this->Ln( 5 );
			$this->Cell( 0, 10, utf8_decode( 'Vielen Dank für Ihre Buchung bei Musiclessons On Air.' ), 0,
				0, '', false, '' );
			$this->Ln( 10 );
			$this->SetY( - 43 );
			$this->SetX( 10 );
			$this->SetFont( 'Arial', '', 10 );
			$this->MultiCell( 60, 5,
				utf8_decode( 'Musikschule On Air UG (haftungsbeschränkt)' . "\n" . 'Am Hange 86' . "\n" . '22844 Norderstedt' . "\n" . "Geschäftsführer: Lars Seniuk" ),
				0, '', false );
			$this->SetXY( 50, - 43 );
			$this->MultiCell( 110, 5,
				utf8_decode( 'IBAN: DE55 7002 2200 0020 2222 98' . "\n" . 'BIC: FDDODEMMXXX' . "\n" . 'Kreditinstitut: Fidor-Bank' ),
				0, 'C', false );
			$this->SetXY( 150, - 43 );
			$this->MultiCell( 50, 5,
				utf8_decode( 'Amtsgericht Kiel.' . "\n" . 'HRB 15655 KI' . "\n" . 'Ust.IdNr: DE24025532' ), 0,
				'R', false );
			$this->Ln( 15 );
			$this->SetTextColor( 255, 255, 255 );
			$this->Cell( 0, 6, 'www.musiclessonsonair.de | info@musiclessonsonair.de', 0, 0, 'C', '#000', '' );
			$this->SetXY( 165, - 15 );
			$this->SetTextColor( 0, 0, 0 );
		}

	}