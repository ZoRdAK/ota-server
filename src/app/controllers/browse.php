<?php



$app->get('/browse', function () use ($app) {
	$elements = ResourceFactory::findAll();

	$app->render('browse.twig', array(
			'currentUrl' => currentUrl(),
			'elements' => $elements)
	);
});

$app->get('/browse/:folders', function ($folders) use ($app) {
	$folder = ResourceFactory::fromPath($folders);
	if ($folder instanceof UnknownResource) {
		$app->notFound();
		$app->stop();
	}

	$folders = array();
	foreach($folder->getFolders() as $f){
		$folders[] = $f->getName();
	}
	$app->response->headers->set('Content-Type', 'application/json');
	echo json_encode($folders);
});

