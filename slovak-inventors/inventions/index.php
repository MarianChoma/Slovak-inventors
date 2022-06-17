<?php
require_once "../Invention.php";
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    header("HTTP/1.1 200 OK");
    $century = $_GET['century'];
    $year = $_GET['year'];
    if ($century) {
        echo json_encode(Invention::findByCentury($century));
    } else if ($year) {
        echo json_encode(Invention::findByYear($year));
    }
}



