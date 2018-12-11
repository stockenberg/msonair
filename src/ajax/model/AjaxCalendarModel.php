<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 25.10.2016
 * Time: 09:27
 */

namespace src\ajax\model;


use src\core\Session;
use src\helpers\Helper;
use src\helpers\Mails;
use src\model\Model;
use src\model\User;

class AjaxCalendarModel extends Model
{
    public $res;
    private $lessoncount;

    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    /**
     * Backbone... Central Controll for Interaction with Calendar
     * @param $request
     */
    public function run($request)
    {
        switch ($request["action"]) {

            // ADMIN
            case "create":
                $this->createCalendarEvent($request);
                $this->selectCalendarEvents();
                break;

            case "delete":
                $this->deleteCalendarEvent($request);
                $this->selectCalendarEvents("all");
                break;

            case "read":

                $this->selectCalendarEvents(@$request["instrument"]);
                break;

            // TEACHER
            case "teacher-create":
                $this->createCalendarEvent($request);
                $this->selectCalendarEventsByID($request["id"]);
                break;

            case "teacher-read":
                $this->selectCalendarEventsByID($request["id"]);
                break;

            case "teacher-delete":
                $this->deleteCalendarEvent($request);
                $this->selectCalendarEventsByID($request["id"]);
                break;


            // STUDENT
            case "book-slot":
                $this->bookSlot($request);
                break;

            case "delete-slot":
                $this->deleteSlot($request);
                break;

            case "read-student":
                $this->selectCalendarEventsForUsers($request);
                break;

        }
        echo json_encode($this->res);
    }

    /**
     * Book a calendar Slot and generate a Room hash
     * @param $request
     */
    private function bookSlot($request, $heavytones = 0)
    {

        $SQL = "SELECT calendar_event_start, calendar_event_cost FROM msonair_calendar_events WHERE calendar_event_id = :id";

        /**
         * @var array $date calendar-event
         */
        $date = $this->get($SQL, [":id" => $request["entry_id"]]);

        $SQL = "SELECT * 
                FROM msonair_users 
                WHERE user_id = :id";

        $user = $this->get($SQL, [":id" => $request["id"]]);

        if (__TIMELIMIT48_ <= strtotime($date[0]["calendar_event_start"])) {
            $this->lessoncount = $user[0]["user_lessoncount"];
            if ($this->lessoncount > 0) {


                $SQL = "UPDATE msonair_calendar_events 
                        SET calendar_event_blocked = :blocked, calendar_event_blocked_at = :now 
                        WHERE calendar_event_id = :id";

                $this->set($SQL, [
                    ":blocked" => $request["id"],
                    ":now" => date("y-m-d H:i:s", time()),
                    ":id" => $request["entry_id"],
                ]);

                $sql = "SELECT * FROM msonair_calendar_events WHERE calendar_event_id = :id";
                $event = $this->get($sql, [":id" => $request["entry_id"]]);

                $SQL = "INSERT INTO msonair_rooms 
                (room_hash, room_name, room_kalender_id) 
                VALUES 
                (:room_hash, :room_name, :room_cal_id)";

                $this->set($SQL, [
                    ":room_hash" => md5(date("y-m-d H:i:s",
                            time()) . $request["entry_id"] . "MSONAIR_LIVELESSON" . "uneverfiguerthisout##13371337\$p333k"),
                    ":room_name" => date("y-m-d H:i:s", time()),
                    ":room_cal_id" => $request["entry_id"]
                ]);

                $SQL = "UPDATE msonair_users 
                    SET user_lessoncount = :lessoncount 
                    WHERE user_id = :id";

                $this->set($SQL,
                    [
                        ":id" => $request["id"],
                        ":lessoncount" => $this->lessoncount - $date[0]["calendar_event_cost"]
                    ]);

                $this->res["flash"] = "Dein Termin wurde gebucht.";

                $sql = "SELECT * FROM msonair_users WHERE user_id = :id";
                $user = $this->get($sql, [":id" => $request["id"]]);
                $dozent = $this->get($sql, [":id" => $event[0]["calendar_event_user_id"]]);
                Mails::lessonIsSet($user[0], $event[0], $dozent[0]);
                Mails::lessonIsSetTeacher($user[0], $event[0], $dozent[0]);


            } else {
                $this->res["flash"] = "Du hast leider keine weiteren Live-Unterrichte frei. 
            Buche ein weiteres Paket, um wieder Unterricht nehmen zu können.";
            }
        } else {
            $this->res["flash"] = "Der Termin kann nur bis zu 48 Stunden vorher gebucht werden";
        }
    }

    /**
     * Delete Booking and delete Chatroom
     * @param $request
     */
    private function deleteSlot($request, $heavytones = 0)
    {
        $SQL = "SELECT calendar_event_start, calendar_event_cost FROM msonair_calendar_events WHERE calendar_event_id = :id AND calendar_event_heavytones = :heavytones";
        $date = $this->get($SQL, [":id" => $request["entry_id"], ":heavytones" => $heavytones]);

        $SQL = "SELECT user_lessoncount 
                FROM msonair_users 
                WHERE user_id = :id";

        $this->lessoncount = $this->get($SQL, [":id" => $request["id"]])[0]["user_lessoncount"];

        if (__TIMELIMIT24__ <= strtotime($date[0]["calendar_event_start"])) {
            $SQL = "UPDATE msonair_calendar_events SET calendar_event_blocked = :blocked, calendar_event_blocked_at = :now WHERE calendar_event_id = :id";
            $this->set($SQL,
                [":blocked" => 0, ":now" => null, ":id" => $request["entry_id"]]
            );

            $SQL = "DELETE FROM msonair_rooms WHERE room_kalender_id = :room_cal_id";
            $this->set($SQL, [":room_cal_id" => $request["entry_id"]]);


            $SQL = "UPDATE msonair_users SET user_lessoncount = :lessoncount WHERE user_id = :id";

            $this->set($SQL,
                [":id" => $request["id"], ":lessoncount" => $this->lessoncount + $date[0]["calendar_event_cost"]]);
            $this->res["flash"] = "Dein Termin wurde gelöscht.";

            $sql = "SELECT * FROM msonair_calendar_events WHERE calendar_event_id = :id";
            $event = $this->get($sql, [":id" => $request["entry_id"]]);

            $sql = "SELECT * FROM msonair_users WHERE user_id = :id";
            $user = $this->get($sql, [":id" => $request["id"]]);
            $dozent = $this->get($sql, [":id" => $event[0]["calendar_event_user_id"]]);

            Mails::lessonIsUnset($user[0], $event[0], $dozent[0]);
            Mails::lessonIsUnsetTeacher($user[0], $event[0], $dozent[0]);


        } else {
            $this->res["flash"] = "Der Termin kann nur bis zu 24 Stunden vorher abgesagt werden.";
        }

    }


    /**
     * Admin and Teacher - Create Calendar Slots
     * @param $data - Calendardata
     */
    private
    function createCalendarEvent(
        $data
    ) {
        if (__TIMELIMIT48_ <= strtotime($data["data"][0]["start"])) {
            $user = new User();
            $user = $user->getUserByID($data["id"]);

            $SQL = "INSERT INTO msonair_calendar_events 
                    (calendar_event_start, calendar_event_end, calendar_event_user_id, 
                    calendar_event_user_name, calendar_event_instrument, calendar_event_heavytones, calendar_event_cost)
                    VALUES 
                    (:start, :ende, :user_id, :title, :description, :calendar_event_heavytones, :cost)";

          foreach ($data["data"] as $key => $times){
            $exec = [
                ":title" => $user[0]["user_firstname"] . " " . $user[0]["user_lastname"],
                ":start" => $times["start"],
                ":ende" => $times["end"],
                ":user_id" => $data["id"],
                ':description' => $user[0]["user_intrested_in"],
                ':calendar_event_heavytones' => 0,
                ':cost' => 1
            ];

            $this->set($SQL, $exec);
          }
            $this->res["flash"] = "Termin erfolgreich erstellt.";
        } else {
            $this->res["flash"] = "Der Termin kann nur bis zu 48 Stunden vorher erstellt werden";
        }
    }

    /**
     * Get All Calender events from one specific user
     * @param array $data
     */
    private function selectCalendarEventsForUsers($request)
    {

        $SQL = "SELECT user_lessoncount, user_package_id 
                FROM msonair_users 
                WHERE user_id = :id";

        $user = $this->get($SQL, [":id" => $request["id"]]);

        $package_id = $user[0]["user_package_id"];
        $this->lessoncount = $user[0]["user_lessoncount"];

        $SQL = "SELECT p.*, u.* FROM msonair_packages as p, msonair_users as u WHERE p.package_id = :package_id AND u.user_id = p.package_teacher_id";
        $teacher = $this->get($SQL, [":package_id" => $package_id]);

        $SQL = "SELECT * FROM msonair_calendar_events 
                WHERE calendar_event_user_id = :teacher_id
                AND (calendar_event_blocked = :zero OR calendar_event_blocked = :userid)";
        $exec = [
            ":userid" => $request["id"],
            ":teacher_id" => $teacher[0]["user_id"],
            ":zero" => 0,
        ];

        $result = array();
        foreach ($this->get($SQL, $exec) as $row => $event) {
            $tmp = array();
            $tmp["start"] = $event["calendar_event_start"];
            $tmp["end"] = $event["calendar_event_end"];
            $tmp["id"] = $event["calendar_event_id"];
            $tmp["title"] = ($event["calendar_event_blocked"] > 0) ? $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]) . " - Gebucht" : $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]);
            $tmp["className"] = array(
                $event["calendar_event_instrument"],
                ($event["calendar_event_blocked"] > 0) ? "blocked" : "",
                ($event["calendar_event_blocked"] > 0) ? "blocked_" . $event["calendar_event_blocked"] : ""
            );
            $result[] = $tmp;
        }
        if (count($result) > 0) {
            $this->res["success"] = $result;
        }


    }

    /**
     * Get All Calender events from one specific user
     * @param $id
     */
    private
    function selectCalendarEventsByIDForUsersFiltered(
        $data
    ) {
        $SQL = "SELECT * FROM msonair_calendar_events WHERE calendar_event_user_id = :id AND calendar_event_blocked = :zero OR calendar_event_blocked = :userid";

        $result = array();
        foreach ($this->get($SQL,
            [":id" => $data["entry_id"], ":userid" => $data["id"], ":zero" => 0]) as $row => $event) {
            $tmp = array();
            $tmp["start"] = $event["calendar_event_start"];
            $tmp["end"] = $event["calendar_event_end"];
            $tmp["id"] = $event["calendar_event_id"];
            $tmp["title"] = ($event["calendar_event_blocked"] > 0) ? $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]) . " - Gebucht" : $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]);
            $tmp["className"] = array(
                $event["calendar_event_instrument"],
                ($event["calendar_event_blocked"] > 0) ? "blocked" : "",
                ($event["calendar_event_blocked"] > 0) ? "blocked_" . $event["calendar_event_blocked"] : ""
            );
            $result[] = $tmp;
        }
        if (count($result) > 0) {
            $this->res["success"] = $result;
        }
    }

    /**
     * Get All Calender events from one specific user
     * @param $id
     */
    private
    function selectCalendarEventsByID(
        $id
    ) {
        $SQL = "SELECT * FROM msonair_calendar_events WHERE calendar_event_user_id = :id";

        $result = array();
        foreach ($this->get($SQL, [":id" => $id]) as $row => $event) {
            $tmp = array();
            $tmp["start"] = $event["calendar_event_start"];
            $tmp["end"] = $event["calendar_event_end"];
            $tmp["id"] = $event["calendar_event_id"];
            $tmp["title"] = ($event["calendar_event_blocked"] > 0) ? $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]) . " - Gebucht" : $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]);
            $tmp["className"] = array(
                $event["calendar_event_instrument"],
                ($event["calendar_event_blocked"] > 0) ? "blocked" : "",
                ($event["calendar_event_blocked"] > 0) ? "blocked_" . $event["calendar_event_blocked"] : ""
            );
            $result[] = $tmp;
        }
        if (count($result) > 0) {
            $this->res["success"] = $result;
        }
    }

    /**
     * Delete Event
     * @param $data
     */
    private
    function deleteCalendarEvent(
        $data,
        $heavytones = 0
    ) {
        $SQLcheck = "SELECT * FROM msonair_calendar_events WHERE calendar_event_user_id = :teacher_id AND calendar_event_start = :start";

        $SQL = "DELETE FROM msonair_calendar_events 
                WHERE calendar_event_start = :start 
                AND calendar_event_end = :ende 
                AND calendar_event_user_id = :user_id";

        $exec = [
            ":start" => $data["start"],
            ":ende" => $data["end"],
            ":user_id" => $data["id"]
        ];
        if (count($this->get($SQLcheck, [":teacher_id" => $data["id"], ":start" => $data["start"]])) > 0) {
            $this->set($SQL, $exec);
            $this->res["flash"] = "Termin erfolgreich gelöscht.";
        } else {
            $this->res["flash"] = "Termine von anderen Lehrern können nicht gelöscht werden.";
        }
    }

    /**
     * Get All Cal Events
     * @param $instrument
     */
    private
    function selectCalendarEvents(
        $instrument = ""
    ) {
        $execArray = [];
        $where = "";

        if ($instrument != "") {
            if ($instrument == "all") {
                $where = "";
            } else {
                $where = " WHERE calendar_event_instrument = :instrument";
                $execArray = [":instrument" => $instrument];
            }
        }

        $SQL = "SELECT * FROM msonair_calendar_events" . $where;

        $result = array();
        foreach ($this->get($SQL, $execArray) as $row => $event) {
            $tmp = array();
            $tmp["start"] = $event["calendar_event_start"];
            $tmp["end"] = $event["calendar_event_end"];
            $tmp["id"] = $event["calendar_event_id"];
            $tmp["title"] = ($event["calendar_event_blocked"] > 0) ? $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]) . " - Gebucht" : $event["calendar_event_user_name"] . " - "
                . Helper::translateIntresedIn($event["calendar_event_instrument"]);
            $tmp["className"] = array(
                $event["calendar_event_instrument"],
                ($event["calendar_event_blocked"] > 0) ? "blocked" : "",
                ($event["calendar_event_blocked"] > 0) ? "blocked_" . $event["calendar_event_blocked"] : ""
            );
            $result[] = $tmp;
        }
        if (count($result) > 0) {
            $this->res["success"] = $result;
        }
    }

}