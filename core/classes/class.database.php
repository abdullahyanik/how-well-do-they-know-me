<?php
class Database
{
    protected $db;
    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
	function fetch($query) {
		return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
	}
	function fetchAll($query) {
		return $this->db->query($query, PDO::FETCH_ASSOC)->fetchAll();
	}
	function query($query,$arr = null) {
		$process = $this->db->prepare($query);
		$result = $process->execute($arr);
		return $result;
	}
	function  __destruct() {
		$this->db = null;
	}

}
?>