<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 17.10.2016
 * Time: 12:48
 */

namespace src\ajax;

require "../config/config.php";
require "../vendor/autoload.php";


use src\ajax\model\AjaxCalendarModel;
use src\ajax\model\AjaxDocumentmanagementModel;
use src\ajax\model\AjaxGlobalModel;
use src\ajax\model\AjaxLecturerModel;
use src\ajax\model\AjaxStudentModel;
use src\ajax\model\AjaxVideomanagementModel;
use src\core\Core;

class AjaxHandler extends Core
{
    public function __construct()
    {
        parent::__construct();
        $this->run($this->request);
    }

    public function run($request)
    {
        switch ($request["p"]) {
            case "manage-students":
                new AjaxStudentModel($request);
                break;

            case "global":
                new AjaxGlobalModel($request);
                break;

            case "manage-videos":
                new AjaxVideomanagementModel($request);
                break;

            case "manage-documents":
                new AjaxDocumentmanagementModel($request);
                break;

            case "manage-calendar":
                new AjaxCalendarModel($request);
                break;

            case "calendar-view":
                new AjaxCalendarModel($request);
                break;

            case "manage-lecturers":
                new AjaxLecturerModel($request);
                break;

            case "student":
                new AjaxStudentModel($request);
                break;

            case "register":
                new AjaxGlobalModel($request);
                break;
        }

    }
}


new AjaxHandler();