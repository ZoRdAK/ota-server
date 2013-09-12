<?php


/**
 * @param $p
 * @param $dossiers
 * @param $app
 */
function uploadFile($p, $dossiers, $app)
{
	$Plateforme = Plateforme::findById($p);
	if ($Plateforme === null) {
		$app->notFound();
		$app->stop();
	}

	if ($app->request()->isPost()) {
		if (isset($_FILES['filedata'])) {
			$file = $_FILES['filedata'];
			$dossier = DIR . '/datas/' . $Plateforme->id . '/' . join('/', $dossiers);
			@mkdir($dossier, 0777, true);
			$fichier = basename($file['name']);
			return move_uploaded_file($file['tmp_name'], $dossier . '/' . $fichier);
		}
	}
	return false;
}


$app->get('/upload', function () use ($app) {
	$app->render('upload.twig', array(
		'plateformes' => Plateforme::findAllPlateformes()
	));
});


$app->post('/upload/:plateforme/:dossiers+', function ($p, $dossiers) use ($app) {
	if (uploadFile($p, $dossiers, $app)) {
		$app->redirect('/upload');
	} else {
		$app->halt(403, 'Une erreur est survenue pendant l\'upload, merci de re-essayer');
	}

});
$app->post('/apps/:plateforme/:dossiers+', function ($p, $dossiers) use ($app) {
	if (uploadFile($p, $dossiers, $app)) {
		$app->halt(201, 'Fichier ajout&eacute;');
	} else {
		$app->halt(403, 'Une erreur est survenue pendant l\'upload, merci de re-essayer');
	}
});