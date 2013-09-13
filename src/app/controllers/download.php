<?php



$app->get('/dl/:dossiers+', function ($folders) use ($app) {
	$file = ResourceFactory::fromPath($folders);
	if (!($file instanceof File)) {
		$app->notFound();
		$app->stop();
	}

	$file->startDownload($app);
});