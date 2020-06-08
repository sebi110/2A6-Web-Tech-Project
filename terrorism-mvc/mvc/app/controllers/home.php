<?php 


class Home extends Controller{

    //to do: model param validation

    public function index($params){

        unset($params['prg']);
        unset($params['uniqid']);
        unset($params['start_prg']);

        if($params != []){
            if(!isset($params['targtype'])){
                $params['targtype'] = 'all';
            }else{
            $params['targtype'] = str_replace("and", "&", $params['targtype']);
            }
            
        }
        $this->view('home/index', [
            'targets' => $this->model('AttackDao')->getAllTargets(),
            'params' => $params,
            'attacks' => $params == [] ? [] : $this->model('AttackDao')->find($params)
        ]);
    }

    public function attackInfo($params){

        // to do: special views for errors
        if(empty($params)){
            echo "params iyear targtype count";
        }else{

            $params['targtype'] = str_replace("and", "&", $params['targtype']);
            
            $this->view('home/attackInfo', [
                'params' => $params,
                'attacks' => $this->model('AttackDao')->find($params)
            ]);        
        }        
                
    }

    public function attackInfoAll($params){

        if(empty($params)){
            $count = 10;
        }
        else{
            $count = $params['count'];
        }

        $this->view('home/attackInfoAll', [
            'year' => -1,
            'count' => $count,
            'attacks' => $this->model('AttackDao')->getAll($count)
        ]);
    }

    public function targets(){

        $this->view('home/targets', 
            $this->model('AttackDao')->getAllTargets()
        );
    }

    public function cleanup(){

        $this->model('AttackDao')->cleanup();
        echo "Cleanup successful";
    }

    public function setup(){

        $this->model('AttackDao')->setup();
        echo "Setup successful";
    }

}