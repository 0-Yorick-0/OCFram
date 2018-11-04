<?php
namespace OCFram;

/**
 * 
 */
class Managers
{
	protected $api = null;
	protected $dao = null;
	protected $managers = [];

	public function __construct(string $api, $dao):void
	{
		$this->api = $api;
		$this->dao = $dao;
	}

	public function getManagerOf(string $module)
	{
		if (!is_string($module) || empty($module)) {
			throw new \InvalidArgumentException('Le module spécifié est invalide');
		}
		//si le manager du module demandé n'est pas renseigné dans $this->managers, on crée une nouvelle instance que l'on renseigne dans $this->managers
		if (!isset($this->managers[$module])) {
			$manager = '\\Model\\' . $module . 'Manager' . $this->api;

			$this->managers[$module] = new $manager($this->dao);
		}

		return $this->managers[$module];
	}
}