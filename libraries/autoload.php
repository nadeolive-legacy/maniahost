<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 *
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */
if(!defined('APP_PATH'))
{
	/**
	 * @deprecated
	 */
	define('APP_PATH', __DIR__.'/../');
}

if(!defined('APP_ROOT'))
{
	define('APP_ROOT', APP_PATH);
}

if(!defined('MANIALIB_APP_PATH'))
{
	define('MANIALIB_APP_PATH', APP_PATH);
}

spl_autoload_register(function ($className)
	{
		$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
		$path = __DIR__.DIRECTORY_SEPARATOR.$className.'.php';
		if(file_exists($path))
		{
			require_once $path;
		}
	});
?>