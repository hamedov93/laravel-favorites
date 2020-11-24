<?php

namespace Hamedov\Favorites;

class Favorites {

	/**
	 * Get user model class name specified in config.
	 */
	public static $userModel = null;

	/**
	 * An empty instance of the user model.
	 * @var Illuminate\Database\Eloquent\Model
	 */
	public static $userInstance = null;

	/**
	 * Set user model to be used.
	 * @param string $model Model fully qualified class name.
	 */
	public static function setUserModel($model)
	{
		if ( ! class_exists($model)) {
			return;
		}
		
		self::$userModel = $model;
		self::$userInstance = new $model;
	}

	/**
	 * Get an empty instance of user model
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public static function userInstance()
	{
		return self::$userInstance;
	}

	/**
	 * Get user model
	 * @return string
	 */
	public static function userModel()
	{
		return self::$userModel;
	}

	/**
	 * Get foreign key of user model
	 * @return string
	 */
	public static function userForeignKey()
	{
		return (self::$userInstance)->getForeignKey();
	}

	/**
	 * Get users table
	 * @return string
	 */
	public static function userTable()
	{
		return (self::$userInstance)->getTable();
	}
}
