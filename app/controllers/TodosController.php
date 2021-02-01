<?php
namespace controllers;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

/**
 * Controller TodosController
 * @property \Ajax\php\ubiquity\JsUtils $jquery //permet d'avoir de la complétion de code sur une var : $this : jquery apparait
 **/
class TodosController extends ControllerBase{
    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID='not saved';
    const LIST_SESSION_KEY='list';
    const ACTIVE_LIST_SESSION_KEY='active-list';

    public function initialize(){
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->menu();
    }

    #[Route(path: "_default",name: "todos.home")]
    public function index(){
        if(USession::exists(self::LIST_SESSION_KEY)) {
            $list = USession::get(self::LIST_SESSION_KEY);
            return $this->displayList($list);
        }

        $this->showMessage('Bienvenue !','TodoLists permet de gérer des listes...','info','info circle',
            [['url'=> Router::path('todos.new'),'caption'=>'Créer une nouvelle liste','style'=>'basic inverted']]);

    }


    #[Get(path: "todos/delete/{index}",name: "todos.delete")]
    public function deleteElement($index){}

    #[Get(path: "todos/saveList/",name: "todos.save")]
    public function saveList(){}

    #[Get(path: "todos/loadList/{uniquid}",name: "todos.loadList")]
    public function loadList($uniquid){}

    #[Post(path: "todos/loadList/",name: "todos.loadListPost")]
    public function loadListFromForm(){}

    #[Post(path: "todos/edit/{index}",name: "todos.edit")]
    public function editElement($index){
        $list=USession::get(self::LIST_SESSION_KEY); //Récupère la liste en session
        $list[]=URequest::post('element'); //Récupère les données du POST
        if(USession::exists(self::ACTIVE_LIST_SESSION_ID)){  //Teste l'existance de la clé ACTIVE_LIST_SESSION_ID
            $list=USession::set(self::ACTIVE_LIST_SESSION_ID,$index); //Modifie une valeur à la position index
        }

        $this->displayList($list); //Ajoute l'élément dans la liste
    }

    #[Post(path: "todos/add/", name: "todos.add")]
    public function addElement(){
       /* $list=USession::get(self::LIST_SESSION_KEY); //que la saisie seule
        $list[]=URequest::post('element');
        USession::set(self::LIST_SESSION_KEY,$list);
        $this->displayList($list);*/

        $list=USession::get(self::LIST_SESSION_KEY); //saisie seule et multiple
        if(URequest::filled('elements')) { //Récupère les données du POST
            $elements=explode("\n",URequest::post('elements'));
            foreach($elements as $elm) {
                $list[]=$elm; //Ajoute l'élément dans la liste
            }
        } else {
            $list[]= URequest::post('element'); //Récupère les données du POST
        }
        USession::set(self::LIST_SESSION_KEY,$list); //Récupère la liste en session
        $this->displayList($list); //Affiche la liste
    }

    #[Get(path: "todos/new/{force}",name: "todos.new")]
    public function newlist($force=false){
        USession::set(self::LIST_SESSION_KEY,[]);
        $this->displayList([]);
    }

    private function menu() {
        $this->loadView('TodosController/index.html');
    }

    private function displayList($list) {
        if(\count($list)>0){
            $this->jquery->show('._saveList','','',immediatly: true);
            //$this->jquery->show('._editList','','',immediatly: true);
        }
        $this->jquery->change('#multiple','$("._form").toggle();'); //#multiple (saisie multiple) est l'élément d'id multiple ds index, s'i 'il change les elmt de form (._form pr avoir le form) bascule en visible/invisible
        $js = 'let $item=$(event.target).closest("div.item");$item.children(".toToggle").toggle();';
        $this->jquery->click('._toEdit', $js,true,true);


        //$this->loadView('TodosController/displayList.html',['list'=>$list]);
        $this->jquery->renderView('TodosController/displayList.html',['list'=>$list]); //différence entre renderView et loadView : render fait la compilation du script HTML et passe un script_foot au HTML
    }

    private function showMessage(string $header, string $message, string $type='info', string $icon='info circle', array $buttons=[]) {
        $this->loadView('TodosController/showMessage.html',
            compact('header','type', 'icon', 'message','buttons'));
    }
}
