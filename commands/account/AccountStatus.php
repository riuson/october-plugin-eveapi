<?php namespace riuson\EveApi\Commands\Account;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use riuson\EveApi\Classes\Api\EveApiUserData;
use riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use riuson\EveApi\Classes\Api\EveApiCaller;
use riuson\EveApi\Classes\Api;

class AccountStatus extends Command {

	/**
	 *
	 * @var string The console command name
	 */
	protected $name = "eveapi:account/account-status";

	/**
	 *
	 * @var string The console command description
	 */
	protected $description = "Requests user account status.";

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
			$userCredentials = new EveApiUserData(0, '000');
			// $this->output->writeln(sprintf("key id: %d", $userCredentials->keyId));
			// $this->output->writeln(sprintf("vcode: %s", $userCredentials->verificationCode));
			// $this->output->writeln(sprintf("charid: %s", $userCredentials->characterId));

			$methodInfo = EveApiCallsLibrary::account_accountStatus();
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