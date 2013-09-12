<?php


class PlateformeIOS extends Plateforme
{

	function __construct($apps = null)
	{
		parent::__construct($apps, 'ios', 'iOS');
	}


	public function getDownloadUrlForPath($chemin)
	{
		return 'itms-services://?action=download-manifest&url=' . currentUrl() . '/dl/' . $chemin;
	}


	/**
	 * @param $app \Slim\Slim
	 * @param $File File
	 */
	public function startSpecificDownloadForResource(\Slim\Slim $app, File $File)
	{
		if ($app->request()->get('manifest') === null) {
			$url = 'itms-services://?action=download-manifest&url=' . currentUrl() . '/dl/' . $File->getPath() . '?manifest=1';
			$app->response()->body('<html>
			<head>
			<script type="text/javascript">
			window.location.href = "' . $url . '";
			</script>
			</head>
			<body>redirection en cours</body>
			</html>');
		} else {

			$plistContent = '';
			$zip = new ZipArchive;
			$res = $zip->open($File->getFullPath());
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
					'file' => $File,
					'url' => currentUrl(),
					'bundleIdentifier' => $plistArray['CFBundleIdentifier'],
					'bundleVersion' => $plistArray['CFBundleVersion'],
					'title' => $plistArray['CFBundleName'],
					'kind' => 'software'
				)
			);

		}
	}
}