<?php
$user = [
    [
        'name' => 'matt',
    ]
];

$query_string = getenv('QUERY_STRING');

if (empty($query_string)) {
    echo "query string is empty\n";
} else {
    $queryArr = explode('=', $query_string);
    $id = $queryArr[1] - 1;
    echo "request success: {$user[$id]['name']}";
}