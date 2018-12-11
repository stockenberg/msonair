<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 01.11.2016
 * Time: 20:22
 */

namespace src\model;


use src\core\Session;

class CalendarModel extends Model
{

    public function getAllTeachers()
    {


            $SQL = "SELECT * FROM msonair_users WHERE user_status = :status AND user_intrested_in = :instrument AND user_skill = :skill";
            return $this->get($SQL, [":status" => __TEACHER__, ":instrument" => Session::get("logged_user", 0, "user_intrested_in"), ":skill" => Session::get("logged_user", 0, "user_skill")]);
        


    }

}