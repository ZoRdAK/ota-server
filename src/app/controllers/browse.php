<?php



$app->get('/browse', function () use ($app) {
	$path = realpath(DIR . '/datas');

	$elements = array();

	$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
	foreach ($objects as $name => $object) {
		if (in_array($object->getFilename(), hiddenFiles())) {
			continue;
		}
		$element = new stdClass();

		$element->isDir = is_dir($name);
		$element->id = str_replace(DIR . '/datas/', '', $name);
		$element->chemin = str_replace('/', ' / ', $element->id);
		$element->nom = $object->getFilename();

		$elements[] = $element;

	}

	$app->render('browse.twig', array(
			'currentUrl' => currentUrl(),
			'elements' => $elements)
	);
});

$app->get('/browse/:plateforme(/:dossiers)', function ($p, $chemin = '') use ($app) {
	$Plateforme = Plateforme::findById($p);
	if ($Plateforme === null) {
		$app->notFound();
		$app->stop();
	}

	$dossier = DIR . '/datas/' . $Plateforme->id . '/' . $chemin;
	$fs = scandir($dossier, 1);
	$dossiers = array();
	foreach ($fs as $fichier) {
		if (in_array($fichier, hiddenFiles())) {
			continue;
		}
		if (is_dir($dossier . '/' . $fichier)) {
			$dossiers[] = $fichier;
		}
	}

	$app->response->headers->set('Content-Type', 'application/json');
	echo json_encode($dossiers);
});

