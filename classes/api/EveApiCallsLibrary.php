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
			"keyID",
			"vCode"
		));
		return $result;
	}

	public static function account_characters()
	{
		$result = new EveApiCallsLibraryItem("/account/Characters.xml.aspx", 0, "List of Characters", "riuson\EveApi\Classes\Api\Account\Characters", array(
			"keyID",
			"vCode"
		));
		return $result;
	}

	public static function account_apiKeyInfo()
	{
		$result = new EveApiCallsLibraryItem("/account/APIKeyInfo.xml.aspx", 0, "Information about the API key and a list of the characters exposed by it", "riuson\EveApi\Classes\Api\Account\APIKeyInfo", array(
			"keyID",
			"vCode"
		));
		return $result;
	}

	public static function char_assetList()
	{
		$result = new EveApiCallsLibraryItem("/char/AssetList.xml.aspx", 0, "List of assets owned by character", "riuson\EveApi\Classes\Api\Char\AssetList", array(
			"keyID",
			"vCode",
			"characterID"
		));
		return $result;
	}
}
