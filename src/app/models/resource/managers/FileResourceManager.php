<?php

require_once DIR . '/app/models/resource/managers/ResourceManager.php';

class FileResourceManager implements ResourceManager
{

	public static function deleteDirectory($dir)
	{
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!static::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
		}
		return rmdir($dir);
	}

	public function exists($path)
	{
		return file_exists($path);
	}

	public function isDirectory($path)
	{
		return is_dir($path);
	}

	public function isBaseFolder($path)
	{
		return rtrim($path, '/') == rtrim(DIR_DATAS, '/');
	}

	/**
	 * @param $Resource Resource
	 */
	public function delete($Resource)
	{
		$element = $Resource->getFullPath();
		if ($Resource instanceof Folder) {
			FileResourceManager::deleteDirectory($element);
		} else {
			if ($Resource instanceof File) {
				@unlink($element);
			}
		}
	}

	public function findAll()
	{
		$path = realpath(DIR_DATAS);

		$elements = array();

		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach ($objects as $name => $object) {
			if (in_array($object->getFilename(), hiddenFiles())) {
				continue;
			}
			$element = ResourceFactory::fromPath($name);
			$elements[] = $element;
		}
		return $elements;
	}
}