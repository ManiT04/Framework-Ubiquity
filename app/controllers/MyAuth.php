<?php
namespace controllers;

use models\User;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\utils\flash\FlashMessage;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;

#[Route(path:"/login",inherited: true,automated: true)]
class MyAuth extends \Ubiquity\controllers\auth\AuthController{

    public function _getBaseRoute() { //permet de préciser le nom de la route pour ne pas prendre celui par défaut soit MyAuth
        return '/login';
    }

    public function _displayInfoAsString() { //permet de spécifié l'info relative au user
        return true;
    }

    protected function finalizeAuth() {
        if(!URequest::isAjax()){
            $this->loadView('@activeTheme/main/vFooter.html');
        }
    }

    protected function initializeAuth() {
        if(!URequest::isAjax()){
            $this->loadView('@activeTheme/main/vHeader.html');
        }
    }

    public function _getBodySelector() {
        return '#page-container';
    }

    protected function onConnect($connected){
        $urlParts=$this->getOriginalURL();
        USession::set($this->_getUserSessionKey(),$connected);
        if(isset($urlParts)){
            $this->_forward(implode("/",$urlParts));
        } else{
            UResponse::header('location','/');
        }
    }

    protected function _connect(){
        if(URequest::isPost()) {
            $email=URequest::post($this->_getLoginInputName());
            $password=URequest::post($this->_getPasswordInputName());
            if($email!=null){
                $user=DAO::getOne(User::class,'email=?',false,[$email]);
                if(isset($user)){
                    USession::set('idOrga',$user->getOrganization());
                    return $user;
                }
            }
        }
        return;
    }

    public function _isValidUser($action = null){ //override methode
        return USession::exists($this->_getUserSessionKey());
    }

    protected function noAccessMessage(FlashMessage $fMessage){
        $fMessage->setTitle('Accès interdit !');
        $fMessage->setContent("Vous n'êtes pas autorisé à accéder à cette ressource.");
    }

    protected function terminateMessage(FlashMessage $fMessage) {
        $fMessage->setTitle('Fermeture');
        $fMessage->setContent("Vous avez été correctement déconnecté de l'application.");
    }

}