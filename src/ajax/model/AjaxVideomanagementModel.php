<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 23.10.2016
 * Time: 19:31
 */

namespace src\ajax\model;


use src\model\Model;

class AjaxVideomanagementModel extends Model
{

    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    public function run($request)
    {
        switch ($request["action"]) {
            case "delete":
                $this->deleteAssociation($request);
                break;

            case "create":
                $this->setAssociation($request);
                break;
        }
    }

    private function setAssociation($data)
    {
        $SQL = "INSERT INTO msonair_associate_videos_to_users (associated_user_id, associated_video_id)
                VALUES (:user_id, :video_id)";

        $this->set($SQL, [":user_id" => $data["user_id"], ":video_id" => $data["video_id"]]);
        echo "Video freigeschalten, ID: " . $data["video_id"];

    }

    private function deleteAssociation($data)
    {

        $SQL = "DELETE FROM msonair_associate_videos_to_users 
                WHERE associated_user_id = :user_id 
                AND associated_video_id = :video_id";

        $this->set($SQL, [":user_id" => $data["user_id"], ":video_id" => $data["video_id"]]);
        echo "Video gelöscht, ID: " . $data["video_id"];
    }

}