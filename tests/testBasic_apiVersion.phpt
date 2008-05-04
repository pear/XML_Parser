--TEST--
XML_Util::apiVersion() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic apiVersion() call" . PHP_EOL;
echo XML_Util::apiVersion() . PHP_EOL;
?>
--EXPECT--
TEST:  basic apiVersion() call
1.1
