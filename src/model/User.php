<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 07.10.2016
 * Time: 01:01
 */

namespace src\model;


use src\core\Session;

class User extends Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function getVideos()
    {
        $SQL = "SELECT assoc.*, videos.* FROM msonair_videos 
                    as videos, msonair_associate_videos_to_users as assoc 
                    WHERE assoc.associated_user_id = :id AND videos.video_id = assoc.associated_video_id ORDER BY videos.video_title ASC";

        return $this->get($SQL, [":id" => Session::getID()]);
    }

    public function getFiles()
    {
        $SQL = "SELECT assoc.*, files.* FROM msonair_associate_files_to_users as assoc, msonair_filepool as files
                  WHERE assoc.associated_user_id = :id AND files.filepool_id = assoc.associated_file_id";
        return $this->get($SQL, [":id" => Session::getID()]);
    }

    public function getMyData()
    {
        $sql = "SELECT user_id, user_firstname, user_lastname, user_email, 
                user_username, user_birthdate, user_status, user_street, user_postcode, 
                user_city, user_gender, user_intrested_in, user_package_id, user_lessoncount, 
                user_completed_payment, user_created, user_skill 
                FROM msonair_users WHERE user_id = :id";
            return $this->get($sql, array(":id" => Session::get("logged_user", 0, "user_id")));
    }

    public function getMyInvoices()
    {
        $sql = "SELECT * FROM msonair_invoices WHERE invoice_user_id = :id";

        return $this->get($sql, array(":id" => Session::get("logged_user", 0, "user_id")));
    }

    public function getMyNextPackages()
    {
        $sql = "SELECT * FROM msonair_packages WHERE package_firstbooking_only = :firstbook";

        return $this->get($sql, [":firstbook" => 0]);
    }


}