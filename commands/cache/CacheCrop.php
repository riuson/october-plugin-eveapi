<?php
namespace Riuson\EveApi\Commands\Cache;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Riuson\EveApi\Models\Cache as CacheModel;
use Carbon\Carbon;

class CacheCrop extends Command
{

    /**
     *
     * @var string The console command name
     */
    protected $name = "eveapi:cache/crop";

    /**
     *
     * @var string The console command description
     */
    protected $description = "Remove obsolete records.";

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
        $days_keep = intval($this->option('days_keep'));

        $this->output->writeln(get_class($this));

        try {
            $now = Carbon::now('UTC');
            $beforeDate = $now->subDay($days_keep);
            $affected = CacheModel::where('cachedUntil', '<', $beforeDate)->delete();

            if ($debug) {
                $this->output->writeln(sprintf('Removed %d records before latest %d days (%s).', $affected, $days_keep, $beforeDate));
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
            [
                'days_keep',
                null,
                InputOption::VALUE_OPTIONAL,
                'Number of latest keeped days.',
                2
            ],
        ];
    }
}