--TEST--
XML_Util::createComment() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::createComment("I am comment.") . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage
<!-- I am comment. -->
