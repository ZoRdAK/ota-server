<?php

require 'vendor/autoload.php';

require 'config.php';


$app = new \Slim\Slim(array(
	'view' => initSlimView()
));

require_once 'app/tools/utils.php';
require_once 'app/models/resource/ResourceFactory.php';
require_once 'app/models/resource/Resource.php';
require_once 'app/models/resource/File.php';
require_once 'app/models/resource/Folder.php';
require_once 'app/models/resource/UnknownResource.php';
require_once 'app/models/resource/BaseFolder.php';
require_once 'app/models/plateformes/Plateforme.php';
require_once 'app/models/Application.php';

require_once 'app/controllers/home.php';
require_once 'app/controllers/browse.php';
require_once 'app/controllers/delete.php';
require_once 'app/controllers/download.php';
require_once 'app/controllers/list.php';
require_once 'app/controllers/upload.php';


$app->run();