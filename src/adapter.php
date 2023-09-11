<?php

namespace DATABASE_ADAPTER {


    interface DBAdapter {

        /**
         * Open a connection to the database. Prepare the database for usage.
         *
         * @return void
         */
        public function connect() : void;

        /**
         * Check if the database connection is active.
         *
         * @return boolean
         */
        public function isConnected() : bool;

        /**
         * Get the last inserted ID.
         *
         * @return integer
         */
        public function lastInsertRowId() : int;

        /**
         * Prepare a query with the given parameters.
         * 
         * The $params array contains key-value pairs where the key is
         * the placeholder in the query and the value is the value that will
         * replace the placeholder.
         *
         * @param string $query
         * @param array $params
         * @return string
         */
        public function prepare(string $query, array $args) : string;

        /**
         * Prepare a query and execute it.
         * 
         * For info on the parameters see DBAdapter->prepare
         *
         * @param string $query
         * @param array $params
         * @return boolean
         */
        public function execPrepared(string $query, array $args) : bool;

        /**
         * Execute an SQL query/statement.
         *
         * @param string $query
         * @return boolean
         */
        public function exec(string $query) : bool;

        /**
         * Prepare a query and execute it, return the results.
         * 
         * For info on the parameters see DBAdapter->prepare
         *
         * @param string $query
         * @param array $params
         * @return RESULTAdapter
         */
        public function queryPrepared(string $query, array $args) : ?RESULTAdapter;

        /**
         * Execute an SQL Query and return the results.
         *
         * @param string $query
         * @return RESULTAdapter
         */
        public function query(string $query) : ?RESULTAdapter;

        /**
         * Insert or Update a into a database.
         *
         * @param string $insert_statement
         * @param string $update_statement
         * @param string $params
         * @return boolean
         */
        public function upsert(string $insert_statement, string $update_statement, array $params) : bool;

        /**
         * Close the database connection.
         *
         * @return void
         */
        public function close() : void;

    }

    interface RESULTAdapter {

        /**
         * Get a result row with the column names as indexes.
         *
         * @return array
         */
        public function getRowA() : array | false; // Associatively

        /**
         * Get a result row with numbers as indexes.
         *
         * @return array
         */
        public function getRowI() : array | false; // By index

    }

}
