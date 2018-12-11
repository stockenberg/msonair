<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 26.11.16
 * Time: 13:07
 */

namespace src\controller;


use src\core\Core;
use src\core\Status;
use src\helpers\Mails;

class ContactController extends Core
{

    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    public function run()
    {
        if (isset($this->request["contactSubmit"])) {
            if (empty($this->request["contactFirstname"])) {
                new Status("contactFirstname", "Bitte geben Sie ihren Vornamen ein.");
            } else {
                $this->firstname = htmlentities($this->request["contactFirstname"]);
            }

            if (empty($this->request["contactLastname"])) {
                new Status("contactLastname", "Bitte geben Sie ihren Nachnamen ein.");
            } else {
                $this->lastname = htmlentities($this->request["contactLastname"]);
            }

            if (empty($this->request["contactEmail"])) {
                new Status("contactEmail", "Bitte geben Sie ihre E-Mail-Adresse ein.");
            } else {
                $this->email = htmlentities($this->request["contactEmail"]);
            }
            if (empty($this->request["contactMessage"])) {
                new Status("contactMessage", "Bitte geben Sie ihre Nachricht ein.");
            } else {
                $this->message = htmlentities($this->request["contactMessage"]);
            }
            if (empty(Status::read())) {
                Mails::sendContact($this->data);
                new Status("flash", "Nachricht erfolgreich übermittelt.");
            } else {
                new Status("flash", "Bitte fülle alle Felder aus.");
            }
        }

    }

    /**
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param mixed $data
     */
    public function __set($key, $data)
    {
        $this->data[$key] = $data;
    }

}