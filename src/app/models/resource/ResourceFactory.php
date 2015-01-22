<?php

require_once DIR . '/app/models/resource/managers/ResourceManager.php';
require_once DIR . '/app/models/resource/Resource.php';
require_once DIR . '/app/models/resource/File.php';
require_once DIR . '/app/models/resource/Folder.php';
require_once DIR . '/app/models/resource/UnknownResource.php';
require_once DIR . '/app/models/resource/PlateformeFolder.php';
require_once DIR . '/app/models/resource/BaseFolder.php';

class ResourceFactory
{
	/**
	 * @var ResourceManager
	 */
	static $ResourceManager;

	/**
	 * @param ResourceManager $Manager
	 */
	public static function setResourceManager(ResourceManager $Manager)
	{
		static::$ResourceManager = $Manager;
	}

	public static function fromPath($path)
	{
		$path = static::cleanPath($path);
		if (!static::$ResourceManager->exists($path)) {
			return new UnknownResource($path);
		}
		if (static::$ResourceManager->isDirectory($path)) {
			if (static::$ResourceManager->isBaseFolder($path)) {
				return new BaseFolder();
			} else if (static::$ResourceManager->isPlateformeFolder($path)) {
				return new PlateformeFolder($path);
			} else {
				return new Folder($path);
			}
		} else {
			return new File($path);
		}
	}

	private static function cleanPath($path)
	{
		if (is_array($path)) {
			return rtrim(DIR_DATAS . join('/', $path), '/');
		}
		if (strpos($path, DIR_DATAS) === false) {
			$path = DIR_DATAS . $path;
		}
		return $path;
	}

	public static function deleteFromPath($path)
	{
		$Resource = static::fromPath($path);
		if (!($Resource instanceof PlateformeFolder) && !($Resource instanceof UnknownResource)) {
			static::$ResourceManager->delete($Resource);
		}
	}

	public static function findAll()
	{
		return static::$ResourceManager->findAll();
	}

	public static function uploadFile($path, $file)
	{
		if (isset($file)) {
			return static::$ResourceManager->addFile(basename($file['name']), $file['tmp_name'], static::cleanPath($path));
		}
		return false;
	}

	public static function findInPath($path)
	{
		return static::$ResourceManager->findInPath($path);
	}
}