<?php
$db = new Database(DB_SERVER, DB_NAME, DB_USER, DB_PASS);
foreach($db->fetchAll("SELECT * from configs") as $config) {
    $this->configs[$config["name"]] = $config["value"];
}
date_default_timezone_set($this->configs["timezone"]);
?>