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
$version = '1.2.0';

/**
 * current state
 */
$state = 'beta';

/**
 * release notes
 */
$notes = <<<EOT
- added new class XML_Parser_Simple that provides a stack for the elements so the user only needs to implement one method to handle the tag and cdata.
EOT;

/**
 * package description
 */
$description = <<<EOT
This is an XML parser based on PHPs built-in xml extension.
It supports two basic modes of operation: "func" and "event".  In "func" mode, it will look for a function named after each element (xmltag_ELEMENT for start tags and xmltag_ELEMENT_ for end tags), and in "event" mode it uses a set of generic callbacks.
Furthemore this package contains some specialized parsers that help you solve common XML parsing tasks.
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
    'ignore'            => array('package.php', 'package.xml'),
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

$package->addMaintainer('ssb', 'developer', 'Stig Sæther Bakken', 'stig@php.net');
$package->addMaintainer('schst', 'lead', 'Stephan Schmidt', 'schst@php-tools.net');
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