<?php
namespace OCFram;
/**
 * Cette classe se charge juste de stocker l'instance de l'application executée
 */
abstract class ApplicationComponent
{
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function app()
	{
		return $this->app;
	}
}