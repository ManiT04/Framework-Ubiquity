<?php
namespace controllers;
use Ajax\service\JArray;
use models\Product;
use models\Section;
use services\dao\UserRepository;
use services\ui\UIServices;
use Ubiquity\attributes\items\di\Autowired;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;

/**
 * Controller MainController
 **/
class MainController extends ControllerBase{
    use WithAuthTrait;

    #[Autowired]
    private UserRepository $repo; //injection le repository dans le controller
    private UIServices $ui;


    #[Route('_default',name: 'home')]
	public function index(){
        $u=$this->_getAuthController()->_getActiveUser();
        $this->repo->byId($u->getId(),true,false,'user');
        $promos=DAO::getAll(Product::class,'promotion<?',false,[0]);
        //$this->jquery->renderView("MainController/index.html",["promos"=>$promos]);
        $this->loadView("MainController/index.html",["promos"=>$promos]);
	}

    public function initialize() {
        $this->ui=new UIServices($this);
        parent::initialize();
        $this->jquery->getHref('a[data-target]','',['listenerOn'=>'body']);
    }

    public function getRepo(): UserRepository { return $this->repo; }

    public function setRepo(UserRepository $repo): void {
        $this->repo = $repo;
    }

    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }

    #[Route('store',name: 'store')]
	public function store(){
        $sections=DAO::getAll(Section::class,'',['products']);
        //$this->jquery->renderView("MainController/store.html");
        $this->loadDefaultView(compact('sections'));
	}

    #[Route('section/{idSection}',name: 'section')]
    public function sectionsMenu($id){
        $section=DAO::getById(Section::class,$id,['products']);
        $this->jquery->renderView("MainController/sectionsMenu.html");
       //$this->loadView("MainController/sectionsMenu.html");
    }

}
