<?php

	namespace src\view;

	class View
	{

		private $template;
		private $data;

		public function __construct()
		{
			$this->data = array();
		}

		public function __get( $name )
		{
			if ( isset( $this->data[ $name ] ) )
			{
				return $this->data[ $name ];
			}
			else
			{
				throw new \InvalidArgumentException( "$name is missing..." );
			}
		}

		public function __set( $name, $value )
		{
			$this->data[ $name ] = $value;
		}

		public function setTemplate( $tplName )
		{
			$this->template = $tplName;
		}

		public function parse()
		{
			$output = '';

			$file = "templates/" . $this->template . ".php";
			if ( file_exists( $file ) )
			{
				ob_start();
				include $file;
				$output = ob_get_contents();
				ob_end_clean();
			}
			else
			{
				echo "templates/" . $this->template . ".php nicht gefunden";
			}

			return $output;
		}
	}