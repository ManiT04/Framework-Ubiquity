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
use Ubiquity\utils\http\URequest;

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
        $this->jquery->renderView("MainController/index.html",["promos"=>$promos]);
        //$this->loadView("MainController/index.html",["promos"=>$promos]);
	}

    public function initialize() {
        $this->ui=new UIServices($this);
        parent::initialize();
        $this->jquery->getHref('a[data-target]','',['listenerOn'=>'body','hasLoader'=>'x-internal']);
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
	public function store($content='')
    {
        $sections = DAO::getAll(Section::class, '', ['products']);
        $this->jquery->renderView('MainController/store.html', compact('sections', 'content')); //2eme param pour mettre chaine string et changer le contenu principal
    }

    #[Route('section/{id}',name: 'section')]
    public function sectionsMenu($id){
        $section=DAO::getById(Section::class,$id,['products']);
        if(!URequest::isAjax()) {
            $content=$this->loadDefaultView(compact('section'),true);
            $this->store($content);
            return;
        }
        $this->loadDefaultView(compact('section')); //pour load tous de les éléments de la classe Section
    }

    #[Route('product/{idS}/{idP}',name: 'section')]
    public function detailsProduit($idS, $idP){
        $section=DAO::getById(Section::class,$idS,['products']); // ??
        $product=DAO::getById(Product::class,$idP,['products']);

        if(!URequest::isAjax()) {
            $content=$this->loadDefaultView(compact('product'),true);
            $this->store($content);
            return;
        }

        $this->loadDefaultView(compact('product')); //pour load tous de les éléments de la classe Section
    }

    #[Route('product/{id}',name: 'product')]
    public function product($id){
        $product = DAO::getById(Product::class, $id, ['products']);
        $this->loadView("MainController/detailsProduct.html");
    }
}
