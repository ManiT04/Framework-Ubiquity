<?php
namespace services\ui;

 use models\Group;
 use Ubiquity\controllers\Controller;

 /**
  * Class UIGroups
  */
class UIGroups extends \Ajax\php\ubiquity\UIService{
    public function __construct(Controller $controller) {
        parent::__construct($controller);
        //sélecteur css qui cible toutes les balise a qui contient un attribut data-target
        $this->jquery->getHref('a[data-target]',
            parameters: ['historize'=>false,'hasLoader'=>'internal','listenerOn'=>'body']); //les liens sont convertit en lien ajax
    }

    public function listGroups(array $groups) {
        $dt=$this->semantic->dataTable('dt-groups',Group::class,$groups);  //composant riche
        $dt->setFields(['name','email']);
        //personnalisation avec icon mail, icon delate et edit
        $dt->fieldAsLabel('email','mail');
        $dt->addDeleteButton();
        $dt->addEditButton();
    }

}
