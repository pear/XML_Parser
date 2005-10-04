<?php
/**
 * script to automate the generation of the
 * package.xml file.
 *
 * $Id$
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @package     XML_Parser
 * @subpackage  Tools
 */

/**
 * uses PackageFileManager
 */ 
require_once 'PEAR/PackageFileManager.php';

/**
 * current version
 */
$version = '1.2.8';

/**
 * current state
 */
$state = 'stable';

/**
 * release notes
 */
$notes = <<<EOT
- fixed bug #5557: Raise a more useful error message when using invalid source encoding
EOT;

/**
 * package description
 */
$description = <<<EOT
This is an XML parser based on PHPs built-in xml extension.
It supports two basic modes of operation: "func" and "event".  In "func" mode, it will look for a function named after each element (xmltag_ELEMENT for start tags and xmltag_ELEMENT_ for end tags), and in "event" mode it uses a set of generic callbacks.

Since version 1.2.0 there's a new XML_Parser_Simple class that makes parsing of most XML documents easier, by automatically providing a stack for the elements.
Furthermore its now possible to split the parser from the handler object, so you do not have to extend XML_Parser anymore in order to parse a document with it.
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(array(
    'package'           => 'XML_Parser',
    'summary'           => 'XML parsing class based on PHP\'s bundled expat',
    'description'       => $description,
    'version'           => $version,
    'state'             => $state,
    'license'           => 'PHP License',
    'filelistgenerator' => 'cvs',
    'ignore'            => array('package.php', 'package.xml', 'package2.xml'),
    'notes'             => $notes,
    'simpleoutput'      => true,
    'baseinstalldir'    => 'XML',
    'packagedirectory'  => './',
    'dir_roles'         => array('docs' => 'doc',
                                 'examples' => 'doc',
                                 'tests' => 'test',
                                 )
    ));

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->addMaintainer('schst', 'lead', 'Stephan Schmidt', 'schst@php-tools.net');
$package->addMaintainer('ssb', 'developer', 'Stig S&#230;ther Bakken', 'stig@php.net');
$package->addMaintainer('cox', 'developer', 'Tomas V.V.Cox', 'cox@php.net');

$package->addDependency('PEAR', '', 'has', 'pkg', false);
$package->addDependency('php', '4.2.0', 'ge', 'php', false);

if (isset($_GET['make']) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
?>