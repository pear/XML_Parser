--TEST--
XML_Util::createCDataSection() basic tests
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::createCDataSection("I am content.") . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage
<![CDATA[I am content.]]>
