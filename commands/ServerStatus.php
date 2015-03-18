<?php namespace riuson\EveApi\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use riuson\EveApi\Classes\EveApiUserData;
use riuson\EveApi\Classes\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\EveApiCallsLibrary;
use riuson\EveApi\Classes\EveApiCaller;
use riuson\EveApi\Classes\riuson\EveApi\Classes;

class ServerStatus extends Command {

	/**
	 *
	 * @var string The console command name
	 */
	protected $name = "eveapi:server-status";

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
			$userCredentials = new EveApiUserData(123, 'vvvv');
			// $this->output->writeln(sprintf("key id: %d", $userCredentials->keyId));
			// $this->output->writeln(sprintf("vcode: %s", $userCredentials->verificationCode));
			// $this->output->writeln(sprintf("charid: %s", $userCredentials->characterId));

			$methodInfo = EveApiCallsLibrary::server_serverStatus();
			// $this->output->writeln(sprintf("common name: %s", $methodInfo->commonName()));
			// $this->output->writeln(sprintf("access mask: %d", $methodInfo->accessMask()));
			// $this->output->writeln(sprintf("uri: %s", $methodInfo->uri()));

			$caller = new EveApiCaller($methodInfo, array(), $userCredentials, true);
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