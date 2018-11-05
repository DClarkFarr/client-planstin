<?php 
namespace App\Http\Controllers;

class Account extends Controller {
    public function initialize(){
        $this->authorizeToken();
    }

    public function dashboard(){
        $salesforce = \App\App::salesforce();

        $accountService = new \App\Services\Account;

        //$base = $accountService->fetchBase();
        //$describe = $accountService->describe();
        //$list = $accountService->list();
        //$account = $accountService->getById($list[0]['Id']);
        //$response = $accountService->update('0012a00000UDbOQAA1', ['Name' => 'Client 1.3']);
        
        $this->view->user = $salesforce->getUser() ?: ['first_name' => '', 'last_name' => '', 'email' => ''];

        return $this->view('account.dashboard');
    }



}