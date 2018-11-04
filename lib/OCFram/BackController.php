<?php
namespace OCFram;

use OCFram\ApplicationComponent;

/**
 * 
 */
abstract class BackController extends ApplicationComponent
{
	protected $action;
	protected $module;
	protected $view;
	protected $page;

	protected $managers = null;

	public function __construct(Application $app, string $module, string $action)
	{
		parent::__construct($app);

		$this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());

		$this->page = new Page($app);

		$this->setAction = $action;
		$this->setModule = $module;
		//par défaut, la vue à la même valeur que l'action
		$this->setView = $action;
	}

	public function execute():void
	{
		$method = 'execute' . ucfirst($this->action);

		if (!is_callable([$this, $method])) {
			throw new \RuntimeException('L\'action "' . $this->action . '"n\'est pas définie sur ce module');
		}

		$this->method($this->app->httpRequest());
	}

	public function page():Page
	{
		return $this->page;
	}

	public function setAction(string $action):void
	{
		if (!is_string($action) || empty($action)) {
			throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
		}
		
		$this->action = $action;
	}

	public function setModule(string $module):void
	{
		if (!is_string($module) || empty($module)) {
			throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
		}
		
		$this->module = $module;
	}

	public function setView(string $view):void
	{
		if (!is_string($view) || empty($view)) {
			throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
		}
		
		$this->view = $view;
		//on informe l'objet Page du chemin de la vue
		$this->page->setContentFile(__DIR__ . '/../../App/' . $this->app->name() . '/Modules/' . $this->module . '/Views/' . $this->view . '.php');
	}

}