<?PHP
/**
 * example for XML_Parser_Simple
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @package     XML_Parser
 * @subpackage  Examples
 */

/**
 * require the parser
 */
require_once '../Parser/Simple.php';

class myParser extends XML_Parser_Simple
{
    function myParser()
    {
        $this->XML_Parser_Simple();
    }

   /**
    * handle the element
    *
    */
    function handleElement($name, $attribs, $data)
    {
        printf('handle %s<br>', $name);
    }
}

$p = &new myParser();

$result = $p->setInputFile('xml_parser_simple1.xml');
$result = $p->parse();
?>