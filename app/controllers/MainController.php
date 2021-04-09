<?php
namespace controllers;
use Ajax\service\JArray;
use models\Basket;
use models\Basketdetail;
use models\Order;
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
use Ubiquity\utils\http\USession;

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
       // $product=DAO::getAll(Product::class,'promotion<?',false,[0]);
        $promos=DAO::getAll(Product::class,'promotion<?',false,[0]);

        //$recentViewedproducts = USession::get('recentViewedProducts');

        $this->jquery->renderView("MainController/index.html",["product"=>$promos]);//, ["recentViewedproducts"=>$recentViewedproducts]);
        //$this->loadView("MainController/index.html",["promos"=>$promos]);
	}

    public function initialize() {
        $this->ui=new UIServices($this);
        parent::initialize();
        /*if(!URequest::isAjax()) {
            $this->jquery->getHref('a[data-target]', '', ['listenerOn' => 'body', 'hasLoader' => 'internal-x']);
        }*/
    }

    public function getRepo(): UserRepository {
        return $this->repo;
    }

    public function setRepo(UserRepository $repo): void {
        $this->repo = $repo;
    }

    protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }

    #[Route('store',name: 'store')]
	public function store($content='') {
        $sections = DAO::getAll(Section::class, '', ['products']);
        $promos=DAO::getAll(Product::class,'promotion<?',['section'],[0]);
        $recentViewedProducts = USession::get('recentViewedProducts');

        $this->jquery->renderView('MainController/store.html', compact('sections', 'content','promos','recentViewedProducts'));
        //2eme param pour mettre chaine string et changer le contenu principal
    }

    #[Route('section/{id}',name: 'section')]
    public function sectionsMenu($id){
        $section=DAO::getById(Section::class,$id,['products']);
        if(!URequest::isAjax()) {
            $content=$this->loadDefaultView(compact('section'),true);
            $this->store($content);
            return;
        }
        $this->loadDefaultView(compact('section')); //pour load tous de les éléments de la classes Section
    }

    #[Route('product/{idS}/{idP}',name: 'product')]
    public function detailsProduit($idS, $idP){
        $section=DAO::getById(Section::class,$idS,false);
        $product=DAO::getById(Product::class,$idP,false);

        if(!URequest::isAjax()) { //avoir le menu
            $content=$this->loadView("MainController/detailsProduct.html",compact('product', 'section'),true);
            $this->store($content);
            return;
        }
        $this->loadView("MainController/detailsProduct.html",["product"=>$product,"section"=>$section]);
    }
//------------------------------------------------Test------------------------------------------------------------------
    #[Route('productTest/{id}',name: 'productTest')]
    public function product($id){
        $product = DAO::getById(Product::class, $id, false);
        if(!URequest::isAjax()) { //avoir le menu
            $content=$this->loadView("MainController/detailsProduct.html",compact('product'),true);
            $this->store($content);
            return;
        }
        $this->loadView("MainController/detailsProduct.html",["product"=>$product]);
    }


    //------------------------------------------------------------------------------------------------------------------
    #[Route('basket/add/{id}',name: 'add.basket')] //panier session
    public function addBasket($id){
        /*$basketDetail = new Basketdetail();
        $basketDetail->setIdBasket($id);
        $basketDetail->setQuantity(1);
        $basket = $this->getBasket();
        $basket->addBasketDetail($basketDetail);
        USession::set('basket',$basket);*/

        $basket = $this->getBasket();
        $quantity = $basket->getQuantity();
        $basket->addProduct($id, $quantity);
    }

    #[Route('basket/add/{idBasket}/{idProduct}',name: 'addTo.basket')] //panier specicique
    public function addToBasket($idBasket, $idProduct){
        $basket = DAO::getById(Basketdetail::class, $idBasket, ['products']);
        //$product = DAO::getById(Product::class, $idProduct, ['products']);
        //$this->loadView("MainController/detailsProduct.html");

        $quantity = $basket->getQuantity();
        $basket->addProduct($idProduct, $quantity);
    }

    //------------------------------------------------------------------------------------------------------------------

    #[Route('displayBasket',name: 'displayBasket')] ///afficher les paniers du user
    public function displayBasket(){
        $baskets = DAO::getAll(Basket::class, '', ['basketdetails']);
        $this->loadView("MainController/displayBasket.html", compact('baskets'));
    }

    #[Route('basket/{id}',name: 'basket')] ///afficher le panier
    public function basket($id){
        $basket = DAO::getAll(Basket::class, $id, ['basketdetails']);
        $this->loadView("MainController/detailsBasket.html",compact('basket'));
    }

    #[Route('myOrders',name: 'myOrders')]
    public function myOrders(){
        //$orders = DAO::getAll(Order::class, '', ['orderdetails']);
        $orders = DAO::getAll(Order::class,false, false);
        $this->loadView("MainController/myOrders.html",compact('orders'));
    }





}
