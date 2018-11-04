<?php
namespace OCFram;
/**
 * Modèle des applications Frontend et Backend
 */
abstract class Application
{
	protected $name;
	protected $httpRequest;
	protected $httpResponse;

	public function __construct()
	{
		$this->name = '';
		$this->httpRequest = new HTTPRequest($this);
		$this->httpResponse = new HTTPResponse($this);
	}

	/**
	 * 1. Instancie le router
	 * 2. Parse le fichier de routes
	 * 3. Pour chaque route, ajoute une route au router
	 * 4. Récupère l'uri demandée par la requête et tenter de trouver une correspondance via le router
	 * 5. Instancie et retourne le ctrller correspondant
	 * @throws RuntimeException
	 * @return BackController
	 */
	public function getController()
	{
		$router = new Router;

		$xml = new \DOMDocument;
		$xml->load(__DIR__ . '/../../App/' . $this->name . '/Config/routes.xml');

		$xmlRoutes = $xml->getElementsByTagName('route');

		foreach ($xmlRoutes as $xmlRoute) {
			$vars = [];
			//si des noms d'urlParams ont été renseignés dans le xml
			if ($xmlRoute->hasAttribute('vars')) {
				$vars = explode(',', $xmlRoute->getAttribute('vars'));
			}

			//On ajoute la route au routeur
			$router->addRoute(
				new Route(
					$xmlRoute->getAttribute('url'),
					$xmlRoute->getAttribute('module'),
					$xmlRoute->getAttribute('action'),
					$vars,
				)
			);
		}

		try {
			//On récupère la route correspondante à l'URL.
			$matchedRoute = $router->getRoute($this->httpRequest->requestURI());
		} catch (\RuntimeException $e) {
			if ($e->getCode() == Router::NO_ROUTE) {
				//Si aucune route ne correspond, c'est que la page demandée n'existe pas
				$this->httpResponse->redirect404();
			}
		}

		//On ajoute les variables de l'URL au tableau $_GET. (??!!)
		$_GET = array_merge($_GET, $matchedRoute->vars());

		// On instancie le contrôleur
		$controllerClass = 'App\\' . $this->name . '\\Modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller';
		return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());		
	}

	abstract public function run();

	public function httpRequest()
	{
		return $this->httpRequest;
	}

	public function httpResponse()
	{
		return $this->httpResponse;
	}

	public function name()
	{
		return $this->name;
	}
}