<?php

class Connection
{
	private $host;
	private $user;
	private $password;
	private $dbname;
	
	private $db;
	
	public function __construct ($host, $user, $password, $dbname) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->dbname = $dbname;
	}
	
	public function checkConnection () {
		try{
			if($pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password)){
				echo "<span id='recmsg'>Connection is successful.</span>";
			}
		} catch (PDOException $e) {
			echo "Connection error: " . $e->getMessage() . '.';
		}
	}
	
	public function getConnection () {
		try{
			$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
		} catch (PDOException $e) {
			echo "Connection error: " . $e->getMessage() . '.';
		}
		
		return $this->db;
	}
}



?>