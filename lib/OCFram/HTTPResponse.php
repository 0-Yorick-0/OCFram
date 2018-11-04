<?php
namespace OCFram;

use OCFram\ApplicationComponent;
/**
 * Objet représentant la réponse envoyée au client
 */
class HTTPResponse extends ApplicationComponent
{
	protected $page;

	public function addHeader(string $header)
	{
		header($header);
	}

	public function redirect(string $location)
	{
		header('Location: ' . $location);
		exit;
	}

	public function redirect404()
	{
		$this->page = new Page($this->app);

		$this->page->setContentFile(__DIR__ . '/../../Errors/404.html');

		$this->addHeader('HTTP/1.0 404 Not Found');

		$this->send();
	}

	public function send()
	{
		exit($this->page->getGeneratedPage());
	}

	public function setPage(Page $page)
	{
		$this->page = $page;
	}
	//par rapport à setcookie, le dernier argument, httpOnly, est à true par sécurité
	public function setCookie(string $name, string $value = '', int $expire = 0, string $path = null, string $domain = null, bool $secure = false, bool $httpOnly = true)
	{
		setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
	}
}