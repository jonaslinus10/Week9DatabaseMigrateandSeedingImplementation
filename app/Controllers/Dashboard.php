<?php

namespace App\Controllers;

use \App\Models\UsersModel;

class Dashboard extends BaseController
{
    public function index(){

        if(!session('user')){

            return redirect()->to('/dashboard/login');
        }

        $data =[
            'page_title' => 'Brgy 43 Pinagpala Dashboard',
            'page_header' => 'Dashboard',
        ];

        $userModel = new UsersModel();
        $data['barangay_list'] = $userModel->getBarangayList();

        return view('dashboard_view', $data);

    }

    public function resident_record(){

        $data =[
            'page_title' => 'Brgy 43 Pinagpala Resident Records',
            'page_header' => 'Resident Records',
        ];

        return view('resident_record', $data);

    }

    public function user(){

        $data =[
            'page_title' => 'Brgy 43 Pinagpala User',
            'page_header' => 'User',
        ];

        $userModel = new UsersModel();
        $data['user'] = $userModel->getUser();
        
        return view('user_view', $data);
    }

    public function login(){

        $data =[
            'page_title' => 'Brgy 43 Pinagpala | Login',
            'page_header' => 'Brgy 43 Pinagpala',
            'page_login' => 'Login'
        ];

        return view('login', $data);
    }

    public function do_login(){
        
        $userModel = new UsersModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        $query = $db->query("select * from users where username = '$username'");
        $result = $query->getResult();
        if(count($result) > 0){
            foreach($query->getResult() as $row){
                $row->password;
                $row->username;
            }
    
            if($password === $row->password){

                $this->session->set("user", $row->username);

                return redirect()->to('/dashboard');

            }else{

                $data =[
                    'page_title' => 'Brgy 43 Pinagpala | Login',
                    'page_header' => 'Brgy 43 Pinagpala',
                    'page_login' => 'Login',
                    'page_error' => 'Invalid Password'
                ];
    
                return view('login', $data);

            }

        }else{

            $data =[
                'page_title' => 'Brgy 43 Pinagpala | Login',
                'page_header' => 'Brgy 43 Pinagpala',
                'page_login' => 'Login',
                'page_error' => 'Invalid Username or Password'
            ];

            return view('login', $data);
        }

    }

    public function logout(){

        session_destroy();

        return redirect()->to('/dashboard/login');
    }

}
