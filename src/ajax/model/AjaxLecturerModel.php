<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 26.10.2016
 * Time: 22:54
 */

namespace src\ajax\model;


use src\helpers\Helper;
use src\model\Model;

class AjaxLecturerModel extends Model
{

    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    private function run($request)
    {
        switch ($request["action"]){
            case "edit-form":
                $this->getEditTemplate($request["id"]);
                break;

            case "update":
                $this->changeLecturerData($request);
                break;

            case "delete":
                $this->delete($request["id"]);
                break;
        }
    }

    private function getEditTemplate($id){
        $sql = "SELECT user_id, user_firstname, user_lastname, user_email, 
                user_birthdate, user_street, user_postcode, user_city, user_gender, 
                user_intrested_in, user_package_id, user_lessoncount, user_completed_payment, 
                user_status, user_skill FROM msonair_users WHERE user_id = :id";

        $result = $this->get($sql, [":id" => $id]);

        Helper::saveAjaxData("user_edit", $result);
        Helper::saveAjaxData("labels", $this->labels);

        $file = "../../public/includes/lecturers/lecturer_edit.php";
        if (file_exists($file)) {
            include $file;
        }
    }

    private function delete($id)
    {
        $SQL = "DELETE FROM msonair_users WHERE user_id = :id";
        $this->set($SQL, [":id" => $id]);
        echo "Benutzer mit der ID: " . $id . " wurde erfolgreich gelöscht";
    }

    private function changeLecturerData($data)
    {
        // TODO if change-data is more major then just names or other values like Package-id or something

        $sql = "UPDATE msonair_users SET " . $data['column'] . " = :value WHERE user_id = :id";
        $this->set($sql, [":value" => $data["value"], ":id" => $data["id"]]);
        echo $this->labels[$data["column"]] . " erfolgreich geändert.";
    }

}