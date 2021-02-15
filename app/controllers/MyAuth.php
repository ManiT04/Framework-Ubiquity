<?php
namespace controllers;

 use models\User;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\UResponse;
 use Ubiquity\utils\http\USession;

 #[Route(path:"/login",inherited: true,automated: true)]
class MyAuth extends Ubiquity\controllers\auth\AuthController{

    #[Route(path: "/login/",name: "login")]
	public function index(){
		$this->loadDefaultView();
	}

    public function _displayInfoAsString() {
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
        USession::set($this->getUserSessionKey(),$connected);
        if(isset($urlParts)){
            $this->_forward(implode("/",$urlParts));
        } else{
            UResponse::header('locarion','/');
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
}
