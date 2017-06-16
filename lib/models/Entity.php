<?php
namespace lib\models;
class Entity
{
	private static $_db;

	public static function Init() {
		self::$_db = Connection::getInstance();
	}

	public function get_by_id($id) {
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;

		$className = get_called_class();

		$stmt = self::$_db->prepare('SELECT * FROM '.$tableName.' WHERE ' . $keyColumn . '=:id');
		$stmt->bindParam('id',$id);
		$stmt->execute();

		$res = $stmt->fetchObject($className);
		return $res;
	}

	public function get_all(){
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;

		$className = get_called_class();
		
		$stmt = self::$_db->query('SELECT * FROM '.$tableName);
		$res = $stmt->fetchAll(\PDO::FETCH_CLASS,$className);
		return $res;
	}

	public function update ($id) {
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;

		$q = "UPDATE {$tableName} SET ";
		
		foreach($this as $k => $v){
			if($k == $keyColumn) continue;
			$q .= $k . "  = ?, ";
		}
		
		$q = trim($q, ", ") . " WHERE {$keyColumn} = ?";

		$stmt = self::$_db->prepare($q);
		$n = 1;
		foreach($this as $k => $v){
			$stmt->bindValue($n,$v);
			$n++;
		}
		$stmt->bindValue($n,$id);
		if($stmt->execute()){return true;}else{ return false;}
	}


}
Entity::Init();
?>