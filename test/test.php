<?php

include __DIR__ . "/../xls2json.php";

echo "### map mode ###\n";
$ret = Xls2Json::process(__DIR__ . "/test.xls", 1);
echo json_encode($ret, JSON_PRETTY_PRINT);
echo "\n\n";

echo "### arr mode ###\n";
$ret = Xls2Json::process(__DIR__ . "/test.xls", 2);
echo json_encode($ret, JSON_PRETTY_PRINT);