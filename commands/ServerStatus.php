<?php namespace riuson\EveApi\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ServerStatus extends Command
{
    /**
     * @var string The console command name
     */
    protected $name = "eveapi:server-status";
    
    /**
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

        $this->output->writeln('Hello world!!!');
        
        if ($debug) {
            $this->output->writeln('Debug mode.');
        }
    }
    
    protected function getArguments(){
        return [];
    }

    protected function getOptions(){
        // name, shortcut, mode, description, defaultValue
        return [
            ['debug', null, InputOption::VALUE_NONE, 'Show debug output.', null],
        ];
    }
}