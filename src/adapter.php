<?php

namespace DATABASE_ADAPTER {


    interface DBAdapter {

        /**
         * Open a connection to the database. Prepare the database for usage.
         *
         * @return void
         */
        public function connect();

        /**
         * Check if the database connection is active.
         *
         * @return boolean
         */
        public function isConnected();

        /**
         * Get the last inserted ID.
         *
         * @return integer
         */
        public function lastInsertRowId();

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
        public function prepare($query, $args);

        /**
         * Prepare a query and execute it.
         * 
         * For info on the parameters see DBAdapter->prepare
         *
         * @param string $query
         * @param array $params
         * @return boolean
         */
        public function execPrepared($query, $args);

        /**
         * Execute an SQL query/statement.
         *
         * @param string $query
         * @return boolean
         */
        public function exec($query);

        /**
         * Prepare a query and execute it, return the results.
         * 
         * For info on the parameters see DBAdapter->prepare
         *
         * @param string $query
         * @param array $params
         * @return RESULTAdapter
         */
        public function queryPrepared($query, $args);

        /**
         * Execute an SQL Query and return the results.
         *
         * @param string $query
         * @return RESULTAdapter
         */
        public function query($query);

        /**
         * Insert or Update a into a database.
         *
         * @param string $insert_statement
         * @param string $update_statement
         * @param string $params
         * @return boolean
         */
        public function upsert($insert_statement, $update_statement, $params);

        /**
         * Close the database connection.
         *
         * @return void
         */
        public function close();

    }

    interface RESULTAdapter {

        /**
         * Get a result row with the column names as indexes.
         *
         * @return array
         */
        public function getRowA(); // Associatively

        /**
         * Get a result row with numbers as indexes.
         *
         * @return array
         */
        public function getRowI(); // By index

    }

}
