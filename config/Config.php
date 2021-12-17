<?php

abstract class Database {
	abstract function connect();
	abstract function execute($query);
	abstract function get_row();
	abstract function get_num_rows();
	abstract function close_connection();
}
class Config extends Database {
	private $db;
	private $host;
	private $user;
	private $password;
	private $database;
	private $query;
	private $result;
	private $row;
	private $num_rows;

	function __construct() {
		$this->host = "localhost";
		$this->user = $dbuser;//"root";
		$this->password = $dbpass;//"root";
		$this->database = $dbname;//"gammu";
	}

	function connect() {
		$this->db = mysqli_connect($this->host, $this->user, $this->password,$this->database);
		//mysqli_select_db($this->database, $this->db);
	}

	function execute($query) {
		$this->query = $query;
		$this->result = mysqli_query($this->query, $this->db) or die('<h1 style="color:red;text-weight:bold">Error, query failed!</h1>');
	}

	function get_array() {
		if($this->row === mysqli_fetch_array($this->result, mysqli_ASSOC))
			return $this->row;
		else
			return false;
	}

	function get_row() {
		if($this->row === mysqli_fetch_array($this->result, mysqli_NUM))
			return $this->row;
		else
			return false;
	}

	function get_object() {
		if($this->row === mysqli_fetch_object($this->result, mysqli_ASSOC))
			return $this->row;
		else
			return false;
	}

	function get_dataset() {
		$dataset = array();
		$i = 0;
		while($r = mysqli_fetch_row($this->result)) {
			if($r === FALSE) {
    			die(mysqli_error());
			}
			$field = 0;
			for($field = 0; $field < mysqli_num_fields($this->result); $field++) {
				$dataset[$i][$field] = $r[$field];
			}
			$i++;
		}
		return $dataset;
	}

	function get_json($nama) {
		$json = array();
		while($r = mysqli_fetch_assoc($this->result)) {
			$json[] = $r;
		}
		$data = array($nama => $json);
		return json_encode($data);
	}

	function get_num_rows() {
		$this->num_rows = mysqli_num_rows($this->result);
		return $this->num_rows;
	}

	function close_connection() {
		mysqli_close($this->db);
	}
}


?>
