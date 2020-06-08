<?php


class Attack {

    private $details;

    public function __construct(){

        $keys = array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
            'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype1',
            'targtype1', 'targtype1_txt', 'gname', 'motive', 'weaptype1', 'nkill'
            );

        $this->details = array_fill_keys($keys, 0);
    }

    public function set($row){

        $this->details = $row;
    }

    public function get(){

        return $this->details;
    }

    public function toJson(){
        return json_encode($this->details);
    }

}