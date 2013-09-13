<?php

require_once DIR . '/app/models/resource/managers/ResourceManager.php';

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
		if ( strpos($path,DIR_DATAS) === false ){
			$path = DIR_DATAS.$path;
		}
		return $path;
	}

	public static function deleteFromPath($path)
	{
		$Resource = static::fromPath($path);
		static::$ResourceManager->delete($Resource);
	}

	public static function findAll()
	{
		return static::$ResourceManager->findAll();
	}
}