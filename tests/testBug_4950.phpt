--TEST--
XML_Util tests for Bug #4950 "Incorrect CDATA serializing"
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  test case provided in bug report" . PHP_EOL;
echo XML_Util::createTag("test", array(), "Content ]]></test> here!",
    null, XML_UTIL_CDATA_SECTION);

?>
--EXPECT--
TEST:  test case provided in bug report
<test><![CDATA[Content ]]]]><![CDATA[></test> here!]]></test>
