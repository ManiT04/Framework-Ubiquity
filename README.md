# Projet Ubiquity - Module M4102C_2

Ce projet consiste à faire une application web permettant aux clients de préparer leurs commandes en ligne et de convenir d'un moment pour venir les chercher (app full-stack Ubiquity). Cette application se base sur le framework Ubiquity, qui est un framework open source php. Il s'appuie sur une architecture de type MVC (modèle-vue-contrôleur), c'est également le framework php fullstack le plus performant. Il est également plus simple que certains frameworks php.
https://slamwiki2.kobject.net/backoffice/ubiquity/td4#mpd_de_la_base_de_donnees (modèle physique de données)

## Prerequis

Vous aurez besoin des éléments suivants correctement installés sur votre ordinateur.

* php >=7.4
* [Git](https://git-scm.com/)
* [Composer](https://getcomposer.org)
* [Ubiquity devtools](https://ubiquity.kobject.net/)

## Installation

* `git clone <repository-url>` ce repository
* `cd tds`
* `composer install`

## Lancement / Developpement

* `Ubiquity serve`
* Visitez votre application à cette adresse : [http://127.0.0.1:8090](http://127.0.0.1:8090).

## Principe et fonctionnement

Pour ce projet, ce qu'on utilise principalement sont les controllers associés à des vues. Les vues correspondent à l'aspect visuel de la page, et le controller va faire l'action et contenir toutes les routes du projet. POur définir une route, il faut ajouter l'entête : `#[Route('newRoute',name: 'new.route')]`. Les controller et les routes peuvent s'ajouter également à partir de l'interface utilisateur à l'adresse : http://127.0.0.1:8090/Admin
* Quelques commandes : 
* Ubiquity controller new-controller : pour créer un controller, l(option `-v` permet de créer une vue avec.
* Ubiquity action MainController.information -p=title,message='nothing' -r=info/{title}/{message} -v : cet exemple crée une action (information) avec deux paramètres (titre et message), et une vue pour afficher le message


## En cas d'erreur ...

* Faire un `composer require phpmv/ubiquity:dev-master` pour mettre à jour Ubiquity et éviter certains problèmes.
* `Ubiquity init-cache`, quand on crée de nouvelles routes.

## Non implémenté 

* Sprint 1 non complet :
 * basket/add/{idProduct} ⇒ Ajouter un produit au panier
 * basket/addTo/{idBasket}/{idProduct} ⇒ Ajouter un produit à un panier spécifique
 * La section "Consultés récemment" n'affiche pas les produits comme demandé
 
* Sprint 2 non complet :
 * basket ⇒ Modifier la quantité d'un produit
 * basket/validate ⇒ Valide le panier
  * Affiche le montant de la commande
  * Affiche la liste des timeSlots disponibles dans les prochains jours
  * Lien vers basket/timeslot/{idTimeslot} ⇒ Choisir un timeSlot
  * Lien vers basket/command ⇒ Valider la commande
  * Lien vers basket/clear ⇒ Vider le panier

## Liens utiles

* https://slamwiki2.kobject.net/backoffice/ubiquity
  * https://slamwiki2.kobject.net/backoffice/ubiquity/td4
  * https://slamwiki2.kobject.net/backoffice/ubiquity/td5
  * https://slamwiki2.kobject.net/backoffice/ubiquity/td6
  
* [Ubiquity website](https://ubiquity.kobject.net/)
* [Guide](http://micro-framework.readthedocs.io/en/latest/?badge=latest)
* [Doc API](https://api.kobject.net/ubiquity/)
* [Twig documentation](https://twig.symfony.com)
* [Semantic-UI](https://semantic-ui.com)
