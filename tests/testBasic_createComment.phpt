--TEST--
XML_Util::createComment() basic tests
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::createComment("I am comment.") . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage
<!-- I am comment. -->
