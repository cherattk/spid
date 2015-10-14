Introduction:
------------
SPID (Service - Plug - Interface – Driver) est une Micro-Librairie PHP basée sur le Design Pattern "Bridge".
L'Objectif de SPID est de fournir une couche d'abstraction d'accès aux données pour les applications légères qui fournissent une API CRUD.

Requirement:
------------
  - PHP >= 5.3.0
  - \Slim\Helper\Set.php => Utilisé dans \SPID\SPID.php comme conteneur de plug.
  - \Symfony\Component\ClassLoader\UniversalClassLoader.php => (optional) utilisé dans bootstrap.php
