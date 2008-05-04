--TEST--
XML_Util::createEndElement() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage (myTag)" . PHP_EOL;
echo XML_Util::createEndElement("myTag") . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a namespaced tag (myNs:myTag)" . PHP_EOL;
echo XML_Util::createEndElement("myNs:myTag") . PHP_EOL . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage (myTag)
</myTag>

TEST:  basic usage with a namespaced tag (myNs:myTag)
</myNs:myTag>
