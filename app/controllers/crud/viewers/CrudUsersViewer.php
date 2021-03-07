<?php
namespace controllers\crud\viewers;

use Ubiquity\controllers\crud\viewers\ModelViewer;
 /**
  * Class CrudUsersViewer
  */
class CrudUsersViewer extends ModelViewer{

// DataTable -----------------------------------------------------------------------------------------------------------
    public function getCaptions($captions, $className) //Retourne un tableau des captions des membres à afficher dans le DataTable
    {
        return parent::getCaptions($captions, $className);
    }

    public function getModelDataTable($instances, $model, $totalCount, $page = 1) //Permet de modifier les champs du DataTable avec les méthodes fieldAs…
    {
        return parent::getModelDataTable($instances, $model, $totalCount, $page);
    }

    public function recordsPerPage($model, $totalCount = 0) //Retourne le nombre d'instances à afficher au maximum dans le DataTable
    {
        return parent::recordsPerPage($model, $totalCount);
    }

    protected function getDataTableRowButtons() //Retourne les boutons à afficher dans le DataTable (edit, display ou delete)
    {
        return parent::getDataTableRowButtons();
    }

// DataElement ---------------------------------------------------------------------------------------------------------
    public function getModelDataElement($instance, $model, $modal) //Permet de modifier les champs du DataElement avec les méthodes fieldAs…
    {
        return parent::getModelDataElement($instance, $model, $modal);
    }

    public function getElementCaptions($captions, $className, $instance) //Retourne un tableau des captions des membres à afficher dans le DataElement
    {
        return parent::getElementCaptions($captions, $className, $instance);
    }


// DataForm ------------------------------------------------------------------------------------------------------------
    public function isModal($objects, $model) //Retourne à quelle condition le DataForm s'affiche de façon modale
    {
    }

    public function getForm($identifier, $instance, $updateUrl = 'updateModel') //Permet de modifier les champs du DataFormavec les méthodes fieldAs…
    {
    }

    public function getFormCaptions($captions, $className, $instance) //Retourne un tableau des captions des membres à afficher dans le DataForm
    {
    }

}
