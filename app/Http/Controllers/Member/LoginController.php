<?php 
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller; 

class LoginController extends Controller {

    public function login(){
        return $this->view('member.login.login');
    }
    public function forgotPassword(){
        
        return $this->view('member.login.forgot');
    }
    public function resetPassword(){
        
        return $this->view('member.login.pass-reset');
    }
    public function recoveryCode(){
       
       return $this->view('member.login.recovery-code');
    }
}