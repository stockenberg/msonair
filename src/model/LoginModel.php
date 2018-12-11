<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 06.10.2016
	 * Time: 21:40
	 */

	namespace src\model;


	use PHPMailer\PHPMailer\Exception;
	use src\core\Status;

	class LoginModel extends Model
	{

		private $pwhash;
		private $id;

        public function __construct()
        {
            parent::__construct();
        }

		public function setInitialPassword( $password, $token )
		{
			$sql = "UPDATE msonair_users SET user_password = :pw WHERE user_password = :token";

			return $this->set( $sql, array(
				":pw"    => $password,
				":token" => $token
			) );
		}

		public function getUserByToken( $token )
		{
			$sql = "SELECT * FROM msonair_users WHERE user_password = :token";

			return $this->get( $sql, array( ":token" => $token ) );
		}

		public function checkLogin( $data )
		{
			$sql  = "SELECT user_id, user_password FROM msonair_users WHERE user_username = :username";
			$stmt = $this->get( $sql, array( ":username" => $data["username"] ) );
			foreach ( $stmt as $row => $userdata )
			{
				if ( password_verify( $data["password"], $userdata["user_password"] ) )
				{
					$this->id = $userdata["user_id"];
					break;
				}
			}

			$sql = "SELECT user_id, user_username, user_firstname, 
                user_lastname, user_completed_payment, user_gender, 
                user_lessoncount, user_package_id, user_status, user_skill FROM msonair_users WHERE user_id = :id";

			return $this->get( $sql, array( ":id" => $this->id ) );
		}

	}