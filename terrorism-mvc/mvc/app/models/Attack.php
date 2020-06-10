<?php


class Attack {

    private $details;

    public function __construct(){

        $keys = array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
            'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
            'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill'
            );

        $this->details = array_fill_keys($keys, 0);
    }

    public function setKey($key,$value){
        if(isset($this->details[$key])){
            $this->details[$key]=$value;
        }
    }

    public function setKeys($arr){
        foreach($arr as $key => $val){
            $this->setKey($key,$val);
        }
    }

    public function get(){
        return $this->details;
    }

    public function toJson(){
        return json_encode($this->details);
    }

}