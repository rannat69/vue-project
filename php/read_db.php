<?php

// Connect to the SQLite database
$db = new SQLite3('life_expectancy.db');

// Fetch data from DB
$results = $db->query('select * from life_expectancy
 ');

$data = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

$db->close();

header('Content-Type: application/json');

echo json_encode($data);

?>