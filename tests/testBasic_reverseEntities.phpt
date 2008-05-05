--TEST--
XML_Util::reverseEntities() basic tests
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::reverseEntities("This string contains &lt; &amp; &gt;.") . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_XML" . PHP_EOL;
echo XML_Util::reverseEntities("This string contains &lt; &amp; &gt;.", XML_UTIL_ENTITIES_XML) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_XML_REQUIRED" . PHP_EOL;
echo XML_Util::reverseEntities("This string contains &lt; &amp; &gt;.", XML_UTIL_ENTITIES_XML_REQUIRED) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_HTML" . PHP_EOL;
echo XML_Util::reverseEntities("This string contains &lt; &amp; &gt;.", XML_UTIL_ENTITIES_HTML) . PHP_EOL . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage
This string contains < & >.

TEST:  basic usage with ENTITIES_XML
This string contains < & >.

TEST:  basic usage with ENTITIES_XML_REQUIRED
This string contains < & &gt;.

TEST:  basic usage with ENTITIES_HTML
This string contains < & >.
