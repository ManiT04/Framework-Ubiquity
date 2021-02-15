<?php
namespace services\ui;

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

}
