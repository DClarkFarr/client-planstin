<?php 
namespace App\Http\Controllers\Member;

use App\Exceptions\InvalidPasswordException;
use App\Exceptions\UserAlreadyExistsException;
use Barryvdh\Form\CreatesForms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller {
    public function create(Request $request){
        

        return $this->view('member.register.signup');
    }

    public function enrollment(Request $request){

        return $this->view('member.register.enrollment');
    }

    public function agreement(Request $request){

        return $this->view('member.register.agreement');
    }
}