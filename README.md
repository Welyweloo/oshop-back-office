# Oblog Project

Ce projet est un back-office pour le projet oshop 

Contributors
--
- Ecole O'Clock : Singleton Pattern pour la connexion à la BDD
- Damien B. : méthode getShortDescription()
- Ben O'clock : Dépendance Alto-Dispatcher 

Content
--
Un back offiche pour le site oshop permettant aux utilisateurs autorisées d'accéder à leur espace. Deux rôles possibles admin ou catalog-manaer.
Permet d'ajouter des produits, catégories, marques, types et des utilisateurs pour les admins.

Pour tenter l'expérience, connectez-vous avec les identifiants suivants :
- Login: admin@oshop.fr
- Password: cameleon

Realisation
--

J'ai pu m'exercer en travaillant sur l'affichage dynamique des informations en BDD.
C'était un bel exercice pour travailler en CRUD avec la POO/architecture MVC et des jointures SQL. J'ai abordé pour la première fois les notions d'authentification, de permissions et de rôles. 

- Temps pris : Deux jours en  Avril 2020
  
- Langages, frameworks et utilitaires:
  - PHP
  - SQL
  - Singleton Pattern
  - Active Records Pattern
  - Composer --> Symfony var-dumper, autoload, altorouter, alto-dispatcher


- Difficultés rencontrées :
    - Gestion de l'authentification
    - Gestion des permissions 
    - Effectuer les vérifications et factoriser 

- Evolutions possibles :
  - Ajouter une méthode dans le CoreController, un token et des input hidden afin de protéger tous les form contre les attaques CSRF
  - Gestion des permissions et factorisation avec ACL