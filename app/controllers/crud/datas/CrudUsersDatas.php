<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;
 /**
  * Class CrudUsersDatas
  */
class CrudUsersDatas extends CRUDDatas{

    public function getFieldNames($model) //Retourne un tableau des membres à afficher dans le DataTable
    {
        return parent::getFieldNames($model);
    }

    public function getFormFieldNames($model, $instance) //Retourne un tableau des membres à afficher dans le formulaire (DataForm)
    {
        return parent::getFormFieldNames($model, $instance);
    }

    public function _getInstancesFilter($model) //Retourne la partie WHERE de l'instruction SQL permettant de filter les utilisateurs
    {
        return parent::_getInstancesFilter($model);
    }

    public function getManyToManyDatas($fkClass, $instance, $member) //Retourne la liste des instances disponibles pour alimenter le membre $member avec un ManyToMany (par exemple la liste des utilisateurs ou des groupes de l'organisation)
    {
        return parent::getManyToManyDatas($fkClass, $instance, $member);
    }

}
