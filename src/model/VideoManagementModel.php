<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 22.10.2016
 * Time: 21:06
 */

namespace src\model;


class VideoManagementModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Initial Save to the Database, if Videos are saved, there is no use for this function..  but you never know
     */
    public function saveVideosToDB()
    {
        $result = array();
        $folders = scandir(__LESSONS__);
        foreach ($folders as $id => $folder) {
            if ($folder != "." && $folder != "..") {
                $videos = scandir(__LESSONS__ . $folder);
                foreach ($videos as $key => $video) {
                    if ($video != "." && $video != "..") {
                        $result[$folder][] = $video;
                    }
                }
            }
        }

        $unpolished = array();
        foreach ($result as $instrument => $data) {
            foreach ($data as $id => $video) {
                $explode = explode(".", $video);
                if ($unpolished[$instrument][$id - 1] != $explode[0]) {
                    $unpolished[$instrument][$id] = $explode[0];
                }
            }
        }

        $SQL = "INSERT INTO msonair_videos (video_title, video_instrument) VALUES (:title, :instrument)";
        foreach ($unpolished as $instrument => $videolist) {
            foreach ($videolist as $ids => $video) {
                $this->set($SQL, [
                    ":title" => $video,
                    ":instrument" => $instrument
                ]);
            }
        }

    }

}