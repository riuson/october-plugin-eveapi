<?php
namespace Riuson\EveApi\Commands\Eve;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Riuson\EveApi\Classes\Api\EveApiUserData;
use Riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use Riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use Riuson\EveApi\Classes\Api\EveApiCaller;

class ConquerableStations extends Command
{

    /**
     *
     * @var string The console command name
     */
    protected $name = "eveapi:eve/conquerable-stations";

    /**
     *
     * @var string The console command description
     */
    protected $description = "Returns a conquerable stations list.";

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

        $this->output->writeln(get_class($this));

        try {
            $methodInfo = EveApiCallsLibrary::eve_conquerableStationsList();
            $caller = new EveApiCaller($methodInfo, array());

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
            ]
        ];
    }
}