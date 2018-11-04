<?php
namespace OCFram;

use OCFram\ApplicationComponent;

/**
 * 
 */
abstract class Page extends ApplicationComponent
{
	protected $contentFile;
	protected $vars = [];

	public function addVar(string $var, $value):void
	{
		if (!is_string($var) || is_numeric($var) || empty($var)) {
			throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
		}
		$this->vars[$var] = $value;
	}

	public function getGeneratedPage():string
	{
		if (!file_exists($this->contentFile)) {
			throw new \RuntimeException('La vue spécifiée n\'existe pas');
		}
		//extraction des variables associées à la vue
		extract($this->vars);
		//début de la mise en tampon
		ob_start();
			require $this->contentFile;
		//récupération du contenu de la vue
		$content = ob_get_clean();
		//affichage du layout
		ob_start();
			require __DIR__ . '/../../App/' . $this->app-name() . '/Templates/layout.php';
		return ob_get_clean();

	}

	public function setContentFile(string $contentFile):void
	{
		if (!is_string($contentFile) || empty($contentFile)) {
			throw new \InvalidArgumentException('La vue spécifiée est invalide');
		}
			$this->contentFile($contentFile);
	}
}