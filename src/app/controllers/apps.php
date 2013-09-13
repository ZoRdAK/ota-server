<?php

$app->group('/apps', function () use ($app) {


	$app->delete('/:folders+', function ($folders) use ($app) {
		ResourceFactory::deleteFromPath($folders);
	});


	$app->get('/:folders+', function ($folders) use ($app) {
		$folder = ResourceFactory::fromPath($folders);
		if ($folder instanceof UnknownResource) {
			$app->notFound();
			$app->stop();
		}
		if (isJsonCall($app)) {
			$app->response->headers->set('Content-Type', 'application/json');
			echo json_encode($folder->listResources());
		} else {
			$app->render('files.twig', array(
				'folder' => $folder
			));
		}
	});


	$app->post('/:dossiers+', function ($dossiers) use ($app) {
		if ($app->request()->isPost() &&
			isset($_FILES['filedata']) &&
			ResourceFactory::uploadFile($dossiers, $_FILES['filedata'])
		) {
			if ($app->request()->getReferer() == toUrl('/upload')) {
				$app->redirect(toUrl('/upload'));
			} else {
				$app->halt(201, 'Fichier ajout&eacute;');
			}
		} else {
			$app->halt(403, 'Une erreur est survenue pendant l\'upload, merci de re-essayer');
		}
	});

});
