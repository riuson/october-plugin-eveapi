<?php namespace riuson\EveApi;

use System\Classes\PluginBase;

/**
 * eveapi Plugin Information File
 */
class Plugin extends PluginBase {

	/**
	 * Returns information about this plugin.
	 *
	 * @return array
	 */
	public function pluginDetails()
	{
		return [
			'name' => 'EveApi',
			'description' => 'PHP interface for EVE API',
			'author' => 'riuson',
			'icon' => 'icon-leaf'
		];
	}

	public function register()
	{
		$this->registerConsoleCommand('eveapi.server.serverstatus', 'riuson\EveApi\Commands\Server\ServerStatus');
		$this->registerConsoleCommand('eveapi.account.accountstatus', 'riuson\EveApi\Commands\Account\AccountStatus');
		$this->registerConsoleCommand('eveapi.account.apikeyinfo', 'riuson\EveApi\Commands\Account\APIKeyInfo');
		$this->registerConsoleCommand('eveapi.account.characters', 'riuson\EveApi\Commands\Account\Characters');
		$this->registerConsoleCommand('eveapi.char.assetlist', 'riuson\EveApi\Commands\Char\AssetList');
		$this->registerConsoleCommand('eveapi.corp.membertracking', 'riuson\EveApi\Commands\Corp\MemberTracking');
	}

	public function registerComponents()
	{
		return [
			'riuson\EveApi\Components\ServerStatus' => 'serverStatus'
		];
	}
}
