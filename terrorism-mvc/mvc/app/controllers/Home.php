<?php 


class Home extends Controller{

    public function form($params){

        if($params != []){
            if(!isset($params['targtype'])){
                $params['targtype'] = 'all';
            }else{
            $params['targtype'] = str_replace("and", "&", $params['targtype']);
            }
            
        }

        //$x = $this->model('AttackDao')->getAllTargets();
        //print_r($x);
        
        $this->view('home/form', [
            'targets' => $this->model('AttackDao')->getAllTargets(),
            'params' => $params,
            'attacks' => $params == [] ? [] : $this->model('AttackDao')->find($params)
        ]);
    }

    public function register(){
        $this->view('home/register', [
            'user' => $this->model('User'),
            'userDao' => $this->model('UserDao')
        ]);
    }

    public function create_user(){
        $this->view('home/create_user', [
            'user' => $this->model('User'),
            'userDao' => $this->model('UserDao')
        ]);
    }

    public function login(){
        $this->view('home/login', [
            'user' => $this->model('User'),
            'userDao' => $this->model('UserDao')
        ]);
    }

    public function index(){
        $this->view('home/index');
    }

    public function admin(){
        $this->view('home/admin');
    }


}
