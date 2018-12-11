<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 23.10.2016
 * Time: 22:49
 */

namespace src\model;


class DocumentManagementModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function saveFile($data, $instrument)
    {
        $SQL = "INSERT INTO msonair_filepool (filepool_filename, filepool_instrument) VALUES (:filename, :instrument)";

        $this->set($SQL, [":filename" => $data, ":instrument" => $instrument]);
    }

    public function getFiles($instrument)
    {
        $SQL = "SELECT * FROM msonair_filepool WHERE filepool_instrument = :instrument";

        return $this->get($SQL, [":instrument" => $instrument]);
    }

    public function deleteFile($data)
    {
        $SQL = "DELETE FROM msonair_filepool WHERE filepool_id = :id";

        $this->set($SQL, [":id" => $data]);

        $SQL = "DELETE FROM msonair_associate_files_to_users WHERE associated_file_id = :id";

        $this->set($SQL, [":id" => $data]);

    }

}