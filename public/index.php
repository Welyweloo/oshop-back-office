<?php

// POINT D'ENTRÉE UNIQUE : 
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';
session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter, afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : Nom du contrôleur, suivi d'un séparateur (#), suivi du nom de la méthode à appeler
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map('GET', '/', 'MainController#home', 'main-home');

//connexion user
$router->map('GET|POST', '/login/back-office-login', 'LoginController#backOfficeLogin', 'back-office-login');

//connexion user
$router->map('GET|POST', '/login/first-login', 'LoginController#FirstLogin', 'first-login');

//Déconnexion
$router->map('GET', '/login/back-office-logout', 'LoginController#Disconnect', 'back-office-logout');

//route pour l'affichage de la liste des catégories
$router->map('GET', '/category/list', 'CategoryController#list', 'category-list');

//ajout de categorie
$router->map('GET|POST', '/category/add', 'CategoryController#add', 'category-add');

//update d'une categorie
$router->map('GET|POST', '/category/update/[i:id]', 'CategoryController#update', 'category-update');

//suppresion d'une categorie
$router->map('GET', '/category/delete/[i:id]', 'CategoryController#delete', 'category-delete');

//route pour l'affichage de la liste des produits
$router->map('GET', '/product/list', 'ProductController#list', 'product-list');

//ajout de produit
$router->map('GET|POST', '/product/add', 'ProductController#add', 'product-add');

//update d'un produit
$router->map('GET|POST', '/product/update/[i:id]', 'ProductController#update', 'product-update');

//suppresion d'un produit
$router->map('GET', '/product/delete/[i:id]', 'ProductController#delete', 'product-delete');

//route pour l'affichage de la liste des types
$router->map('GET', '/type/list', 'TypeController#list', 'type-list');

//ajout de type
$router->map('GET|POST', '/type/add', 'TypeController#add', 'type-add');

//update d'un type
$router->map('GET|POST', '/type/update/[i:id]', 'TypeController#update', 'type-update');

//suppresion d'un type
$router->map('GET', '/type/delete/[i:id]', 'TypeController#delete', 'type-delete');

//route pour l'affichage de la liste des brands
$router->map('GET', '/brand/list', 'BrandController#list', 'brand-list');

//ajout de brand
$router->map('GET|POST', '/brand/add', 'BrandController#add', 'brand-add');

//update d'un brand
$router->map('GET|POST', '/brand/update/[i:id]', 'BrandController#update', 'brand-update');

//suppresion d'un brand
$router->map('GET', '/brand/delete/[i:id]', 'BrandController#delete', 'brand-delete');

//route pour l'affichage de la liste des users
$router->map('GET', '/user/list', 'UserController#list', 'user-list');

//ajout de user
$router->map('GET|POST', '/user/add', 'UserController#add', 'user-add');

//update d'un user
$router->map('GET|POST', '/user/update/[i:id]', 'UserController#update', 'user-update');

//suppresion d'un user
$router->map('GET', '/user/delete/[i:id]', 'UserController#delete', 'user-delete');

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

//pour éviter de répéter partout le namespace, tx ben
$dispatcher->setControllersNamespace('\App\Controllers');


// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();