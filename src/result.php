<?php



namespace DATABASE_ADAPTER {

    require_once(DATABASE_ADAPTER_PATH.'/src/adapter.php');

    if(extension_loaded("sqlite3")) {

        class SQLITE3Result implements RESULTAdapter {

            private $res = null;

            public function __construct($results) {
                $this->res = $results;
            }

            public function getRowA() {
                return $this->res->fetchArray(SQLITE3_ASSOC);
            }

            public function getRowI() {
                return $this->res->fetchArray(SQLITE3_NUM);
            }

        }

    }

}
