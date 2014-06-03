--TEST--
XML_Util::raiseError() basic tests
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

echo '=====XML_Util::raiseError() basic tests=====' . PHP_EOL . PHP_EOL;

$error = XML_Util::raiseError("I am an error", 12345);
if (is_a($error, 'PEAR_Error')) {
    print "PEAR Error: " . $error->getMessage() . PHP_EOL;
}
?>
--EXPECT--
=====XML_Util::raiseError() basic tests=====

PEAR Error: I am an error
