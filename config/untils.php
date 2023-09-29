<?php
define("DB_HOST", 'localhost');
define("DB_DATABASE", 'DBS');
define("DB_USERNAME", 'lab_dbs');
define("DB_PASSWORD", '987654321');

function onSes()
{
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_create_id();
    session_start();
}

function connect()
{
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if ($conn->connect_error) {
        return false;
    }
    return $conn;
}

function sqlSelect($conn, $query, $format = false, ...$vars)
{
    $stmt = $conn->prepare($query);
    if ($format) {
        $stmt->bind_param($format, ...$vars);
    }
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
    $stmt->close();
    return false;
}

function sqlInsert($conn, $query, $format = false, ...$vars)
{
    $stmt = $conn->prepare($query);
    if ($format) {
        $stmt->bind_param($format, ...$vars);
    }
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
    $stmt->close();
    return -1;
}

function sqlUpdate($C, $query, $format = false, ...$vars)
{
    $stmt = $C->prepare($query);
    if ($format) {
        $stmt->bind_param($format, ...$vars);
    }
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    }
    $stmt->close();
    return false;
}

function isValidNumber($number)
{
    if (!is_numeric($number)) {
        return false;
    }

    $num = intval($number);
    if (is_int($num)) {
        if ($num >= 0 && $num <= PHP_INT_MAX) {
            return $num;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
