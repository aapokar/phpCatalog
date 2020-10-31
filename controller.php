<?php

function handleRequest() {
    $filters['TYPE'] = $_GET['type'] ?? null;
    $filters['LIMIT'] = $_GET['limit'] ?? 25;
    $filters['COUNTRY'] = $_GET['country'] ?? null;
    $filters['PAGENO'] = $_GET['pageno'] ?? 0;
    return $filters;
}
