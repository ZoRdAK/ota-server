<?php


class PlateformeIOS extends Plateforme
{

	function __construct($apps = null)
	{
		parent::__construct($apps, 'ios', 'iOS');
	}

	public function startSpecificDownloadForFile(\Slim\Slim $app, $dossier, $fichier)
	{
		//Extract informations about ipa
		// assuming file.zip is in the same directory as the executing script.
		$file = DIR . '/' . $dossier . '/' . $fichier;

		// get the absolute path to $file
		$path = DIR . '/' . $dossier . '/iTunes.plist';

		$plistContent = '';
		$zip = new ZipArchive;
		$res = $zip->open($file);
		if ($res === TRUE) {

			for ($i = 0; $i < $zip->numFiles; $i++) {
				$stat = $zip->statIndex($i);
				if (preg_match("/^Payload\/(.*)\.app\/Info\.plist$/", $stat['name']) === 1) {
					$plistContent = $zip->getFromIndex($i);
					break;
				}
			}
			$zip->close();
		} else {
			$app->halt(500, 'Impossible de lire le fichier IPA');
			die();
		}

		if (trim($plistContent) == '' || $plistContent === false) {
			$app->halt(500, 'Contenu du pList vide');
			die();
		}

		require_once(DIR . '/vendor/rodneyrehm/plist/classes/CFPropertyList/CFPropertyList.php');
		$plist = new CFPropertyList\CFPropertyList();
		try {
			$plist->parseBinary($plistContent);
		} catch (\CFPropertyList\PListException $e) {
			$plist->parse($plistContent);
		}

		$plistArray = $plist->toArray();

		$app->response->headers->set('Content-Type', 'application/x-plist');
		$app->response->headers->set('Content-disposition', 'attachment; filename="application.plist"');
		$app->render('plateformes/ios.twig',
			array(
				'plateforme' => $this,
				'fichier' => $dossier . '/' . $fichier,
				'url' => currentUrl(),
				'bundleIdentifier' => $plistArray['CFBundleIdentifier'],
				'bundleVersion' => $plistArray['CFBundleVersion'],
				'title' => $plistArray['CFBundleName'],
				'kind' => 'software'
			)
		);
	}

	public function getDownloadUrlForPath($chemin)
	{
		return 'itms-services://?action=download-manifest&url=' . currentUrl() . '/dl/' . $chemin;
	}

	public function getDownloadUrl(Version $Version)
	{
		$appUrl = $this->id . '/' . $Version->Section->Application->id . '/' . $Version->Section->id . '/' . $Version->id;
		return $this->getDownloadUrlForPath($appUrl);
	}

	public function getAppFileFromDirectory($dir)
	{
		if (is_dir(DIR . $dir)) {
			$fichiers = scandir(DIR . $dir);
			foreach ($fichiers as $fichier) {
				if ($fichier == '.' || $fichier == '..' || is_dir($fichier) || pathinfo($fichier, PATHINFO_EXTENSION) != 'ipa') {
					continue;
				}
				return $fichier;
				break;
			}
		}
		return null;
	}
}