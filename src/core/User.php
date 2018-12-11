<?php

namespace src\core;

/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 27.02.17
 * Time: 13:33
 */
class User
{

    // Private Informations
    private $user_firstname;
    private $user_lastname;
    private $childsAccount;
    private $childsName;
    private $user_email;
    private $user_username;
    private $user_birthdate;
    private $user_street;
    private $user_postcode;
    private $user_city;
    private $user_gender;
    private $user_intrested_in;
    private $password;
    private $user_id;
    private $upgrade;

    // Payment
    private $package_id;
    private $payment;
    private $coupon;
    private $user_lessoncount;

    // Siteinfos
    private $newsletter;
    private $termsOfUse;
    private $recall;
    private $coupon_code;

    public $confirmed = false;

    /**
     * @return mixed
     */
    public function getCoupon_code()
    {
        return $this->coupon_code;
    }

    /**
     * @param mixed $coupon_code
     */
    public function setCoupon_code($coupon_code)
    {
        $this->coupon_code = $coupon_code;
    }



    /**
     * @return mixed
     */
    public function getUpgrade()
    {
        return $this->upgrade;
    }

    /**
     * @param mixed $upgrade
     */
    public function setUpgrade($upgrade)
    {
        $this->upgrade = $upgrade;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->user_id = $id;
    }




    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->user_firstname;
    }

    /**
     * @param mixed $user_firstname
     */
    public function setFirstname($user_firstname)
    {
        $this->user_firstname = $user_firstname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->user_lastname;
    }

    /**
     * @param mixed $user_lastname
     */
    public function setLastname($user_lastname)
    {
        $this->user_lastname = $user_lastname;
    }

    /**
     * @return mixed
     */
    public function getChildsAccount()
    {
        return $this->childsAccount;
    }

    /**
     * @param mixed $childsAccount
     */
    public function setChildsAccount($childsAccount)
    {
        $this->childsAccount = $childsAccount;
    }

    /**
     * @return mixed
     */
    public function getChildsName()
    {
        return $this->childsName;
    }

    /**
     * @param mixed $childsName
     */
    public function setChildsName($childsName)
    {
        $this->childsName = $childsName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->user_email;
    }

    /**
     * @param mixed $user_email
     */
    public function setEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->user_username;
    }

    /**
     * @param mixed $user_username
     */
    public function setUsername($user_username)
    {
        $this->user_username = $user_username;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->user_birthdate;
    }

    /**
     * @param mixed $user_birthdate
     */
    public function setBirthDate($user_birthdate)
    {
        $this->user_birthdate = $user_birthdate;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->user_street;
    }

    /**
     * @param mixed $user_street
     */
    public function setStreet($user_street)
    {
        $this->user_street = $user_street;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->user_postcode;
    }

    /**
     * @param mixed $user_postcode
     */
    public function setPostcode($user_postcode)
    {
        $this->user_postcode = $user_postcode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->user_city;
    }

    /**
     * @param mixed $user_city
     */
    public function setCity($user_city)
    {
        $this->user_city = $user_city;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->user_gender;
    }

    /**
     * @param mixed $user_gender
     */
    public function setGender($user_gender)
    {
        $this->user_gender = $user_gender;
    }

    /**
     * @return mixed
     */
    public function getInstrument()
    {
        return $this->user_intrested_in;
    }

    /**
     * @param mixed $user_instrested_in
     */
    public function setInstrument($user_instrested_in)
    {
        $this->user_intrested_in = $user_instrested_in;
    }

    /**
     * @return mixed
     */
    public function getPackageId()
    {
        return $this->package_id;
    }

    /**
     * @param mixed $user_package_id
     */
    public function setPackageId($user_package_id)
    {
        $this->package_id = $user_package_id;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @param mixed $coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * @return mixed
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param mixed $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return mixed
     */
    public function getTermsOfUse()
    {
        return $this->termsOfUse;
    }

    /**
     * @param mixed $termsOfUse
     */
    public function setTermsOfUse($termsOfUse)
    {
        $this->termsOfUse = $termsOfUse;
    }

    /**
     * @return mixed
     */
    public function getRecall()
    {
        return $this->recall;
    }

    /**
     * @param mixed $recall
     */
    public function setRecall($recall)
    {
        $this->recall = $recall;
    }

    /**
     * @return mixed
     */
    public function getLessonCount()
    {
        return $this->user_lessoncount;
    }

    /**
     * @param mixed $user_lessoncount
     */
    public function setLessonCount($user_lessoncount)
    {
        $this->user_lessoncount = $user_lessoncount;
    }


}