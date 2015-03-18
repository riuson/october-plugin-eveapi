<?php namespace riuson\EveApi\Classes\Api;

use riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;

/**
 * Calls library
 */
class EveApiCallsLibrary {

	public static function server_serverStatus()
	{
		$result = new EveApiCallsLibraryItem("/server/ServerStatus.xml.aspx", 0, "Server Status", "riuson\EveApi\Classes\Api\Server\ServerStatus");
		return $result;
	}

	public static function account_accountStatus()
	{
		$result = new EveApiCallsLibraryItem("/account/AccountStatus.xml.aspx", 33554432, "Account Status", "riuson\EveApi\Classes\Api\Account\AccountStatus", array(
			"keyId",
			"verificationCode"
		));
		return $result;
	}
}
