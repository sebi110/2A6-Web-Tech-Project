<?php


class Attack {

    public $_id;
    public $iyear;
    public $imonth;
    public $iday;
    public $country;
    public $region;
    public $provstate;
    public $city;
    public $latitude;
    public $longitude;
    public $success;
    public $attacktype1;
    public $targtype1;
    public $targtype1_txt;
    public $gname;
    public $motive;
    public $weaptype1;
    public $nkill;

    public function __construct(){
        $this->_id = 0;
        $this->iyear = 0;
        $this->imonth = 0;
        $this->iday = 0;
        $this->country = 0;
        $this->region = 0;
        $this->provstate = 0;
        $this->city = 0;
        $this->latitude = 0;
        $this->longitude = 0;
        $this->success = 0;
        $this->attacktype1 = 0;
        $this->targtype1 = 0;
        $this->targtype1_txt = 0;
        $this->gname = 0;
        $this->motive = 0;
        $this->weaptype1 = 0;
        $this->nkill = 0;
    }

    public function set($row){

        $this->_id = $row->_id;
        $this->iyear = $row->iyear;
        $this->imonth = $row->imonth;
        $this->iday = $row->iday;
        $this->country = $row->country;
        $this->region = $row->region;
        $this->provstate = $row->provstate;
        $this->city = $row->city;
        $this->latitude = $row->latitude;
        $this->longitude = $row->longitude;
        $this->success = $row->success;
        $this->attacktype1 = $row->attacktype1;
        $this->targtype1 = $row->targtype1;
        $this->targtype1_txt = $row->targtype1_txt;
        $this->gname = $row->gname;
        $this->motive = $row->motive;
        $this->weaptype1 = $row->weaptype1;
        $this->nkill = $row->nkill;
    }

    public function getAttack(){

        //in case the fields will be set to private in the future???...

        $attack = [
            "_id" => $this->_id,
            "iyear" => $this->iyear,
            "imonth" => $this->imonth,
            "iday" => $this->iday,
            "country" =>$this->country,
            "region" => $this->region,
            "provstate" => $this->provstate,
            "city" => $this->city,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "success" => $this->success,
            "attacktype1" => $this->attacktype1,
            "targtype1" => $this->targtype1,
            "targtype1_txt" => $this->targtype1_txt,
            "gname" => $this->gname,
            "motive" => $this->motive,
            "weaptype1" => $this->weaptype1,
            "nkill" => $this->nkill
        ];

        return $attack;
    }

}