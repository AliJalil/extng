<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
//        if (!$this->isLoggedIn()) {
//            redirect('users/login');
//        }
//        if (isset($_SESSION['editCenter'])
//            || isset($_SESSION['deleteCenter'])) {
//            $users = $this->userModel->getusers();
//
//            $cities = $this->cityModel->getJsonCities();
//
//            $data = [
//                'users' => $users,
//                'cities' => $cities
//            ];
//
//            $this->view('main/index', $data);
//        } else {
//
//            redirect('Users');
//        }
        $this->view('users/login', []);
    }

}
