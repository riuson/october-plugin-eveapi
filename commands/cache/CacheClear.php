<?php
namespace Riuson\EveApi\Commands\Cache;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Riuson\EveApi\Models\Cache as CacheModel;

class CacheClear extends Command
{

    /**
     *
     * @var string The console command name
     */
    protected $name = "eveapi:cache/clear";

    /**
     *
     * @var string The console command description
     */
    protected $description = "Clear all cached requests.";

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
            CacheModel::truncate();

            if ($debug) {
                $this->output->writeln('Cache table truncated.');
            }

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
        ];
    }
}