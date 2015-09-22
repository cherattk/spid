Introduction:
------------
SPID (Service - Plug - Interface – Driver) est un Micro-Framework PHP qui implémente le Design Pattern « Bridge ».
L'Objectif de SPID est de fournir une couche d'abstraction facile à
maintenir et modulaire pour les applications légères qui veulent fournir une API CRUD.

Requirement:
------------
  - PHP >= 5.3.0
  - \Slim\Helper\Set.php => Utilisé dans \SPID\SPID.php comme conteneur de plug.
  - \Symfony\Component\ClassLoader\UniversalClassLoader.php => (optional) utilisé dans bootstrap.php
