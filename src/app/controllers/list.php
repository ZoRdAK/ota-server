<?php


$app->get('/apps/:folders+', function ($folders) use ($app) {
	$path = rtrim(DIR_DATAS . join('/', $folders), '/');

	$folder = ResourceFactory::fromPath($path);
	if ($folder instanceof UnknownResource) {
		$app->notFound();
		$app->stop();
	}

	$app->render('fichiers.twig', array(
		'folder' => $folder
	));
});
