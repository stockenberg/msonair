<?php

	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 30.09.2016
	 * Time: 12:35
	 */

	namespace src\core;

	use src\view\View;

	class Core
	{
        public $ppText = [
            "heavytones_full" => [
                "name" => "Heavytones Gutschein für 60 Minuten",
                "articlenr" => "G3",
                "price" => "90,00",
                "id" => 10,
            ],
            "heavytones_half" => [
                "name" => "Heavytones Gutschein für 30 Minuten",
                "articlenr" => "G2",
                "price" => "50,00",
                "id" => 9,
            ],
            "regular" => [
                "name" => "Regulärer Gutschein",
                "articlenr" => "G1",
                "price" => "45,00",
                "id" => 3,

            ],
        ];

        public $heavytones = [
            "sax" => "Thorsten Skringer (Saxophon)",
            "trumpet" => "Rüdiger Baldauf (Trompete)",
            "bass" => "Krischan Frehse (Bass)",
            "guitar" => "Hanno Busch (Gitarre)"
        ];

        public $data;
		protected $page;
		protected $request;
		private $whitelist = [
			"buchung",
			"dozenten",
			"instrumente",
			"kontakt",
			"konzept",
			"news",
			"preise",
			"startseite",
			"team",
			"technik",
			"registrierung",
			"login",
			"firstlogin",
			"upgrade",
            "gutschein",
            "service",
            "erfolg",
            "abbruch",
            "faq",
            "agb",
            "impressum",
            "datenschutz",
            "passwort-vergessen"
		];

		private $backend = [
			"profile",
			"manage-students",
            "manage-videos",
            "manage-documents",
            "manage-calendar",
            "manage-lecturers",
            "kalender",
            "dateien",
            "videos",
            "unterrichtsraum",
            "raum"
		];

		private $home = "startseite";

		public function __construct()
		{
			$this->request = array_merge( $_GET, $_POST );
		}


		protected function loadValidatedPages( $paymentConfirmed = 0 )
		{
			if ( ! empty( Session::get( "logged_user", 0 ) ) )
			{
				if ( isset( $this->request["p"] ) )
				{
					if ( in_array( $this->request["p"], $this->whitelist ) || in_array( $this->request["p"],
							$this->backend )
					)
					{
						if ( $paymentConfirmed == 1 )
						{
							$this->page = $this->request["p"];
						}
						else
						{
							if ( $this->page != "profile")
							{
								$this->page = "profile";
							}
							if(isset($_GET["success"]) || isset($_GET["prepaid"])){
							    $this->page = "erfolg";
                            }
						}
					}
					else
					{
						$this->page = $this->home;
					}
				}
				else
				{
					$this->page = $this->home;
				}
			}
			else
			{
				if ( isset( $this->request["p"] ) )
				{
					if ( in_array( $this->request["p"], $this->whitelist ) )
					{

						$this->page = $this->request["p"];
					}
					else
					{
						$this->page = $this->home;
					}
				}
				else
				{
					$this->page = $this->home;
				}
			}
		}

		protected function redirect( $p, $scnd = false )
		{
			if ( $scnd )
			{
				header( "Location: " . __BASE__ . "?p=" . $p . "&" . $scnd );
				exit();
			}
			else
			{
				header( "Location: " . __BASE__ . "?p=" . $p );
				exit();
			}
		}

        public function __set($key, $value)
        {
            $this->data[$key] = $value;
		}

        public function __get($key)
        {
            return $this->data[$key];
		}
	}