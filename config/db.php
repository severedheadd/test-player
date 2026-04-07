<?php
echo json_encode([
    "host" => getenv('MYSQLHOST'),
    "db" => getenv('MYSQLDATABASE'),
    "user" => getenv('MYSQLUSER'),
    "port" => getenv('MYSQLPORT')
]);
exit;
?>
