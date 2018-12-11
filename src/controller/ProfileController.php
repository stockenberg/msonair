<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 08.10.2016
	 * Time: 23:47
	 */

	namespace src\controller;


	use src\core\Core;
    use src\core\Registration;
    use src\core\Session;
    use src\core\Status;
    use src\helpers\Mails;
    use src\model\Model;
    use src\model\ProfileModel;
	use src\model\User;

	class ProfileController extends Core
	{

		public $model;
		private $status;
		public $userdata;
		public $invoices;
		public $nextPackages;
		public $allInvoices;
		private $user;
        public $allCoupons;


		public function __construct( $status )
		{
			parent::__construct();
			$this->status = $status;
			$this->user   = new User();
			$this->run();
		}

		public function run()
		{
			$this->model = new ProfileModel();

			$this->userdata     = $this->user->getMyData();
			$this->invoices     = $this->user->getMyInvoices();
			$this->nextPackages = $this->user->getMyNextPackages();


            /**
             * Reset the Users Password
             */
            if ( isset($this->request["pwsubmit"]))
            {
                $actualpass = $this->model->getPassword()[0]["user_password"];

                if(password_verify($this->request["oldpw"], $actualpass)){
                    if($this->request["newpwrepeat"] == $this->request["newpw"]){
                        $newpass = password_hash( $this->request["newpw"], PASSWORD_DEFAULT, [ "cost" => 12 ] );
                        if($this->model->changePW($newpass)){
                            Mails::passwordChanged(Session::get("logged_user", 0));
                            new Status("flash", "Dein Passwort wurde geändert.");
                        }
                    }else{
                        new Status("flash", "Die Passwörter stimmen nicht überein.");
                    }
                }else{
                    new Status("flash", "Dein altes Passwort ist falsch.");
                }

            }

            /**
             * Upgrade the students account
             */
            if(isset($this->request["register"]["submit"])){
                $reg = new Registration();
                /** Validate User Input
                 * @var \src\core\User $user; */
                $tmp = $reg->checkInput($this->request["register"]);
                $user = (new Model())->getObj("SELECT * FROM msonair_users WHERE user_id = :id", [":id" => $tmp->getId()], "src\\core\\User");
                $user->setPackageId($tmp->getPackageId());
                $user->setPayment($tmp->getPayment());
                $user->setLessonCount($tmp->getLessonCount());
                $user->setRecall($tmp->getRecall());
                $user->setTermsOfUse($tmp->getTermsOfUse());
                $user->confirmed = $tmp->confirmed;


                /** Confirm Registration and Save User to DB */
                if(empty(Status::read())){

                    $reg->upgrade($user);

                }
            }

			if ( $this->status == __ADMIN__ )
			{
				$this->allInvoices = $this->model->getAllInvoicesWithUserdetails();
                $this->allCoupons     = $this->model->getAllCoupons();

                if ( isset( $this->request["invoices"] ) )
				{
					$this->model->confirmPaymentForUserAndInvoice($this->request["invoices"]);
					$this->redirect( "profile" );
				}
				if(isset($this->request["confirmCoupon"]["submit"])){
                    $this->model->confirmPaymentForCoupons($this->request["confirmCoupon"]["ids"]);
                    $this->redirect( "profile" );
                }
			}
		}

	}

