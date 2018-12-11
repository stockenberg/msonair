<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 21.03.17
 * Time: 16:32
 */

namespace src\objects;


class Package
{


    private $package_id;	
    private $package_name;
    private $package_price;
    private $package_description;
    private $package_image;
    private $package_firstbooking_only;
    private $package_livelessons;
    private $package_skill;
    private $package_instrument;
    private $package_booking_count;
    private $package_booking_count_max;
    private $package_coupon_available;
    private $package_register_available;
    private $package_deadline;

    /**
     * @return mixed
     */
    public function getPackageDeadline()
    {
        return $this->package_deadline;
    }

    /**
     * @param mixed $package_deadline
     */
    public function setPackageDeadline($package_deadline)
    {
        $this->package_deadline = $package_deadline;
    }



    /**
     * @return mixed
     */
    public function getPackageCouponAvailable()
    {
        return $this->package_coupon_available;
    }

    /**
     * @param mixed $package_coupon_available
     */
    public function setPackageCouponAvailable($package_coupon_available)
    {
        $this->package_coupon_available = $package_coupon_available;
    }

    /**
     * @return mixed
     */
    public function getPackageRegisterAvailable()
    {
        return $this->package_register_available;
    }

    /**
     * @param mixed $package_register_available
     */
    public function setPackageRegisterAvailable($package_register_available)
    {
        $this->package_register_available = $package_register_available;
    }




    /**
     * @return mixed
     */
    public function getPackageBookingCount()
    {
        return $this->package_booking_count;
    }

    /**
     * @param mixed $package_booking_count
     */
    public function setPackageBookingCount($package_booking_count)
    {
        $this->package_booking_count = $package_booking_count;
    }

    /**
     * @return mixed
     */
    public function getPackageBookingCountMax()
    {
        return $this->package_booking_count_max;
    }

    /**
     * @param mixed $package_booking_count_max
     */
    public function setPackageBookingCountMax($package_booking_count_max)
    {
        $this->package_booking_count_max = $package_booking_count_max;
    }



    /**
     * @return mixed
     */
    public function getPackageInstrument()
    {
        return $this->package_instrument;
    }

    /**
     * @param mixed $package_instrument
     */
    public function setPackageInstrument($package_instrument)
    {
        $this->package_instrument = $package_instrument;
    }


    /**
     * @return mixed
     */
    public function getPackageId()
    {
        return $this->package_id;
    }

    /**
     * @param mixed $package_id
     */
    public function setPackageId($package_id)
    {
        $this->package_id = $package_id;
    }

    /**
     * @return mixed
     */
    public function getPackageName()
    {
        return $this->package_name;
    }

    /**
     * @param mixed $package_name
     */
    public function setPackageName($package_name)
    {
        $this->package_name = $package_name;
    }

    /**
     * @return mixed
     */
    public function getPackagePrice()
    {
        return $this->package_price;
    }

    /**
     * @param mixed $package_price
     */
    public function setPackagePrice($package_price)
    {
        $this->package_price = $package_price;
    }

    /**
     * @return mixed
     */
    public function getPackageDescription()
    {
        return $this->package_description;
    }

    /**
     * @param mixed $package_description
     */
    public function setPackageDescription($package_description)
    {
        $this->package_description = $package_description;
    }

    /**
     * @return mixed
     */
    public function getPackageImage()
    {
        return $this->package_image;
    }

    /**
     * @param mixed $package_image
     */
    public function setPackageImage($package_image)
    {
        $this->package_image = $package_image;
    }

    /**
     * @return mixed
     */
    public function getPackageFirstbookingOnly()
    {
        return $this->package_firstbooking_only;
    }

    /**
     * @param mixed $package_firstbooking_only
     */
    public function setPackageFirstbookingOnly($package_firstbooking_only)
    {
        $this->package_firstbooking_only = $package_firstbooking_only;
    }

    /**
     * @return mixed
     */
    public function getPackageLivelessons()
    {
        return $this->package_livelessons;
    }

    /**
     * @param mixed $package_livelessons
     */
    public function setPackageLivelessons($package_livelessons)
    {
        $this->package_livelessons = $package_livelessons;
    }

    /**
     * @return mixed
     */
    public function getPackageSkill()
    {
        return $this->package_skill;
    }

    /**
     * @param mixed $package_skill
     */
    public function setPackageSkill($package_skill)
    {
        $this->package_skill = $package_skill;
    }



}