--TEST--
XML_Util tests for Bug #5392 "encoding of ISO-8859-1 is the only supported encoding"
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

echo "TEST:  test case provided in bug report" . PHP_EOL;
$data = 'This data contains special chars like'
    . ' <, >, & and " as well as ä, ö, ß, à and ê';

$util = XML_Util::replaceEntities($data) . PHP_EOL . PHP_EOL;

$utf8 = XML_Util::replaceEntities(utf8_encode($data)) . PHP_EOL . PHP_EOL;

echo $util;
echo $utf8;
if ($util == $utf8) {
    echo "THEY ARE THE SAME.";
}

?>
--EXPECT--
TEST:  test case provided in bug report
This data contains special chars like &lt;, &gt;, &amp; and &quot; as well as ä, ö, ß, à and ê
This data contains special chars like &lt;, &gt;, &amp; and &quot; as well as ä, ö, ß, à and ê
THEY ARE THE SAME.
