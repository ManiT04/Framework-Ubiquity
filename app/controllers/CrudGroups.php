<?php
namespace controllers;
use controllers\crud\datas\CrudGroupsDatas;
use Ubiquity\controllers\crud\CRUDDatas;
use controllers\crud\viewers\CrudGroupsViewer;
use Ubiquity\controllers\crud\viewers\ModelViewer;
use controllers\crud\events\CrudGroupsEvents;
use Ubiquity\controllers\crud\CRUDEvents;
use controllers\crud\files\CrudGroupsFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/groups",inherited: true,automated: true)]
class CrudGroups extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\Group';
		$this->style='';
	}

	public function _getBaseRoute() {
		return '/groups';
	}
	
	protected function getAdminData(): CRUDDatas{
		return new CrudGroupsDatas($this);
	}

	protected function getModelViewer(): ModelViewer{
		return new CrudGroupsViewer($this,$this->style);
	}

	protected function getEvents(): CRUDEvents{
		return new CrudGroupsEvents($this);
	}

	protected function getFiles(): CRUDFiles{
		return new CrudGroupsFiles();
	}


}
