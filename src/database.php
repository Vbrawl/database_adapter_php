<?php

namespace DATABASE_ADAPTER {

    require_once(DATABASE_ADAPTER_PATH."/src/adapter.php");
    require_once(DATABASE_ADAPTER_PATH."/src/result.php");

    if(extension_loaded("sqlite3")) {

        class SQLITE3Database implements DBAdapter {

            private string $filepath = ":memory:";
            private string $encryption = "";
            private ?\SQLite3 $db = null;

            /**
             * Initialize a database adapter to work with SQLITE3
             *
             * @param string $filepath
             * @param string $encryption
             */
            function __construct(string $filepath = ":memory:", string $encryption = "") {
                $this->filepath = $filepath;
                $this->encryption = $encryption;
            }

            private function init_db() : void {
                $this->db->exec('PRAGMA case_sensitive_like = true');
            }
            
            function connect() : void {
                if($this->db == null) {
                    $this->db = new \SQLite3($this->filepath, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $this->encryption);
                    $this->init_db();
                }
            }

            function isConnected() : bool {
                return !!$this->db;
            }

            function lastInsertRowId() : int {
                return $this->db->lastInsertRowId();
            }

            function prepare(string $query, array $params) : string {
                if($this->db != null) {
                    $stmt = $this->db->prepare($query);
                    foreach($params as $param => $value) {
                        $stmt->bindValue($param, $value);
                    }
                    return $stmt->getSQL(true);
                }
            }

            function execPrepared(string $query, array $params) : bool {
                return $this->exec($this->prepare($query, $params));
            }

            function exec(string $query) : bool {
                if($this->db != null) {
                    return $this->db->exec($query);
                }
                return false;
            }

            function queryPrepared(string $query, array $params) : ?SQLITE3Result {
                return $this->query($this->prepare($query, $params));
            }

            function query(string $query) : ?SQLITE3Result {
                $res = $this->db->query($query);
                if($res !== false) {
                    return new SQLITE3Result($res);
                }
                return false;
            }

            function upsert(string $insert_statement, string $update_statement, array $params) : bool {
                $executed = $this->execPrepared($insert_statement, $params);
                if(!$executed) $executed = $this->execPrepared($update_statement, $params);
                return $executed;
            }

            function close() : void {
                if($this->db != null) {
                    $this->db->close();
                    $this->db = null;
                }
            }
        }
    }
}
