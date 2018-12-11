<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 03.10.2016
	 * Time: 16:10
	 */

	namespace src\helpers;


	use src\core\Core;
    use src\core\Session;

	class Helper extends Core
	{
	    private static $scripts = [];
        private static $ajaxData = [];

		public static function getAlphabet(){
			$alphabet = [];
			for($i = 65; $i <= 90; $i++){
				$alphabet["&#" . $i] = chr($i);
			}
			// Add ä, ö, ü
			$alphabet["&#196"] = "Ä";
			$alphabet["&#214"] = "Ö";
			$alphabet["&#220"] = "Ü";

			return $alphabet;
		}

        public static function checkRights(){
            if(Session::getStatus() == __STUDENT__){
                self::redirect("profile");
            }
        }

		public static function translateIntresedIn($param){
		    $arr = array("trumpet" => "Trompete", "sax" => "Saxophon", "guitar" => "Gitarre", "piano" => "Klavier", "voice" => "Gesang", "bass" => "Bass");
            return $arr[$param];
        }

        public static function convertStatus($param){
            $arr = array(1 => "admin", 2 => "teacher", 3 => "student");
            return $arr[$param];
        }

		public function __construct()
		{
			parent::__construct();
		}

		public static function translateGender( $data )
		{
			$gender = $data;
			if ( $gender == "female" )
			{
				return "Frau";
			}
			if ( $gender == "male" )
			{
				return "Herr";
			}
		}

        public static function translateGenderWithGreeting( $data )
        {

            $gender = $data;
            return ($gender == "male") ? "Sehr geehrter Herr" : "Sehr geehrte Frau";
        }

		public static function useJS($page, $script_name){
            self::$scripts[$page][] = $script_name . ".js";
        }

        public static function getJS($page)
        {
            if(!empty(self::$scripts[$page])){
                return self::$scripts[$page];
            }else{
                return false;
            }
        }

        public static function saveAjaxData($key, $value){
            self::$ajaxData[$key] = $value;
        }

        public static function getAjaxData($key){
            return self::$ajaxData[$key];
        }

	}