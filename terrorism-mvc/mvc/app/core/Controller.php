<?php

class Controller{

    public function model($model, $p1 = -1, $p2 = -1){

        require_once '../app/models/' . $model . '.php';

        if($model == 'AttackDao' || $model == 'Attack'){
            return new $model();
        }

        return new $model($p1, $p2);
        
    }

    public function view($view, $data = []){
        require_once '../app/views/' . $view . '.php';
    }
}