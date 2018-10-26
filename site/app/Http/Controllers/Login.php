<?php 
namespace App\Http\Controllers;

class Login extends Controller {

    public function initialize(){
        $this->includes->body = 'includes.body-login';
        $this->includes->footer = 'includes.footer-login';
    }
    public function home(){
        return $this->view('login.login');
    }
}