--TEST--
XML_Util::getDocTypeDeclaration() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  using root only" . PHP_EOL;
echo XML_Util::getDocTypeDeclaration("rootTag") . PHP_EOL . PHP_EOL;

echo "TEST:  using root and URI" . PHP_EOL;
echo XML_Util::getDocTypeDeclaration("rootTag", "myDocType.dtd") . PHP_EOL . PHP_EOL;
?>
--EXPECT--
TEST:  using root only
<!DOCTYPE rootTag>

TEST:  using root and URI
<!DOCTYPE rootTag SYSTEM "myDocType.dtd">
