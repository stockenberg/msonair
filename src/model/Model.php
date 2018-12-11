<?php
	namespace src\model;

	use src\core\Core;
	use src\core\Database;

    class Model extends Core
	{

		use Database;
		protected $db;
		public $invoiceID;
        protected $user_id;
        protected $user_name;

        public $labels = [
            "user_id" => "ID",
            "user_firstname" => "Vorname",
            "user_lastname" => "Nachname",
            "user_username" => "Benutzername",
            "user_email" => "E-Mail-Adresse",
            "user_birthdate" => "Geburtsdatum",
            "user_street" => "Straße",
            "user_postcode" => "Postleitzahl",
            "user_city" => "Stadt",
            "user_gender" => "Geschlecht (male / female)",
            "user_intrested_in" => "Instrument (trumpet, sax, guitar, piano, voice)",
            "user_package_id" => "Paket ID",
            "user_lessoncount" => "Live-Unterrichte",
            "user_completed_payment" => "Bezahlt Ja = 1, Nein = 0",
            "user_status" => "Status: Admin = 1, Lehrer = 2, Schüler = 3",
            "user_skill" => "Normal = 2, Heavytones = 5"
        ];

		public function __construct()
		{
			parent::__construct();
            $this->db        = self::getDBInstance();
			$this->invoiceID = date( "Y" ) . 0 . 1 . 3 . 0 . 0;
		}

        public function getColumns($tablename)
        {
            $SQL = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :tablename";
            return $this->get($SQL, [":tablename" => $tablename]);
		}

		public function get( $statement, $executeArray = array() )
		{
			$stmt = $this->db->prepare( $statement );
			try{
                $stmt->execute( $executeArray );
            }catch(\Exception $e){
                $e->getMessage();
            }
			return $stmt->fetchAll( \PDO::FETCH_ASSOC );
		}

        public function getObjArray( $statement, $executeArray = array() , string $classname)
        {
            $stmt = $this->db->prepare( $statement );
            try{
                $stmt->execute( $executeArray );
            }catch(\Exception $e){
                $e->getMessage();
            }
            return $stmt->fetchAll(\PDO::FETCH_CLASS, $classname);
        }

        public function getObj(string $sql, array $execArr = array(), string $classname)
        {
            $stmt = $this->db->prepare( $sql );
            try{
                $stmt->execute( $execArr );
            }catch(\Exception $e){
                $e->getMessage();
            }
            return $stmt->fetchObject($classname);

        }

		public function set( $statement, $executeArray = array() )
		{
			$stmt = $this->db->prepare( $statement );
            try{
			    return $stmt->execute( $executeArray );
            }catch(\Exception $e){
                echo $e->getMessage();
            }
		}

		public function getLastInsertID()
		{
			return $this->db->lastInsertId();
		}

		public function getLastInvoiceID()
		{
			$sql = "SELECT invoice_id FROM msonair_invoices ORDER BY invoice_id DESC LIMIT 1";

			return $this->get( $sql );

		}

        public function getLastCouponID()
        {
            $sql = "SELECT coupon_id FROM msonair_coupons ORDER BY coupon_id DESC LIMIT 1";

            return $this->get( $sql )[0]["coupon_id"];

        }

		public function activateUser(int $userid){
		    $SQL = "UPDATE msonair_users SET user_completed_payment = 1 WHERE user_id = :id";

		    $this->set($SQL, [":id" => $userid]);
        }

		public function getPackageById( $form )
		{
			$sql = "SELECT * FROM msonair_packages WHERE package_id = :id";

			return $this->get( $sql, array( ":id" => htmlentities( $this->request[ $form ]["id"] ) ) );
		}

		public function getUserByID( $id )
		{
			$sql = "SELECT * FROM msonair_users WHERE user_id = :id";

			return $this->get( $sql, [ ":id" => $id ] );
		}

		public function getAllStudents( $orderby = "user_lastname ASC" )
		{
			$sql = "SELECT user_id, user_firstname, user_lastname, user_email, 
                user_username, user_birthdate, user_status, user_street, user_postcode, 
                user_city, user_gender, user_intrested_in, user_package_id, user_lessoncount, 
                user_completed_payment, user_created, user_skill  FROM msonair_users WHERE user_status = :user_status ORDER BY " . $orderby;
			$execArr = [":user_status" => 3];

			return $this->get($sql, $execArr);
		}

		public function getUserInstrument($id){
		    $SQL = "SELECT user_intrested_in FROM msonair_users WHERE user_id = :id";

            return $this->get($SQL, [":id" => $id]);
        }


	}