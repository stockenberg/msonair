<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 22.10.2016
 * Time: 21:23
 */

namespace src\ajax\model;


use src\helpers\Helper;
use src\model\Model;

class AjaxGlobalModel extends Model
{

    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    public function run($request)
    {
        switch ($request["action"]) {
            case "checkUsername":
                $this->checkDuplicates($request);
                break;
            case "manage-videos":
                Helper::saveAjaxData("unlocked_videos", $this->getUnlockedVideos($request));
                Helper::saveAjaxData("user_id", $request["user_id"]);
                $file = "../../public/includes/videomanagement/videolist.inc.php";
                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "Videolist file not found...";
                }
                break;

            case "manage-documents":
                Helper::saveAjaxData("unlocked_files", $this->getUnlockedFiles($request));
                Helper::saveAjaxData("user_id", $request["user_id"]);
                $file = "../../public/includes/documentmanagement/documentlist.inc.php";
                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "Documentlist file not found...";
                }
                break;
        }
    }

    public function checkDuplicates($data){
        $SQL = "SELECT * FROM msonair_users WHERE user_username = :username";
        $res = $this->get($SQL, [":username" => $data["value"]]);
        if(count($res) > 0){
            echo "Der Benutzername ist bereits vergeben. Bitte wähle einen Anderen.";
        }else{
            echo "Benutzername ist verfügbar";
        }
    }

    private function getUnlockedVideos($data)
    {

        $SQL = "SELECT * FROM 
                msonair_videos WHERE video_instrument = :instrument";
        $videos = $this->get($SQL,
            [":instrument" => $this->getUserInstrument($data["user_id"])[0]["user_intrested_in"]]);

        $SQL = "SELECT * FROM msonair_associate_videos_to_users WHERE associated_user_id = :id";
        $assocs = $this->get($SQL, [":id" => $data["user_id"]]);

        $tmp = array();
        $final = array();

        foreach ($videos as $key => $video) {
            $tmp["title"] = $video["video_title"];
            $tmp["id"] = $video["video_id"];
            $tmp["unlocked"] = "FALSE";
            if (!empty($assocs)) {
                foreach ($assocs as $assKey => $associations) {
                    if ($video["video_id"] == $associations["associated_video_id"]) {
                        $tmp["unlocked"] = "TRUE";
                    }
                }
            } else {
                $tmp["unlocked"] = "FALSE";
            }
            $final[] = $tmp;
        }
        return $final;
    }

    private function getUnlockedFiles($data)
    {

        $SQL = "SELECT * FROM 
                msonair_filepool WHERE filepool_instrument = :instrument";
        $files = $this->get($SQL, [':instrument' => $this->getUserInstrument($data["user_id"])[0]["user_intrested_in"]]);

        $SQL = "SELECT * FROM msonair_associate_files_to_users WHERE associated_user_id = :id";
        $assocs = $this->get($SQL, [":id" => $data["user_id"]]);

        $tmp = array();
        $final = array();

        foreach ($files as $key => $file) {
            $tmp["title"] = $file["filepool_filename"];
            $tmp["id"] = $file["filepool_id"];
            $tmp["unlocked"] = "FALSE";
            $tmp["created"] = "nicht freigeschalten";
            if (!empty($assocs)) {
                foreach ($assocs as $assKey => $associations) {
                    if ($file["filepool_id"] == $associations["associated_file_id"]) {
                        $tmp["unlocked"] = "TRUE";
                        $tmp["created"] = $associations["associated_created"];
                    }
                }
            } else {
                $tmp["unlocked"] = "FALSE";
            }
            $final[] = $tmp;
        }
        return $final;
    }

}