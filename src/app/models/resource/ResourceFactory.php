<?php


class ResourceFactory
{
	public static function fromPath($path)
	{
		if ( !file_exists($path)) {
			return new UnknownResource($path);
		}
		if (is_dir($path)) {
			if (rtrim($path, '/') == rtrim(DIR_DATAS, '/')) {
				return new BaseFolder();
			} else {
				return new Folder($path);
			}
		} else {
			return new File($path);
		}
	}
}