<?php namespace riuson\EveApi\Classes;

use riuson\EveApi\Classes\EveApiCallsLibraryItem;

/**
 * Calls library
 */
class EveApiCallsLibrary {

	public static function server_serverStatus()
	{
		$result = new EveApiCallsLibraryItem("/server/ServerStatus.xml.aspx", 0, "Server Status");
		return $result;
	}

	public static function account_accountStatus()
	{
		$result = new EveApiCallsLibraryItem("/account/AccountStatus.xml.aspx", 33554432, "Account Status", array(
			"keyId",
			"verificationCode"
		));
		return $result;
	}
}
