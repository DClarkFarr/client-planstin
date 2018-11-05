<?php 
namespace App\Http\Controllers;

class Member extends Controller {
    public function initialize(){
        $this->authorizeToken();
    }

    public function dashboard(){
        $salesforce = \App\App::salesforce();
        $this->view->user = $salesforce->getUser() ?: ['first_name' => '', 'last_name' => '', 'email' => ''];

        return $this->view('member.dashboard');
    }
}