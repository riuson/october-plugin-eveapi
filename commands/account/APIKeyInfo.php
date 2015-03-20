<?php namespace riuson\EveApi\Commands\Account;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use riuson\EveApi\Classes\Api\EveApiUserData;
use riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use riuson\EveApi\Classes\Api\EveApiCaller;
use riuson\EveApi\Classes\Api;

/**
 *
 * @author vladimir
 *         Information about the API key and a list of the characters exposed by it.
 */
class APIKeyInfo extends Command {

	/**
	 *
	 * @var string The console command name
	 */
	protected $name = "eveapi:account/api-key-info";

	/**
	 *
	 * @var string The console command description
	 */
	protected $description = "Returns a list of all characters on an account.";

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

		$this->output->writeln(static::class);

		try {
			$userCredentials = new EveApiUserData(intval($keyId), $vCode);
			$methodInfo = EveApiCallsLibrary::account_apiKeyInfo();
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
			]
		];
	}
}