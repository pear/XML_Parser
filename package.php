<?php
/**
 * script to automate the generation of the
 * package.xml file.
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @package     XML_Parser
 * @subpackage  Tools
 */

/**
 * uses PackageFileManager
 */ 
require_once 'PEAR/PackageFileManager.php';

$version = '1.1.0beta1';

$notes = <<<EOT
- Fixed memory leaks parsing many documents or big files
- Fixed setInput() url detection regex
- Added setInputString() method, allowing strings to be passed as input
- Error handling rewritten
- Increased the overall parsing speed
- Added free() method
- Added reset() method, that is called when parsing a document so it is possible to parse more than one document per instance
- Added error codes
- revamped documentation

Thanks to Marshall Roch for commments and contributions and Tomas V.V. Cox
for applying a lot of fixes and improvements.
EOT;

$description = <<<EOT
This is an XML parser based on PHPs built-in xml extension.  It
supports two basic modes of operation: "func" and "event".  In "func"
mode, it will look for a function named after each element
(xmltag_ELEMENT for start tags and xmltag_ELEMENT_ for end tags), and
in "event" mode it uses a set of generic callbacks.
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(array(
    'package'           => 'XML_Parser',
    'summary'           => 'XML parsing class based on PHP\'s bundled expat',
    'description'       => $description,
    'version'           => $version,
    'state'             => 'beta',
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

$package->addMaintainer('ssb', 'lead', 'Stig Sæther Bakken', 'stig@php.net');
$package->addMaintainer('schst', 'lead', 'Stephan Schmidt', 'schst@php-tools.net');
$package->addMaintainer('cox', 'developer', 'Tomas V.V.Cox', 'cox@php.net');

$package->addDependency('PEAR', '', 'has', 'pkg', false);
$package->addDependency('php', '4.0.4pl1', 'ge', 'php', false);

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