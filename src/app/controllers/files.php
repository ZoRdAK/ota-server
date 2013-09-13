<?php


$app->get('/apps/:folders+', function ($folders) use ($app) {
	$folder = ResourceFactory::fromPath($folders);
	if ($folder instanceof UnknownResource) {
		$app->notFound();
		$app->stop();
	}

	$app->render('files.twig', array(
		'folder' => $folder
	));
});
