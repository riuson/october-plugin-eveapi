<?php namespace riuson\EveApi;

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
            'name'        => 'EveApi',
            'description' => 'PHP interface for EVE API',
            'author'      => 'riuson',
            'icon'        => 'icon-leaf'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('eveapi.serverstatus', 'riuson\EveApi\Commands\ServerStatus');
        //$this->registerConsoleCommand('eveapi.mycommand', 'riuson\EveApi\Commands\MyConsoleCommand');
    }
}
