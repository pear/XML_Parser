<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Stephan Schmidt <schst@php-tools.net>                       |
// +----------------------------------------------------------------------+
//
//    $Id$

    require_once 'PEAR.php';

/**
 * error code for invalid chars in XML name
 */
define("XML_UTIL_ERROR_INVALID_CHARS", 51);

/**
 * error code for invalid chars in XML name
 */
define("XML_UTIL_ERROR_INVALID_START", 52);

/**
 * error code for non-scalar tag content
 */
define("XML_UTIL_ERROR_NON_SCALAR_CONTENT", 60);
    
    
/**
 * utility class for working with XML documents
 *
 * @category XML
 * @package  XML_Util
 * @version  0.2
 * @author   Stephan Schmidt <schst@php.net>
 * @todo     method to get doctype declaration
 */
class XML_Util {

   /**
    * return API version
    *
    * @access   public
    * @static
    * @return   string  $version API version
    */
    function apiVersion()
    {
		return "0.2";
    }

   /**
    * replace XML entities
    *
    * chars that have to be replaced are '&' and '<',
    * furthermore '>', ''' and '"' have entities that can be used. 
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // replace XML entites:
    * $string = XML_Util::replaceEntities("This string contains < & >.");
    * </code>
    *
    * @access   public
    * @static
    * @param    string  $string string where XML special chars should be replaced
    * @return   string  $string string with replaced chars
    * @todo     optional parameter to supply additional entities
    */
    function replaceEntities($string)
    {
        return strtr($string,array(
                                  '&'  => '&amp;',
                                  '>'  => '&gt;',
                                  '<'  => '&lt;',
                                  '"'  => '&quot;',
                                  '\'' => '&apos;' ));
    }

   /**
    * build an xml declaration
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // get an XML declaration:
    * $xmlDecl = XML_Util::getXMLDeclaration("1.0", "UTF-8", true);
    * </code>
    *
    * @access   public
    * @static
    * @param    string  $version     xml version
    * @param    string  $encoding    character encoding
    * @param    boolean $standAlone  document is standalone (or not)
    * @return   string  $decl xml declaration
    * @uses     XML_Util::attributesToString() to serialize the attributes of the XML declaration
    */
    function getXMLDeclaration($version = "1.0", $encoding = null, $standalone = null)
    {
        $attributes = array(
                            "version" => $version,
                           );
        // add encoding
        if ($encoding !== null) {
            $attributes["encoding"] = $encoding;
        }
        // add standalone, if specified
        if ($standalone !== null) {
            $attributes["standalone"] = $standalone ? "yes" : "no";
        }
        
        return sprintf("<?xml%s?>", XML_Util::attributesToString($attributes, false));
    }


   /**
    * build a document type declaration
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // get a doctype declaration:
    * $xmlDecl = XML_Util::getDocTypeDeclaration("rootTag","myDocType.dtd");
    * </code>
    *
    * @access   public
    * @static
    * @param    string  $root         name of the root tag
    * @param    string  $uri          uri of the doctype definition (or array with uri and public id)
    * @param    string  $internalDtd  internal dtd entries   
    * @return   string  $decl         doctype declaration
    * @since    0.2
    */
    function getDocTypeDeclaration($root, $uri = null, $internalDtd = null)
    {
        if (is_array($uri)) {
            $ref = sprintf( ' PUBLIC "%s" "%s"', $uri["id"], $uri["uri"] );
        } elseif (!empty($uri)) {
            $ref = sprintf( ' SYSTEM "%s"', $uri );
        } else {
            $ref = "";
        }

        if (empty($internalDtd)) {
            return sprintf("<!DOCTYPE %s%s>", $root, $ref);
        } else {
            return sprintf("<!DOCTYPE %s%s [\n%s\n]>", $root, $ref, $internalDtd);
        }
    }

   /**
    * create string representation of an attribute list
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // build an attribute string
    * $att = array(
    *              "foo"   =>  "bar",
    *              "argh"  =>  "tomato"
    *            );
    *
    * $attList = XML_Util::attributesToString($att);    
    * </code>
    *
    * @access   public
    * @static
    * @param    array   $attributes  attribute array
    * @param    boolean $sort        sort attribute list alphabetically
    * @return   string  $string      string representation of the attributes
    * @uses     XML_Util::replaceEntities() to replace XML entities in attribute values
    */
    function attributesToString($attributes, $sort = true)
    {
        $string = "";
        if (is_array($attributes) && !empty($attributes)) {
            if ($sort) {
                ksort($attributes);
            }
            foreach ($attributes as $key => $value) {
                $string .= " ".$key.'="'.XML_Util::replaceEntities($value).'"';
            }
        }
        return $string;
    }

   /**
    * create a tag
    *
    * This method will call XML_Util::createTagFromArray(), which
    * is more flexible.
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // create an XML tag:
    * $tag = XML_Util::createTag("myNs:myTag", array("foo" => "bar"), "This is inside the tag", "http://www.w3c.org/myNs#");
    * </code>
    *
    * @access   public
    * @static
    * @param    string  $qname             qualified tagname (including namespace)
    * @param    array   $attributes        array containg attributes
    * @param    mixed   $content
    * @param    boolean $replaceEntities   whether to replace XML special chars in content or not
    * @return   string  $string            XML tag
    * @see      XML_Util::createTagFromArray()
    * @uses     XML_Util::createTagFromArray() to create the tag
    */
    function createTag( $qname, $attributes = array(), $content = null, $namespaceUri = null, $replaceEntities = true )
    {
        $tag = array(
                     "qname"      => $qname,
                     "attributes" => $attributes
                    );

        // add tag content
        if ($content !== null) {
            $tag["content"] = $content;
        }
        
        // add namespace Uri
        if ($namespaceUri !== null) {
            $tag["namespaceUri"] = $namespaceUri;
        }

        return XML_Util::createTagFromArray($tag, $replaceEntities);
    }

   /**
    * create a tag from an array
    * this method awaits an array in the following format
    * <pre>
    * array(
    *  "qname"        => $qname         // qualified name of the tag
    *  "namespace"    => $namespace     // namespace prefix (optional, if qname is specified or no namespace)
    *  "localpart"    => $localpart,    // local part of the tagname (optional, if qname is specified)
    *  "attributes"   => array(),       // array containing all attributes (optional)
    *  "content"      => $content,      // tag content (optional)
    *  "namespaceUri" => $namespaceUri  // namespaceUri for the given namespace (optional)
    *   )
    * </pre>
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * $tag = array(
    *           "qname"        => "foo:bar",
    *           "namespaceUri" => "http://foo.com",
    *           "attributes"   => array( "key" => "value", "argh" => "fruit&vegetable" ),
    *           "content"      => "I'm inside the tag"
    *            );
    * // creating a tag with qualified name and namespaceUri
    * $string = XML_Util::createTagFromArray($tag);
    * </code>
    *
    * @access   public
    * @static
    * @param    array   $tag               tag definition
    * @param    boolean $replaceEntities   whether to replace XML special chars in content or not
    * @return   string  $string            XML tag
    * @see      XML_Util::createTag()
    * @uses     XML_Util::attributesToString() to serialize the attributes of the tag
    * @uses     XML_Util::splitQualifiedName() to get local part and namespace of a qualified name
    */
    function createTagFromArray( $tag, $replaceEntities = true )
    {
        // if no attributes hav been set, use empty attributes
        if (!isset($tag["attributes"]) || !is_array($tag["attributes"])) {
            $tag["attributes"] = array();
        }
        
        // qualified name is not given
        if (!isset($tag["qname"])) {
            // check for namespace
            if (isset($tag["namespace"]) && !empty($tag["namespace"])) {
                $tag["qname"] = $tag["namespace"].":".$tag["localPart"];
            } else {
                $tag["qname"] = $tag["localPart"];
            }
        // namespace URI is set, but no namespace
        } elseif (isset($tag["namespaceUri"]) && !isset($tag["namespace"])) {
            $parts = XML_Util::splitQualifiedName($tag["qname"]);
            $tag["localPart"] = $parts["localPart"];
            if (isset($parts["namespace"])) {
                $tag["namespace"] = $parts["namespace"];
            }
        }

        if (isset($tag["namespaceUri"]) && !empty($tag["namespaceUri"])) {
            // is a namespace given
            if (isset($tag["namespace"]) && !empty($tag["namespace"])) {
                $tag["attributes"]["xmlns:".$tag["namespace"]] = $tag["namespaceUri"];
            } else {
                // define this Uri as the default namespace
                $tag["attributes"]["xmlns"] = $tag["namespaceUri"];
            }
        }

        // create attribute list
        $attList    =   XML_Util::attributesToString($tag["attributes"]);
        if (!isset($tag["content"]) || empty($tag["content"])) {
            $tag    =   sprintf("<%s%s/>", $tag["qname"], $attList);
        } elseif (is_scalar($tag["content"])) {
            if ($replaceEntities) {
                $tag["content"] = XML_Util::replaceEntities($tag["content"]);
            }
            $tag    =   sprintf("<%s%s>%s</%s>", $tag["qname"], $attList, $tag["content"], $tag["qname"] );
        } else {
            return PEAR::raiseError( "Supplied non-scalar value as tag content", XML_UTIL_ERROR_NON_SCALAR_CONTENT );
        }        
        return  $tag;
    }

   /**
    * split qualified name and return namespace and local part
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // split qualified tag
    * $parts = XML_Util::splitQualifiedName("xslt:stylesheet");
    * </code>
    * the returned array will contain two elements:
    * <pre>
    * array(
    *       "namespace" => "xslt",
    *       "localPart" => "stylesheet"
    *      );
    * </pre>
    *
    * @access public
    * @static
    * @param  string    $qname  qualified tag name
    * @return array     $parts  array containing namespace and local part
    */
    function splitQualifiedName($qname)
    {
        if (strstr($qname, ':')) {
            $tmp = explode(":", $qname);
            return array(
                          "namespace" => $tmp[0],
                          "localPart" => $tmp[1]
                        );
        }
        return array(
                      "namespace" => null,
                      "localPart" => $tmp[1]
                    );
    }

   /**
    * check, whether string is valid XML name
    *
    * <p>XML names are used for tagname, attribute names and various
    * other, lesser known entities.</p>
    * <p>An XML name may only consist of alphanumeric characters,
    * dashes, undescores and periods, and has to start with a letter
    * or an underscore.
    * </p>
    *
    * <code>
    * require_once 'XML/Util.php';
    * 
    * // verify tag name
    * $result = XML_Util::isValidName("invalidTag?");
    * if (XML_Util::isError($result)) {
    *    print "Invalid XML name: " . $result->getMessage();
    * }
    * </code>
    *
    * @access  public
    * @static
    * @param   string  $string string that should be checked
    * @return  mixed   $valid  true, if string is a valid XML name, PEAR error otherwise
    * @todo    support for other charsets
    */
    function isValidName($string)
    {
        // check for invalid chars
        if (!preg_match("/^[[:alnum:]_\-.]+$/", $string)) {
            return PEAR::raiseError( "XML name may only contain alphanumeric chars, period, hyphen and underscore", XML_UTIL_ERROR_INVALID_CHARS );
        }

        //  check for invalid starting character
        if (!preg_match("/[[:alpha:]_]/", $string{0})) {
            return PEAR::raiseError( "XML name may only start with letter or underscore", XML_UTIL_ERROR_INVALID_START );
        }

        // XML name is valid
        return true;
    }
}
?>