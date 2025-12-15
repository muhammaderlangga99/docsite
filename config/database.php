<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'bridge' => [
            'driver' => env('BRIDGE_DB_CONNECTION', 'mysql'),
            'url' => env('BRIDGE_DB_URL'),
            'host' => env('BRIDGE_DB_HOST', '127.0.0.1'),
            'port' => env('BRIDGE_DB_PORT', '3306'),
            'database' => env('BRIDGE_DB_DATABASE', 'midware_bridge_api'),
            'username' => env('BRIDGE_DB_USERNAME', 'root'),
            'password' => env('BRIDGE_DB_PASSWORD', 'root'),
            'unix_socket' => env('BRIDGE_DB_SOCKET', ''),
            'charset' => env('BRIDGE_DB_CHARSET', 'utf8mb4'),
            'collation' => env('BRIDGE_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('BRIDGE_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'master' => [
            'driver' => env('MASTER_DB_CONNECTION', 'mysql'),
            'url' => env('MASTER_DB_URL'),
            'host' => env('MASTER_DB_HOST', '127.0.0.1'),
            'port' => env('MASTER_DB_PORT', '3306'),
            'database' => env('MASTER_DB_DATABASE', 'midware_master'),
            'username' => env('MASTER_DB_USERNAME', 'root'),
            'password' => env('MASTER_DB_PASSWORD', 'root'),
            'unix_socket' => env('MASTER_DB_SOCKET', ''),
            'charset' => env('MASTER_DB_CHARSET', 'utf8mb4'),
            'collation' => env('MASTER_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MASTER_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'cdcp' => [
            'driver' => env('CDCP_DB_CONNECTION', 'mysql'),
            'url' => env('CDCP_DB_URL'),
            'host' => env('CDCP_DB_HOST', '127.0.0.1'),
            'port' => env('CDCP_DB_PORT', '3306'),
            'database' => env('CDCP_DB_DATABASE', 'midware_cdcp'),
            'username' => env('CDCP_DB_USERNAME', 'root'),
            'password' => env('CDCP_DB_PASSWORD', 'root'),
            'unix_socket' => env('CDCP_DB_SOCKET', ''),
            'charset' => env('CDCP_DB_CHARSET', 'utf8mb4'),
            'collation' => env('CDCP_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('CDCP_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'kek' => [
            'driver' => env('KEK_DB_CONNECTION', 'mysql'),
            'url' => env('KEK_DB_URL'),
            'host' => env('KEK_DB_HOST', '127.0.0.1'),
            'port' => env('KEK_DB_PORT', '3306'),
            'database' => env('KEK_DB_DATABASE', 'midware_kek'),
            'username' => env('KEK_DB_USERNAME', 'root'),
            'password' => env('KEK_DB_PASSWORD', 'root'),
            'unix_socket' => env('KEK_DB_SOCKET', ''),
            'charset' => env('KEK_DB_CHARSET', 'utf8mb4'),
            'collation' => env('KEK_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('KEK_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'dek' => [
            'driver' => env('DEK_DB_CONNECTION', 'mysql'),
            'url' => env('DEK_DB_URL'),
            'host' => env('DEK_DB_HOST', '127.0.0.1'),
            'port' => env('DEK_DB_PORT', '3306'),
            'database' => env('DEK_DB_DATABASE', 'midware_dek'),
            'username' => env('DEK_DB_USERNAME', 'root'),
            'password' => env('DEK_DB_PASSWORD', 'root'),
            'unix_socket' => env('DEK_DB_SOCKET', ''),
            'charset' => env('DEK_DB_CHARSET', 'utf8mb4'),
            'collation' => env('DEK_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('DEK_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'qrps' => [
            'driver' => env('QRPS_DB_CONNECTION', 'mysql'),
            'url' => env('QRPS_DB_URL'),
            'host' => env('QRPS_DB_HOST', '127.0.0.1'),
            'port' => env('QRPS_DB_PORT', '3306'),
            'database' => env('QRPS_DB_DATABASE', 'midware_qrps'),
            'username' => env('QRPS_DB_USERNAME', 'root'),
            'password' => env('QRPS_DB_PASSWORD', 'root'),
            'unix_socket' => env('QRPS_DB_SOCKET', ''),
            'charset' => env('QRPS_DB_CHARSET', 'utf8mb4'),
            'collation' => env('QRPS_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('QRPS_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mini_atm' => [
            'driver' => env('MINI_ATM_DB_CONNECTION', 'mysql'),
            'url' => env('MINI_ATM_DB_URL'),
            'host' => env('MINI_ATM_DB_HOST', '127.0.0.1'),
            'port' => env('MINI_ATM_DB_PORT', '3306'),
            'database' => env('MINI_ATM_DB_DATABASE', 'midware_mini_atm'),
            'username' => env('MINI_ATM_DB_USERNAME', 'root'),
            'password' => env('MINI_ATM_DB_PASSWORD', 'root'),
            'unix_socket' => env('MINI_ATM_DB_SOCKET', ''),
            'charset' => env('MINI_ATM_DB_CHARSET', 'utf8mb4'),
            'collation' => env('MINI_ATM_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MINI_ATM_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'host_to_host' => [
            'driver' => env('H2H_DB_CONNECTION', 'mysql'),
            'url' => env('H2H_DB_URL'),
            'host' => env('H2H_DB_HOST', '127.0.0.1'),
            'port' => env('H2H_DB_PORT', '3306'),
            'database' => env('H2H_DB_DATABASE', 'midware_host_to_host'),
            'username' => env('H2H_DB_USERNAME', 'root'),
            'password' => env('H2H_DB_PASSWORD', 'root'),
            'unix_socket' => env('H2H_DB_SOCKET', ''),
            'charset' => env('H2H_DB_CHARSET', 'utf8mb4'),
            'collation' => env('H2H_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('H2H_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'bnpl' => [
            'driver' => env('BNPL_DB_CONNECTION', 'mysql'),
            'url' => env('BNPL_DB_URL'),
            'host' => env('BNPL_DB_HOST', '127.0.0.1'),
            'port' => env('BNPL_DB_PORT', '3306'),
            'database' => env('BNPL_DB_DATABASE', 'midware_bnpl'),
            'username' => env('BNPL_DB_USERNAME', 'root'),
            'password' => env('BNPL_DB_PASSWORD', 'root'),
            'unix_socket' => env('BNPL_DB_SOCKET', ''),
            'charset' => env('BNPL_DB_CHARSET', 'utf8mb4'),
            'collation' => env('BNPL_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('BNPL_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
