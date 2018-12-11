<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 17.10.2016
 * Time: 22:41
 */

namespace src\ajax\model;


use src\helpers\Helper;
use src\model\Model;

class AjaxStudentModel extends Model
{


    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    public function run($request)
    {
        switch ($request["action"]) {
            case "student-edit":
                $this->getEditTemplate($request["id"]);
                break;

            case "student-invoices":
                $this->getInvoiceByID($request["id"]);
                break;

            case "changeData":
                $this->changeUserData($request);
                break;

            case "read-livelessons":
                $this->readLiveLessons($request);
                break;
        }

    }

    private function readLiveLessons($request){
        $SQL = "SELECT user_lessoncount FROM msonair_users WHERE user_id = :id";
        $res = $this->get($SQL, [":id" => $request["id"]])[0]["user_lessoncount"];
        echo json_encode($res);
    }

    private function changeUserData($data)
    {
        // TODO if change-data is more major then just names or other values like Package-id or something

        $sql = "UPDATE msonair_users SET " . $data['column'] . " = :value WHERE user_id = :id";
        $this->set($sql, [":value" => $data["value"], ":id" => $data["id"]]);
        echo $this->labels[$data["column"]] . " erfolgreich geändert.";
    }

    private function getEditTemplate($id)
    {
        $sql = "SELECT user_id, user_firstname, user_lastname, user_email, 
                user_birthdate, user_street, user_postcode, user_city, user_gender, 
                user_intrested_in, user_package_id, user_lessoncount, user_completed_payment, 
                user_status, user_skill FROM msonair_users WHERE user_id = :id";

        $result = $this->get($sql, [":id" => $id]);
        Helper::saveAjaxData("user_edit", $result);
        Helper::saveAjaxData("labels", $this->labels);

        $file = "../../public/includes/students/students_edit.php";
        if (file_exists($file)) {
            include $file;
        }

    }

    private function getInvoiceByID($id)
    {
        $sql = "SELECT * FROM msonair_invoices WHERE invoice_user_id = :id";
        $execArr = [":id" => $id];

        Helper::saveAjaxData("invoices", $this->get($sql, $execArr));

        $file = "../../public/includes/students/students_invoices.php";
        if (file_exists($file)) {
            include $file;
        }
    }

}