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
$version = '0.6.0';

/**
 * current state
 */
$state = 'stable';

/**
 * release notes
 */
$notes = <<<EOT
- Fixed bug 1438 (namespaces not accepted for isValidName()) (thanks to davey)
- added optional parameter to replaceEntities() to define the set of entities to replace
- added optional parameter to attributesToString() to define, whether entities should be replaced (requested by Sebastian Bergmann)
- allowed second parameter to XML_Util::attributesToString() to be an array containing options (easier to use, if you only need to set the last parameter)
- introduced XML_Util::raiseError() to avoid the necessity of including PEAR.php, will only be included on error
EOT;

/**
 * package description
 */
$description = <<<EOT
Selection of methods that are often needed when working with XML documents. Functionality includes creating of attribute lists from arrays, creation of tags, validation of XML names and more.
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(array(
    'package'           => 'XML_Util',
    'summary'           => 'XML utility class.',
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

$package->addMaintainer('schst', 'lead', 'Stephan Schmidt', 'schst@php-tools.net');
$package->addMaintainer('davey', 'helper', 'Davey Shafik', 'davey@php.net');

$package->addDependency('PEAR', '', 'has', 'pkg', false);
$package->addDependency('php', '4.2.0', 'ge', 'php', false);
$package->addDependency('pcre', '', 'has', 'ext', false);

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