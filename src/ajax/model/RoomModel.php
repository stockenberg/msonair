<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 06.11.2016
 * Time: 15:24
 */

namespace src\ajax\model;


use src\core\Session;
use src\core\User;
use src\helpers\Mails;
use src\model\Model;

class RoomModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getRoomForTeacher()
    {
        $SQL = "SELECT 
                rooms.*, 
                users.user_firstname,
                users.user_lastname,
                users.user_id,
                cal.calendar_event_user_name, 
                cal.calendar_event_blocked,
                cal.calendar_event_start,
                cal.calendar_event_end
                FROM msonair_rooms AS rooms, msonair_calendar_events AS cal, msonair_users as users
                WHERE rooms.room_kalender_id = cal.calendar_event_id 
                AND cal.calendar_event_user_id = :id 
                AND cal.calendar_event_blocked = users.user_id ORDER BY cal.calendar_event_start ASC";

        return $this->get($SQL, [":id" => Session::getID()]);
    }

    public function getRoomForStudent()
    {
        $SQL = "SELECT rooms.*, 
                cal.calendar_event_user_name, 
                cal.calendar_event_blocked,
                cal.calendar_event_start,
                cal.calendar_event_end
                FROM msonair_rooms as rooms, msonair_calendar_events as cal
                WHERE rooms.room_kalender_id = cal.calendar_event_id 
                AND cal.calendar_event_blocked = :id ORDER BY cal.calendar_event_start ASC";

        return $this->get($SQL, [":id" => Session::getID()]);
    }

    public function completeLesson($hash)
    {
        // GET Room informations
        $SQL = "SELECT * FROM msonair_rooms WHERE room_hash = :hash";
        $room = $this->get($SQL, [":hash" => $hash]);

        // Delete Bookings their done
        $SQL = "DELETE FROM msonair_calendar_events WHERE calendar_event_id = :id";
        $this->set($SQL, [":id" => $room[0]["room_kalender_id"]]);

        // Delete Room which is done
        $SQL = "DELETE FROM msonair_rooms WHERE room_hash = :hash";
        $this->set($SQL, [":hash" => $hash]);

        // Get user for Lessoncount and Userid
        $SQL = "SELECT * FROM msonair_users WHERE user_id = :id";
        /** @var User $user */
        $user = $this->getObj($SQL, [":id" => $_GET["user"] ?? 0], User::class);

        // Get Events by User
        $SQL = "SELECT * FROM msonair_calendar_events WHERE calendar_event_blocked = :userid";
        $res = $this->get($SQL, [":userid" => $user->getId()]);

        // If user ! has Bookings and LessonCount == 0 -> Lessonsempty
        if($user->getLessonCount() == 0 && count($res) == 0){
            Mails::lessonsEmpty($user);
        }
    }


}