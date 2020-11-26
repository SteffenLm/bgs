<?php

$connection = mysqli_connect('localhost', 'root', '', 'lovecalculator');
$connection->set_charset("utf8");

class Match
{
    public string $n1;
    public string $n2;
}

$stmt = $connection->prepare("SELECT name_one AS n1, name_two AS n2 FROM matches");
$stmt->execute();
$res = $stmt->get_result();
$matches = array();
if ($res->num_rows > 0) {
    $rows = $res->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
        $match = new Match();
        $match->n1 = $row['n1'];
        $match->n2 = $row['n2'];
        $matches[] = $match;
    }
    echo (json_encode($matches));
} else {
    echo (json_encode($matches));
}
