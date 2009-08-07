--TEST--
XML Parser:  test for Bug #9328 "assigned by reference error in XML_RSS parse"
--SKIPIF--
<?php
/*
 * can't test if XML_RSS is not installed
 */
$originalErrorReporting = error_reporting();
error_reporting(E_ALL & ~E_WARNING);
if ('OK' != (include_once 'XML/RSS.php')) {
    print('skip if XML_RSS is not installed');
}
error_reporting($originalErrorReporting);
?>
--FILE--
<?php
/*
 * this issue only exists in PHP4
 */

require_once 'XML/RSS.php';

$url = 'www.someverybogusurl.com';
$rss =& new XML_RSS($url);

$error = $rss->parse();
echo $error->getMessage() . PHP_EOL;
?>
--EXPECT--
XML_Parser: Invalid document end at XML input line 1:1
