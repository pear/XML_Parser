--TEST--
XML_Util tests for Bug #18343 Entities in file names decoded during packaging
--CREDITS--
Chuck Burgess <ashnazg@php.net>
# created for v1.2.2a1 2014-06-03
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';
echo '=====XML_Util tests for Bug #18343 "Entities in file names decoded during packaging"=====' . PHP_EOL . PHP_EOL;

echo "TEST:  test case provided in bug report" . PHP_EOL;
$array = array(
    "qname"      => "install",
    "attributes" => array(
        "as"    => "Horde/Feed/fixtures/lexicon/http-p.moreover.com-cgi-local-page%2Fo=rss&s=Newsweek",
        "name"  => "test/Horde/Feed/fixtures/lexicon/http-p.moreover.com-cgi-local-page%2Fo=rss&s=Newsweek",
    )
);
echo XML_Util::createTagFromArray($array) . PHP_EOL;
?>
--EXPECT--
=====XML_Util tests for Bug #18343 "Entities in file names decoded during packaging"=====

TEST:  test case provided in bug report
<install as="Horde/Feed/fixtures/lexicon/http-p.moreover.com-cgi-local-page%2Fo=rss&amp;s=Newsweek" name="test/Horde/Feed/fixtures/lexicon/http-p.moreover.com-cgi-local-page%2Fo=rss&amp;s=Newsweek" />
