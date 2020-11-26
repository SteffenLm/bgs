<?php
$connection = mysqli_connect('localhost', 'root', '');
$connection->set_charset("utf8");
$query = <<<SQL
DROP DATABASE IF EXISTS lovecalculator;
SQL;
$connection->query($query);

$query = <<<SQL
CREATE DATABASE lovecalculator;
SQL;
$connection->query($query);

$connection = mysqli_connect('localhost', 'root', '', 'lovecalculator');
$connection->set_charset("utf8");

$query = <<<SQL
CREATE TABLE IF NOT EXISTS matches (
    name_one VARCHAR(255) NOT NULL,
    name_two VARCHAR(255) NOT NULL,
    PRIMARY KEY (name_one, name_two)
)
SQL;
$connection->query($query);

echo ('Done.');
