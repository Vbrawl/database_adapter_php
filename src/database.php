<?php

namespace DATABASE_ADAPTER {

    require_once(DATABASE_ADAPTER_PATH."/src/adapter.php");
    require_once(DATABASE_ADAPTER_PATH."/src/result.php");

    if(extension_loaded("sqlite3")) {

        class SQLITE3Database implements DBAdapter {

            private $filepath = ":memory:";
            private $encryption = "";
            private $db = null;

            /**
             * Initialize a database adapter to work with SQLITE3
             *
             * @param string $filepath
             * @param string $encryption
             */
            function __construct($filepath = ":memory:", $encryption = "") {
                $this->filepath = $filepath;
                $this->encryption = $encryption;
            }

            private function init_db() {
                $this->db->exec('PRAGMA case_sensitive_like = true');
            }
            
            function connect() {
                if($this->db == null) {
                    $this->db = new \SQLite3($this->filepath, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $this->encryption);
                    $this->init_db();
                }
            }

            function isConnected() {
                return !!$this->db;
            }

            function lastInsertRowId() {
                return $this->db->lastInsertRowId();
            }

            function prepare($query, $params) {
                if($this->db != null) {
                    $stmt = $this->db->prepare($query);
                    foreach($params as $param => $value) {
                        $stmt->bindValue($param, $value);
                    }
                    return $stmt->getSQL(true);
                }
            }

            function execPrepared($query, $params) {
                return $this->exec($this->prepare($query, $params));
            }

            function exec($query) {
                if($this->db != null) {
                    return $this->db->exec($query);
                }
                return false;
            }

            function queryPrepared($query, $params) {
                return $this->query($this->prepare($query, $params));
            }

            function query($query) {
                $res = $this->db->query($query);
                if($res !== false) {
                    return new SQLITE3Result($res);
                }
                return false;
            }

            function close() {
                if($this->db != null) {
                    $this->db->close();
                    $this->db = null;
                }
            }
        }
    }
}
