<?php
namespace Riuson\EveApi\Commands\Eve;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Riuson\EveApi\Classes\Api\EveApiUserData;
use Riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use Riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use Riuson\EveApi\Classes\Api\EveApiCaller;
use Riuson\EveApi\Classes\Api;

class CharacterInfo extends Command
{

    /**
     *
     * @var string The console command name
     */
    protected $name = "eveapi:eve/character-info";

    /**
     *
     * @var string The console command description
     */
    protected $description = "Returns a public character info.";

    /**
     * Create a new command instance
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     */
    public function fire()
    {
        $debug = $this->option('debug');
        $keyId = $this->option('keyID');
        $vCode = $this->option('vCode');
        $characterID = $this->option('characterID');

        $this->output->writeln(get_class($this));

        try {
            $userCredentials = new EveApiUserData(intval($keyId), $vCode, $characterID);
            $methodInfo = EveApiCallsLibrary::eve_characterInfo();
            $caller = new EveApiCaller($methodInfo, array(), $userCredentials);

            if ($debug) {
                $caller->setDebug(true);
            }

            $caller->call();
        } catch (Exception $e) {
            if ($debug) {
                $this->output->writeln($e->getMessage());
            }
        }
    }

    protected function getArguments()
    {
        // name, mode, description, defaultValue
        return [];
    }

    protected function getOptions()
    {
        // name, shortcut, mode, description, defaultValue
        return [
            [
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Show debug output.',
                null
            ],
            [
                'keyID',
                null,
                InputOption::VALUE_REQUIRED,
                'EVE API Key ID.',
                null
            ],
            [
                'vCode',
                null,
                InputOption::VALUE_REQUIRED,
                'EVE API Verification Code.',
                null
            ],
            [
                'characterID',
                null,
                InputOption::VALUE_REQUIRED,
                'Character ID.',
                null
            ]
        ];
    }
}