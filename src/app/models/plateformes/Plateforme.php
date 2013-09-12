<?php

require_once DIR . '/app/models/plateformes/PlateformeAndroid.php';
require_once DIR . '/app/models/plateformes/PlateformeIOS.php';
require_once DIR . '/app/models/plateformes/PlateformeWindowsPhone.php';

abstract class Plateforme
{
	private $apps;
	public $id;
	public $nom;

	function __construct($apps, $id, $nom)
	{
		$this->apps = $apps;
		$this->id = $id;
		$this->nom = $nom;
	}

	public function startDownloadFor(\Slim\Slim $app, Plateforme $Plateforme, $appId, $sectionId, $versionId)
	{
		$dir = $this->getApplicationVersionDir($Plateforme, $appId, $sectionId, $versionId);
		$exe = $this->getAppFileFromDirectory($dir);
		if ($exe == null) {
			$app->notFound();
			$app->stop();
		} else {
			$this->startSpecificDownloadForFile($app, $dir, $exe);
		}
	}


	public function getAppFileFromDirectory($dir)
	{
		if (is_dir(DIR . $dir)) {
			$fichiers = scandir(DIR . $dir);
			foreach ($fichiers as $fichier) {
				if ($fichier == '.' || $fichier == '..' || is_dir($fichier)) {
					continue;
				}
				return $fichier;
				break;
			}
		}
		return null;
	}


	/**
	 * @param $id
	 * @return Plateforme | null
	 */
	public static function findById($id)
	{
		$plateformes = static::findAllPlateformes();
		foreach ($plateformes as $p) {
			if ($p->id == $id) {
				return $p;
			}
		}
		return null;
	}

	/**
	 * @param $id
	 * @return Application|null
	 */
	public function findAppById($id)
	{
		$applications = $this->getApps();
		foreach ($applications as $application) {
			if ($application->id == $id) {
				return $application;
			}
		}
		return null;
	}

	public abstract function getDownloadUrl(Version $Version);

	public abstract function getDownloadUrlForPath($chemin);

	public static function findAllPlateformes()
	{

		return array(
			new PlateformeIOS(),
			new PlateformeAndroid(),
//            new PlateformeWindowsPhone()
		);

	}

	function getApps()
	{
		$applications = array();
		$dossier = DIR . '/datas/' . $this->id;
		$fichiers = scandir($dossier);
		foreach ($fichiers as $fichier) {
			if ($fichier == '.' || $fichier == '..') {
				continue;
			}

			if (is_dir($dossier . '/' . $fichier)) {
				$applications[] = new Application($fichier, $fichier, $this);
			}
		}
		return $applications;
	}

	public abstract function startSpecificDownloadForFile(\Slim\Slim $app, $dossier, $fichier);

	private function getApplicationVersionDir($Plateforme, $appId, $sectionId, $versionId)
	{
		return '/datas/' . $Plateforme->id . '/' . $appId . '/' . $sectionId . '/' . $versionId;
	}
}