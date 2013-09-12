<?php

require 'vendor/autoload.php';

define('DIR', dirname(__FILE__));


$app = new \Slim\Slim(array(
	'view' => new \Slim\Views\Twig()
));
$view = $app->view();
$view->parserDirectory = 'vendor/twig/twig/lib/Twig';


require_once 'app/tools/utils.php';
require_once 'app/models/plateformes/Plateforme.php';
require_once 'app/models/Application.php';

require_once 'app/controllers/accueil.php';
require_once 'app/controllers/browse.php';
require_once 'app/controllers/delete.php';
require_once 'app/controllers/download.php';
require_once 'app/controllers/list.php';
require_once 'app/controllers/upload.php';


$app->run();