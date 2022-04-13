<?php
    $SERVER_NAME = "127.0.0.1";
    $DB_NAME = "phonebook";
    DEFINE('DB_USER','root');
    DEFINE('DB_PASSWORD', '');

    $dsn = "mysql:host=$SERVER_NAME;dbname=$DB_NAME";

    try {
        $db = new PDO($dsn, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        $err_msg = $e->getMessage();
        include("db_error.php");
        exit();
    }

?>