<?php

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$desc =
   "Selection of methods that are often needed when working with XML documents.  "
    . "Functionality includes creating of attribute lists from arrays, "
    . "creation of tags, validation of XML names and more."
;

$version = '1.2.0RC1';
$apiver  = '1.2.0';
$state   = 'beta';

$notes = <<<EOT
Changed license to New BSD License (Req #13826 [ashnazg])
Added a test suite against all API methods [ashnazg]
Switch to package.xml v2 [ashnazg]
Added Req #13839: Missing XHTML empty tags to collapse [ashnazg|drry]
Fixed Bug #5392: encoding of ISO-8859-1 is the only supported encoding [ashnazg]
Fixed Bug #4950: Incorrect CDATA serializing [ashnazg|drry]
-- (this fix differs from the one in v1.2.0a1)
EOT;

$package = PEAR_PackageFileManager2::importOptions(
    'package.xml',
    array(
    'filelistgenerator' => 'cvs',
    'changelogoldtonew' => false,
    'simpleoutput'	=> true,
    'baseinstalldir'    => 'XML',
    'packagefile'       => 'package.xml',
    'packagedirectory'  => '.'));

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->clearDeps();

$package->setPackage('XML_Util');
$package->setPackageType('php');
$package->setSummary('XML utility class');
$package->setDescription($desc);
$package->setChannel('pear.php.net');
$package->setLicense('BSD License', 'http://opensource.org/licenses/bsd-license');
$package->setAPIVersion($apiver);
$package->setAPIStability($state);
$package->setReleaseVersion($version);
$package->setReleaseStability($state);
$package->setNotes($notes);
$package->setPhpDep('4.3.0');
$package->setPearinstallerDep('1.4.3');
$package->addExtensionDep('required', 'pcre');
$package->addIgnore(array('package.php', 'package.xml'));
$package->addReplacement('Util.php', 'package-info', '@version@', 'version');
$package->generateContents();

if ($_SERVER['argv'][1] == 'make') {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
