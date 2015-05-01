<?php
namespace Riuson\EveApi;

use System\Classes\PluginBase;

/**
 * eveapi Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'riuson.eveapi::lang.plugin.name',
            'description' => 'riuson.eveapi::lang.plugin.description',
            'author' => 'Riuson',
            'icon' => 'icon-leaf'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('eveapi.server.serverstatus', 'Riuson\EveApi\Commands\Server\ServerStatus');
        $this->registerConsoleCommand('eveapi.account.accountstatus', 'Riuson\EveApi\Commands\Account\AccountStatus');
        $this->registerConsoleCommand('eveapi.account.apikeyinfo', 'Riuson\EveApi\Commands\Account\APIKeyInfo');
        $this->registerConsoleCommand('eveapi.account.characters', 'Riuson\EveApi\Commands\Account\Characters');
        $this->registerConsoleCommand('eveapi.char.assetlist', 'Riuson\EveApi\Commands\Char\AssetList');
        $this->registerConsoleCommand('eveapi.char.charactersheet', 'Riuson\EveApi\Commands\Char\CharacterSheet');
        $this->registerConsoleCommand('eveapi.char.skilltraining', 'Riuson\EveApi\Commands\Char\SkillTraining');
        $this->registerConsoleCommand('eveapi.corp.membertracking', 'Riuson\EveApi\Commands\Corp\MemberTracking');
        $this->registerConsoleCommand('eveapi.eve.characterinfo', 'Riuson\EveApi\Commands\Eve\CharacterInfo');
        $this->registerConsoleCommand('eveapi.eve.conquerable', 'Riuson\EveApi\Commands\Eve\ConquerableStations');
    }

    public function registerComponents()
    {
        return [
            'Riuson\EveApi\Components\ServerStatus' => 'serverStatus'
        ];
    }

    public function registerSchedule($schedule)
    {
        // request server status every 5 minutes
        $schedule->command('eveapi:server/server-status')->everyFiveMinutes();
    }
}
