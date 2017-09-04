<?php

require_once DIR . '/app/models/resource/managers/ResourceManager.php';

class FileResourceManager implements ResourceManager
{

	public static function deleteDirectory($dir)
	{
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scan_dir($dir) as $item) {
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

	public function isPlateformeFolder($path)
	{
		return Plateforme::findById(str_replace(DIR_DATAS,'',$path)) !== null;
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

	public function findInPath($path){
		$path = realpath(DIR_DATAS.$path);

		$elements = array();

		$objects = new DirectoryIterator($path);
		foreach ($objects as $name => $object) {
			if (in_array($object->getFilename(), hiddenStandardFiles())) {
				continue;
			}
			$element = ResourceFactory::fromPath($path.DIRECTORY_SEPARATOR.$object->getFilename());
			$elements[] = $element;
		}
		return $elements;
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

	public function addFile($filename, $srcFile, $folder)
	{
        if ( !is_dir($folder) ) {
            @mkdir($folder, 0777, true);
        }
		return move_uploaded_file($srcFile, $folder . '/' . $filename);
	}

}