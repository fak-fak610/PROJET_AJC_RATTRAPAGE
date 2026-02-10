<?php
include 'moocs_data.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total = count($moocs);
$moocs_paginated = array_slice($moocs, $offset, $limit);

header('Content-Type: application/json');
echo json_encode([
    "total" => $total,
    "page" => $page,
    "limit" => $limit,
    "moocs" => $moocs_paginated
]);
?>
