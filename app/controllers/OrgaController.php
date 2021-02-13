<?php
namespace controllers;

 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use models\Organization;
 use Ubiquity\orm\repositories\ViewRepository;

 /**
 * Controller OrgaController
 **/
class OrgaController extends ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo=new ViewRepository($this,Organization::class);
    }

    #[Route('orga')]
	public function index(){
        $this->repo->all("",false);
        $this->loadView("OrgaController/index.html");

        /*$orgas=DAO::getAll(Organization::class,"",false);
        $this->loadView("OrgaController/index.html",['orgas'=>$orgas]);*/
    }

    #[Route(path: "orga/{idOrga}",name: "orga.getOne")]
    public function getOne($idOrga) {
        /*$orga=DAO::getById(Organization::class,$idOrga,['users.groupes','groupes.users']);
        $this->loadDefaultView(['orga'=>$orga]);*/

        $this->repo->byId($idOrga,['users.groupes','groupes.users']);
        $this->loadDefaultView();
    }

    #[Post(path: "orga/add",name: "orga.add")]
    public function add() {
        $this->loadView("OrgaController/addFormulaire.html");
    }

    #[Post(path: "orga/update/{idOrga}",name: "orga.update")]
    public function update($idOrga) {
        $this->repo->insert();
        $this->repo->update();
        $this->loadDefaultView();
    }

    #[Post(path: "orga/delete/{idOrga}",name: "orga.delete")]
    public function delete($idOrga) {
        $this->repo->remove();
        $this->loadDefaultView();
    }
}
