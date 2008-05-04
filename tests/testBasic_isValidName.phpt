--TEST--
XML_Util::isValidName() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  valid tag" . PHP_EOL;
$result = XML_Util::isValidName("alpha-x_y_z.123");
if (is_a($result, 'PEAR_Error')) {
    print "Invalid XML name: " . $result->getMessage() . PHP_EOL . PHP_EOL;
} else {
    print "Valid XML name." . PHP_EOL . PHP_EOL;
}

echo "TEST:  invalid tag" . PHP_EOL;
$result = XML_Util::isValidName("invalidTag?");
if (is_a($result, 'PEAR_Error')) {
    print "Invalid XML name: " . $result->getMessage() . PHP_EOL . PHP_EOL;
} else {
    print "Valid XML name." . PHP_EOL . PHP_EOL;
}
?>
--EXPECT--
TEST:  valid tag
Valid XML name.

TEST:  invalid tag
Invalid XML name: XML names may only contain alphanumeric chars, period, hyphen, colon and underscores
