--TEST--
XML_Util::createCDataSection() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::createCDataSection("I am content.") . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage
<![CDATA[I am content.]]>
