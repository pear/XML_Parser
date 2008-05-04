--TEST--
XML_Util::createTagFromArray() basic tests
--FILE--
<?php
require_once 'XML' . DIRECTORY_SEPARATOR . 'Util.php';

$bad = array(
    "foo" => "bar",
);
$tag1 = array(
    "qname"        => "foo:bar",
);
$tag2 = array(
    "qname"        => "foo:bar",
    "namespaceUri" => "http://foo.com",
);
$tag3 = array(
    "qname"        => "foo:bar",
    "namespaceUri" => "http://foo.com",
    "attributes"   => array( "key" => "value", "argh" => "fruit&vegetable" ),
);
$tag4 = array(
    "qname"        => "foo:bar",
    "namespaceUri" => "http://foo.com",
    "attributes"   => array( "key" => "value", "argh" => "fruit&vegetable" ),
    "content"      => "I'm inside the tag",
);
$tag5 = array(
    "qname"        => "foo:bar",
    "attributes"   => array( "key" => "value", "argh" => "fruit&vegetable" ),
    "content"      => "I'm inside the tag",
);
$tag6 = array(
    "qname"        => "foo:bar",
    "namespaceUri" => "http://foo.com",
    "content"      => "I'm inside the tag",
);
$tag7 = array(
    "namespaceUri" => "http://foo.com",
    "attributes"   => array( "key" => "value", "argh" => "fruit&vegetable" ),
    "content"      => "I'm inside the tag",
);

echo "TEST:  basic usage with an invalid array" . PHP_EOL;
echo XML_Util::createTagFromArray($bad) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname only)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag1) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname and namespaceUri)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag2) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, and attributes)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag3) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, attributes, and content)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag5) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, and content)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag6) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (namespaceUri, attributes, and content)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag7) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), plus REPLACE_ENTITIES" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), plus ENTITIES_NONE" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_ENTITIES_NONE) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, and multiline = false" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, false) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, and multiline = true" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, true) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, and indent = (2 spaces)" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, true, '  ') . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), and linebreak = '^'" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, true, '  ', '^') . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), linebreak = '^', and sortAttributes = true" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, true, '  ', '^', true) . PHP_EOL . PHP_EOL;

echo "TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), linebreak = '^', and sortAttributes = false" . PHP_EOL;
echo XML_Util::createTagFromArray($tag4, XML_UTIL_REPLACE_ENTITIES, true, '  ', '^', false) . PHP_EOL . PHP_EOL;
?>
--EXPECT--
TEST:  basic usage with an invalid array
You must either supply a qualified name (qname) or local tag name (localPart).

TEST:  basic usage with a valid array (qname only)
<foo:bar />

TEST:  basic usage with a valid array (qname and namespaceUri)
<foo:bar xmlns:foo="http://foo.com" />

TEST:  basic usage with a valid array (qname, namespaceUri, and attributes)
<foo:bar argh="fruit&amp;vegetable" key="value" xmlns:foo="http://foo.com" />

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content)
<foo:bar argh="fruit&amp;vegetable" key="value" xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, attributes, and content)
<foo:bar argh="fruit&amp;vegetable" key="value">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, and content)
<foo:bar xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (namespaceUri, attributes, and content)
You must either supply a qualified name (qname) or local tag name (localPart).

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), plus REPLACE_ENTITIES
<foo:bar argh="fruit&amp;vegetable" key="value" xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), plus ENTITIES_NONE
<foo:bar argh="fruit&vegetable" key="value" xmlns:foo="http://foo.com">I'm inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, and multiline = false
<foo:bar argh="fruit&amp;vegetable" key="value" xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, and multiline = true
<foo:bar argh="fruit&amp;vegetable"
         key="value"
         xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, and indent = (2 spaces)
<foo:bar argh="fruit&amp;vegetable"
  key="value"
  xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), and linebreak = '^'
<foo:bar argh="fruit&amp;vegetable"^  key="value"^  xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), linebreak = '^', and sortAttributes = true
<foo:bar argh="fruit&amp;vegetable"^  key="value"^  xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>

TEST:  basic usage with a valid array (qname, namespaceUri, attributes, and content), REPLACE_ENTITIES, multiline = true, indent = (2 spaces), linebreak = '^', and sortAttributes = false
<foo:bar key="value"^  argh="fruit&amp;vegetable"^  xmlns:foo="http://foo.com">I&apos;m inside the tag</foo:bar>
