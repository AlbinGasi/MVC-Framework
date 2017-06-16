<?php
namespace lib\models;
class Config
{
	const HOST = '';
	const DBNAME = '';
	const USER = '';
	const PASSWORD = '';
	const CONTROLLERNAME = 'url';
	const SITE_TITLE = 'Site for testing';
	const SITE_URL = 'http://localhost/testing'; // without slashes on the end
	const DASHBOARD_URL = 'http://localhost/testing/dashboard'; // without slashes oon the end
	const DASHBOARD_NAME = 'dashboard'; // without slashes on the end

	public static function get($data){
		$result = $GLOBALS['config'];
		$data = explode('/', $data);
		foreach($data as $d){
			if(isset($result[$d])){
				$result = $result[$d]; 
			}
		}
		return $result;
	}
}
?>