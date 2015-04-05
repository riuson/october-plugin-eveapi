<?php
namespace Riuson\EveApi\Commands\Server;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Riuson\EveApi\Classes\Api\EveApiUserData;
use Riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use Riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use Riuson\EveApi\Classes\Api\EveApiCaller;
use Riuson\EveApi\Classes\Api;

class ServerStatus extends Command
{

    /**
     *
     * @var string The console command name
     */
    protected $name = "eveapi:server/server-status";

    /**
     *
     * @var string The console command description
     */
    protected $description = "Requests EVE server status.";

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

        $this->output->writeln(static::class);

        try {
            $methodInfo = EveApiCallsLibrary::server_serverStatus();
            $caller = new EveApiCaller($methodInfo);

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