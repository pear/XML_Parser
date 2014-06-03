--TEST--
XML_Util tests for Bug #4950 "Incorrect CDATA serializing"
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.0a1 2008-05-04
--FILE--
<?php
// to run tests against an installation, run from anywhere but the parent directory:
//     pear run-tests XML_Util/tests/ -p xml_util
//
// to run tests on uninstalled sandbox, run from the parent directory exactly:
//     pear run-tests tests
//
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo '=====XML_Util tests for Bug #4950 "Incorrect CDATA serializing"=====' . PHP_EOL . PHP_EOL;

echo "TEST:  test case provided in bug report" . PHP_EOL;
echo XML_Util::createTag("test", array(), "Content ]]></test> here!",
    null, XML_UTIL_CDATA_SECTION) . PHP_EOL;

?>
--EXPECT--
=====XML_Util tests for Bug #4950 "Incorrect CDATA serializing"=====

TEST:  test case provided in bug report
<test><![CDATA[Content ]]]]><![CDATA[></test> here!]]></test>

