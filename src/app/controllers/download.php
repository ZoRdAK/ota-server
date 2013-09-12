<?php



$app->get('/dl/:plateforme/:dossiers+', function ($p, $chemin) use ($app) {
	$Plateforme = Plateforme::findById($p);
	if ($Plateforme === null) {
		$app->notFound();
		$app->stop();
	}

	$fichier = array_pop($chemin);
	$dossier = 'datas/' . $Plateforme->id . '/' . join('/', $chemin);

	$Plateforme->startSpecificDownloadForFile($app, $dossier, $fichier);


});