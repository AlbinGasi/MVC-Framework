<?php

class Entity
{
	private static $_db;

	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public function insert(){
		$table_name = static::$table_name;
		$q = "INSERT INTO {$table_name} (";
		$val = "";
		foreach($this as $k => $v){
			$q .= $k . ", ";
			$val .= "?, ";
		}
		$q = trim($q,", ");
		$q .= ") VALUES (";
		$q .= $val;
		$q = trim($q,", ");
		$q .= ")";

		$stmt = self::$_db->prepare($q);
		$count_val = 1;
		foreach($this as $k => $v){
			$stmt->bindValue($count_val,$v);
			$count_val++;
		}
		if($stmt->execute()){return true;}else{return false;}
	}
	
	public static function get_by_id($id){
		$table_name = static::$table_name;
		$key_column = static::$key_column;
		$class_name = get_called_class();
		$q = self::$_db->prepare("SELECT * FROM {$table_name} WHERE {$key_column}=:id");
		$q->bindParam(':id',$id);
		$q->execute();
		$obj = $q->fetchObject($class_name);
		return $obj;
	}
	
	public static function get_all($select=null,$where=null){
		$table_name = static::$table_name;
		
		if($select === null){
			$stmt = self::$_db->query("SELECT * FROM {$table_name} {$where}");
		}else if($where === null){
			$stmt = self::$_db->query("SELECT {$select} FROM {$table_name}");
		}else if($select !== null && $where !== null){
			$stmt = self::$_db->query("SELECT * FROM {$table_name}");
		}
		
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function update($id, $username = null){
			
		$table_name = static::$table_name;
		$key_column = static::$key_column;
		$q = "UPDATE {$table_name} SET ";
		
		foreach($this as $k => $v){
			if($k == $key_column) continue;
			$q .= $k . "  = ?, ";
		}
		
		$q = trim($q, ", ") . " WHERE {$key_column} = ?";
		if($table_name == Config::get('table_prefix')."users"){ $q .= " and username = ? "; }
		$stmt = self::$_db->prepare($q);
		$n = 1;
		foreach($this as $k => $v){
			$stmt->bindValue($n,$v);
			$n++;
		}
		$stmt->bindValue($n,$id);
		if($table_name == Config::get('table_prefix')."users"){ $n++; $stmt->bindValue($n,$username);}
		if($stmt->execute()){return true;}else{ return false;}
		
	}
	

}

Entity::Init();

			





?>