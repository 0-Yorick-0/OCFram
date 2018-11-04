<?php
namespace OCFram;

use OCFram\ApplicationComponent;

/**
 * Objet représentant la requête client
 */
class HTTPRequest extends ApplicationComponent
{
	public function cookieData(string $key):string
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

	public function cookieExists(string $key): bool
	{
		return isset($_COOKIE[$key]);
	}

	public function getData(string $key):string
	{
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}

	public function getExists(string $key): bool
	{
		return isset($_GET[$key]);
	}

	public function postData(string $key):string
	{
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	public function postExists(string $key): bool
	{
		return isset($_POST[$key]);
	}

	public function requestURI(): string
	{
		return $_SERVER['REQUEST_URI'];
	}

	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}