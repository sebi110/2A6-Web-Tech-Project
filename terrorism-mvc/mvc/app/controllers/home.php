<?php 


class Home extends Controller{

    public function index(){

        $this->view('home/index',
            $this->model('AttackDao')->getAllTargets()
        );
    }

    public function attackInfo($year = -1, $target = -1, $count = -1){

        // to do: restrict access from .htaccess
        // should be called only through the form
        if($year == -1 || $target == -1 || $count == -1){
            echo 'attackInfo/year/target/count' . "<br>";
        }
        else{
            $target = str_replace("and", " & ", $target);
            
            $this->view('home/attackInfo', [
                'year' => $year,
                'target' => $target,
                'count' => $count,
                'attacks' => $this->model('AttackDao')->findByYearAndTarget($year, $target, $count)
            ]);
        }        
                
    }

    public function attackInfoAll($count = 10){

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

        // to do: restrict access from .htaccess
        $this->model('AttackDao')->cleanup();
        echo "Cleanup successful";
    }

    public function setup(){

        // to do: restrict access from .htaccess
        $this->model('AttackDao')->setup();
        echo "Setup successful";
    }

}