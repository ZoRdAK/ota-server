<?php


$app->post('/delete', function () use ($app) {
	$paths = $app->request()->post('paths');
	if ($paths) {
		foreach ((array)$paths as $path) {
			ResourceFactory::deleteFromPath($path);
		}
	}

	$app->halt(200, 'Supprime');
});