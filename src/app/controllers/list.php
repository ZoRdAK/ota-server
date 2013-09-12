<?php




/**
 * @param $p
 * @param $chemin
 * @param $app
 */
function listerLesDossiersEtApps($p, $chemin, $app)
{
	$Plateforme = Plateforme::findById($p);
	if ($Plateforme === null) {
		$app->notFound();
		$app->stop();
	}

	$dossier = DIR . '/datas/' . $Plateforme->id . '/' . join('/', $chemin);
	if (!is_dir($dossier)) {
		$app->notFound();
		$app->stop();
	}

	if (sizeof($chemin) == 0) {
		$retourLink = '';
		$retour = 'accueil';
	} else {
		$retourLink = str_replace(DIR . '/datas/', 'apps/', dirname($dossier));
		$retour = basename(dirname($dossier));
	}
	$dossierCourant = basename($dossier);
	$dossierDl = $Plateforme->id . '/' . join('/', $chemin);

	$fs = scandir($dossier, 1);
	$fichiers = array();
	$dossiers = array();
	foreach ($fs as $fichier) {
		if ($fichier == '.' || $fichier == '..' || $fichier == '_empty' || $fichier == '.svn' || $fichier == '.DS_Store') {
			continue;
		}
		if (is_dir($dossier . '/' . $fichier)) {
			$dossiers[] = $fichier;
		} else {
			$f = new stdClass();
			$f->url = $Plateforme->getDownloadUrlForPath($dossierDl . '/' . $fichier);
			$f->nom = $fichier;
			$fichiers[] = $f;
		}
	}
	$app->render('fichiers.twig', array(
		'plateforme' => $Plateforme,
		'fichiers' => $fichiers,
		'dossiers' => $dossiers,
		'retourLink' => currentUrl() . '/' . $retourLink,
		'retour' => $retour,
		'dossierCourant' => $dossierCourant,
		'currentUrl' => $app->request()->getPath(),
		'dlUrl' => '/' . $Plateforme->id . '/' . join('/', $chemin)
	));
}

$app->get('/apps/:plateforme/:dossiers+', function ($p, $chemin) use ($app) {
	listerLesDossiersEtApps($p, $chemin, $app);
});
$app->get('/apps/:plateforme', function ($p) use ($app) {
	listerLesDossiersEtApps($p, array(), $app);
});
