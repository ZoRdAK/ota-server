<?php


$app->post('/delete', function () use ($app) {
	function deleteDirectory($dir)
	{
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
		}
		return rmdir($dir);
	}

	$paths = $app->request()->post('paths');
	if ($paths) {
		foreach ($paths as $path) {
			$element = DIR . '/datas/' . $path;
			if (is_dir($element)) {
				deleteDirectory($element);
			} else {
				if (file_exists($element)) {
					unlink($element);
				}
			}
		}
	}

	$app->halt(200, 'Supprime');
});