<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 27.02.17
 * Time: 13:45
 */

namespace src\interfaces;


use src\core\User;

interface RegistrationInterface
{

    public function checkInput(array $post) : User;
    public function saveRegistration(User $user);

}