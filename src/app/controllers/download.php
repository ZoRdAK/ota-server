<?php



$app->get('/dl/:dossiers+', function ($chemin) use ($app) {


	$path = rtrim(DIR_DATAS . join('/', $chemin), '/');

	$file = ResourceFactory::fromPath($path);
	if (!($file instanceof File)) {
		$app->notFound();
		$app->stop();
	}

	$file->startDownload($app);
});