<?php 


class Home extends Controller{

    public function index($name = 'pyro', $mood = 'a cute little lesbian'){

        $user = $this->model('User', $name, $mood);

        $this->view('home/index', [
            'name' => $user->getName(),
            'mood' => $user->getMood()
        ]);
    }

    public function attackinfoYear($year = "2017", $count = 10){

        $this->view('home/attackinfoYear', [
            'year' => $year,
            'count' => $count,
            'attacks' => $this->model('AttackDao')->findByYear($year, $count)
        ]);
    }

    public function attackinfoAll($count = 10){

        $this->view('home/attackinfoAll', [
            'year' => -1,
            'count' => $count,
            'attacks' => $this->model('AttackDao')->getAll($count)
        ]);
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