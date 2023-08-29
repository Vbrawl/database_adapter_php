<?php



namespace DATABASE_ADAPTER {

    require_once(DATABASE_ADAPTER_PATH.'/src/adapter.php');

    if(extension_loaded("sqlite3")) {

        class SQLITE3Result implements RESULTAdapter {

            private ?\SQLite3Result $res = null;

            public function __construct(\SQLite3Result $results) {
                $this->res = $results;
            }

            public function getRowA() : array | false {
                return $this->res->fetchArray(SQLITE3_ASSOC);
            }

            public function getRowI() : array | false {
                return $this->res->fetchArray(SQLITE3_NUM);
            }

        }

    }

}
