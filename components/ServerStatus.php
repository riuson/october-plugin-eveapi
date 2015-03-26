<?php namespace Riuson\EveApi\Components;

use Cms\Classes\ComponentBase;
use riuson\EveApi\Classes\Api\EveApiCaller;
use riuson\EveApi\Classes\Api\EveApiCallsLibrary;

class ServerStatus extends ComponentBase {

	/**
	 *
	 * @var bool Is server open
	 */
	public $serverOpen;

	/**
	 *
	 * @var integer Number of players online
	 */
	public $onlinePlayers;

	public function componentDetails()
	{
		return [
			'name' => 'ServerStatus Component',
			'description' => 'Shows EVE Online Server Status'
		];
	}

	public function defineProperties()
	{
		return [];
	}

	public function init()
	{
		// This will execute when the component is
		// first initialized, including AJAX events.
	}

	public function onRun()
	{
		// This cide will not execure for AJAX events

		$methodInfo = EveApiCallsLibrary::server_serverStatus();
		$caller = new EveApiCaller($methodInfo);

		$answer = $caller->call();

		$this->serverOpen = $answer->values->byName('serverOpen');
		$this->onlinePlayers = $answer->values->byName('onlinePlayers');
	}
}