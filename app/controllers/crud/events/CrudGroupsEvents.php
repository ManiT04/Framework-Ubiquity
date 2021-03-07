<?php
namespace controllers\crud\events;

use Ubiquity\controllers\crud\CRUDEvents;
 /**
  * Class CrudGroupsEvents
  */
class CrudGroupsEvents extends CRUDEvents{

    //Permet de modifier la requête (POST) avant modification d'une instance sourmise avec le DataForm
    public function onBeforeUpdateRequest(array &$requestValues, bool $isNew)
    {
        parent::onBeforeUpdateRequest($requestValues, $isNew);
    }

    //Permet de modifier une instance sourmise avec le DataForm avant sa soumission pour update ou insert dans la BDD
    public function onBeforeUpdate(object $instance, bool $isNew)
    {
        parent::onBeforeUpdate($instance, $isNew);
    }
}
