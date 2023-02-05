<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$connectionString = 'mysql:host=' . getenv('MYSQL_HOSTNAME') . ';dbname=' . getenv('MYSQL_DATABASE');
$conn = new \PDO($connectionString, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function exec_query($query, ...$values)
{
    global $conn;
    try {
        $sth = $conn->prepare($query);
        $sth->execute($values);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        return $sth;
    } catch (PDOException $e) {
        die(json_encode('Error'));
    }
};

function select_all($query, ...$values) {
    $res = exec_query($query, ...$values);
    return $res->fetchAll();
}

function select_one($query, ...$values) {
    $res = exec_query($query, ...$values);
    return $res->fetch();
}

function generate_id() {
    return bin2hex(random_bytes(16));
}

?>