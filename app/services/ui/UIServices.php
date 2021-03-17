<?php
namespace services\ui;

 use Ubiquity\controllers\Controller;
 use Ubiquity\utils\http\URequest;

 /**
  * Class UIServices
  */
class UIServices extends \Ajax\php\ubiquity\UIService{

    public function __construct(Controller $controller) {
        parent::__construct($controller);
        if(!URequest::isAjax()) {
            $this->jquery->getHref('a[data-target]', '', ['hasLoader' => 'internal', 'historize' => false,'listenerOn'=>'body']);
        }
    }

    /*public function index(User $user){
        $bt=$this->semantic->htmlDropdown('dd-groupes','',JArray::modelArray($user->getGroups(),'getId')); //??
        $bt->setAction('hide');
        $lbl=$bt->addLabel('');
        $lbl->addClass('basic inverted black')->setProperty('style','display:none')->setIdentifier('lbl-group');
        $this->jquery->getOnClick('#dd-groupes .item',Router::path('groups.addTo',['']),'#add-to-group',['hasLoader'=>'internal-x','attr'=>'data-value','stopPropagation'=>false,'preventDefault'=>false]);
        $bt->setValue('Ajouter des utilisateurs au groupe...');
        $bt->addClass('olive');
        $bt->addIcon('walking');
        $bt->asButton();
    }*/
}
