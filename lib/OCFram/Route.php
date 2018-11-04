<?php
namespace OCFram;

/**
 * Route
 */
class Route
{
	protected $url;
	protected $module;
	protected $action;
	protected $varNames;
	protected $vars = [];

	public function __construct(string $url, string $module, string $action, array $varNames):void
	{
		$this->url = $url;
		$this->module = $module;
		$this->action = $action;
		$this->varNames = $varNames;
		$this->vars = $vars;
	}

	public function hasVars():bool
	{
		return !empty($this->varNames);
	}
	/**
	 * Vérifie si une url matche avec l'url de la Route.
	 * @param string $url 
	 * @return mixed Array|bool Liste des valeurs des urlParams
	 */
	public function match(string $url):bool
	{
		if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
			return $matches;
		}
		else
		{
			return false;
		}
	}

	public function setAction(string $action):void
	{
		if (is_string($action)) {
			$this->action = $action;
		}
	}

	public function setUrl(string $url):void
	{
		if (is_string($url)) {
			$this->url = $url;
		}
	}

	public function setModule(string $module):void
	{
		if (is_string($module)) {
			$this->module = $module;
		}
	}

	public function setVarNames(array $varNames):void
	{
		if (is_array($varNames)) {
			$this->varNames = $varNames;
		}
	}

	public function setVars(array $vars):void
	{
		if (is_array($vars)) {
			$this->vars = $vars;
		}
	}

	public function url():string
	{
		return $this->url;
	}

	public function module():string
	{
		return $this->module;
	}

	public function action():string
	{
		return $this->action;
	}

	public function varNames():array
	{
		return $this->varNames;
	}

	public function vars():array
	{
		return $this->vars;
	}


}