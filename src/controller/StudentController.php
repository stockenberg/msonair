<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 10.10.2016
	 * Time: 01:10
	 */

	namespace src\controller;


	use src\model\StudentModel;
	use src\core\Core;
	use src\core\Status;
	use src\helpers\Helper;
	use src\model\User;

	class StudentController extends Core
	{
		public $userdata;
		private $user, $studentModel;
		public $letters;
		public $allStudents;

		public function __construct()
		{
			parent::__construct();
			$this->user = new User();
			$this->studentModel = new StudentModel();
			$this->run();
		}

		public function run()
		{
			$this->letters = Helper::getAlphabet();
			$this->allStudents = $this->studentModel->getAllStudents();
		}

	}