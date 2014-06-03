--TEST--
XML_Util::splitQualifiedName() basic tests
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

echo '=====XML_Util::splitQualifiedName() basic tests=====' . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage without namespace" . PHP_EOL;
$return = XML_Util::splitQualifiedName("xslt:stylesheet");
echo "namespace => " . $return['namespace'] . PHP_EOL;
echo "localPart => " . $return['localPart'] . PHP_EOL;
echo PHP_EOL;

echo "TEST:  basic usage with namespace" . PHP_EOL;
$return = XML_Util::splitQualifiedName("stylesheet", "myNs");
echo "namespace => " . $return['namespace'] . PHP_EOL;
echo "localPart => " . $return['localPart'] . PHP_EOL;
echo PHP_EOL;
?>
--EXPECT--
=====XML_Util::splitQualifiedName() basic tests=====

TEST:  basic usage without namespace
namespace => xslt
localPart => stylesheet

TEST:  basic usage with namespace
namespace => myNs
localPart => stylesheet
