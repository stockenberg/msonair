<?php
	/**
	 * Created by PhpStorm.
	 * User: mstoc
	 * Date: 30.09.2016
	 * Time: 13:05
	 */

	namespace src\core;

	trait Database
	{

		public static function getDBInstance()
		{
			try
			{

                $db =  new \PDO( 'mysql:host=' . __HOST__ . ';dbname=' . __DB__ . '', __USER__, __PASS__,
					array(
						\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_WARNING,
						\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
					)
				);

                return $db;
			} catch ( \Exception $e )
			{
				echo $e->getMessage();
			}
		}

	}