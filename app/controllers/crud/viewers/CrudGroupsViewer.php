<?php
namespace controllers\crud\viewers;

use Ajax\semantic\html\elements\HtmlLabel;
use Ubiquity\controllers\crud\viewers\ModelViewer;
 /**
  * Class CrudGroupsViewer
  */
class CrudGroupsViewer extends ModelViewer{

    // DataTable -----------------------------------------------------------------------------------------------------------
    public function getCaptions($captions, $className) //Retourne un tableau des captions des membres à afficher dans le DataTable
    {
        return parent::getCaptions($captions, $className);
    }

    public function getModelDataTable($instances, $model, $totalCount, $page = 1)
    {
        $dt = parent::getModelDataTable($instances, $model, $totalCount, $page);
        $dt -> fieldAsLabel('users','users'); //modifie l'apparence pour la section groups et met un icone
        /*$dt -> setValueFunction('users',function ($v,$instance) {
            return HtmlLabel::tag('',count($v)); //label pr changer l'apparence et count pr afficher le nb de users et pas ts les users
            //return \count($v);
        });*/
        return $dt;
    }


    public function recordsPerPage($model, $totalCount = 0) //Retourne le nombre d'instances à afficher au maximum dans le DataTable
    {
        return parent::recordsPerPage($model, $totalCount);
    }

    protected function getDataTableRowButtons() //Retourne les boutons à afficher dans le DataTable (edit, display ou delete)
    {
        //return parent::getDataTableRowButtons();
        return ['display','edit','delete'];
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
