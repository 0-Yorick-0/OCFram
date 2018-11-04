<?php
namespace OCFram;

/**
 * Router
 */
class Router
{
	protected $routes = [];

	const NO_ROUTE = 1;

	public function addRoute(Route $route):void
	{
		if (!in_array($route, $this->route)) {
			$this->routes[] = $route;
		}
	}

	/**
	 * Récupère une route correspondant à une URL, et lui ajoute un tableau clé/valeur avec les urlParams si nécessaire
	 * @param string $url 
	 * @return mixed Route|RuntimeException
	 */
	public function getRoute(string $url): Route
	{
		foreach ($this->routes as $route) {
			//Si la route correspond à l'url
			if (($varsValues = $route->match($url)) !== false) 
			{
				//Si elle a des variables
				if ($route->hasVars()) 
				{
					$varNames = $route->varNames();
					$listVars = [];

					//On crée un nouveau tableau clé/valeur
					// (clé = nom de la variable, valeur = sa valeur)
					foreach ($varsValues as $key => $match) 
					{
						//La première valeur renvoyée par preg_match contient entièrement la chaine capturée
						if ($key !== 0) 
						{
							$listVars[$varNames[$key - 1]] = $match;
						}
					}

					//On assigne ce tableau de variables à la route
					$route->setVars($listVars);
				}

				return $route;
			}
		}

		throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
	}
}