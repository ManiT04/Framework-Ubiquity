<?php
namespace services\ui;

 use Ajax\semantic\html\collections\form\HtmlForm;
 use Ajax\semantic\widgets\dataform\DataForm;
 use models\Group;
 use models\User;
 use Ubiquity\controllers\Controller;
 use Ubiquity\controllers\Router;
 use Ubiquity\utils\http\URequest;

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


    //----------------------------------------------------------------------------------------------------------------------------

    private function addFormBehavior(string $formName,HtmlForm|DataForm $frm,string $responseElement,string $postUrlName){
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $this->jquery->click("#$formName-div ._validate",'$("#'.$formName.'").form("submit");');
        $this->jquery->click("#$formName-div ._cancel",'$("#'.$formName.'-div").hide();');
        $frm->setSubmitParams(Router::path($postUrlName),'#'.$responseElement,['hasLoader'=>'internal']);
    }

    public function newUser($formName){
        $frm=$this->semantic->dataForm($formName,new User());
        $frm->addClass('inline');
        $frm->setFields(['firstname','lastname']);
        $frm->setCaptions(['Prénom','Nom']);
        $frm->fieldAsLabeledInput('firstname',['rules'=>'empty']); //rules empty : pr dire que c'est un champ obligatoire
        $frm->fieldAsLabeledInput('lastname',['rules'=>'empty']);
        $this->addFormBehavior($formName,$frm,'new-user','new.userPost');
        //$this->addFormBehavior($formName,$frm,'#new-user','new.userPost');
    }


    public function newUsers($formName){
        $frm=$this->semantic->dataForm($formName,new User());
        $frm->addClass('inline');
        $frm->setFields(["Utilisateurs\n"]);
        $frm->fieldAsTextarea(0);
        //$frm->setCaptions(["Entrez chaque utilisateurs sur une ligne"]);
        //$frm->fieldAsTextareaInput('Utilisateurs',['rules'=>'empty']);

        $this->addFormBehavior($formName,$frm,'new-user','new.usersPost');
    }

    public function newGroup($formName){
        $frm=$this->semantic->dataForm($formName,new Group());
        $frm->addClass('inline');
        $frm->setFields(['name']);
        $frm->setCaptions(['Nom']);
        $frm->fieldAsLabeledInput('name',['rules'=>'empty']); //rules empty : pr dire que c'est un champ obligatoire
        $this->addFormBehavior($formName,$frm,'new-group','new.groupPost');
    }
}
