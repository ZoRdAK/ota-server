<?php

require 'vendor/autoload.php';

require 'config.php';


$app = new \Slim\Slim(array(
	'view' => initSlimView()
));

require_once DIR . '/app/tools/utils.php';
require_once DIR . '/app/models/resource/ResourceFactory.php';

require_once DIR . '/app/models/resource/managers/FileResourceManager.php';

require_once DIR . '/app/models/plateformes/Plateforme.php';

require_once DIR . '/app/controllers/apps.php';
require_once DIR . '/app/controllers/download.php';
require_once DIR . '/app/controllers/pages.php';

ResourceFactory::setResourceManager(new FileResourceManager());

$app->run();