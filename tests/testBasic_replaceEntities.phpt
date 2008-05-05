--TEST--
XML_Util::replaceEntities() basic tests
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';
echo '=====XML_Util::replaceEntities() basic tests=====' . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage" . PHP_EOL;
echo XML_Util::replaceEntities("This string contains < & >.") . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_XML" . PHP_EOL;
echo XML_Util::replaceEntities("This string contains < & >.", XML_UTIL_ENTITIES_XML) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_XML_REQUIRED" . PHP_EOL;
echo XML_Util::replaceEntities("This string contains < & >.", XML_UTIL_ENTITIES_XML_REQUIRED) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with ENTITIES_HTML" . PHP_EOL;
echo XML_Util::replaceEntities("This string contains < & >.", XML_UTIL_ENTITIES_HTML) . PHP_EOL . PHP_EOL;
?>
--EXPECT--
=====XML_Util::replaceEntities() basic tests=====

TEST:  basic usage
This string contains &lt; &amp; &gt;.

TEST:  basic usage with ENTITIES_XML
This string contains &lt; &amp; &gt;.

TEST:  basic usage with ENTITIES_XML_REQUIRED
This string contains &lt; &amp; >.

TEST:  basic usage with ENTITIES_HTML
This string contains &lt; &amp; &gt;.

