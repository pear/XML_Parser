<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Stig Bakken <ssb@fast.no>                                    |
// |         Tomas V.V.Cox <cox@idecnet.com>                              |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'PEAR.php';

/**
 * XML Parser class.  This is an XML parser based on PHP's "xml" extension,
 * based on the bundled expat library.
 *
 * @category XML
 * @package XML_Parser
 * @author  Stig Bakken <ssb@fast.no>
 * @author  Tomas V.V.Cox <cox@idecnet.com>
 * @todo    Tests that need to be made:
 *          - mixing character encodings
 *          - a test using all expat handlers
 *          - options (folding, output charset)
 *          - different parsing modes
 *
 * @notes   - It requires PHP 4.0.4pl1 or greater
 *          - From revision 1.17, the function names used by the 'func' mode
 *            are in the format "xmltag_$elem", for example: use "xmltag_name"
 *            to handle the <name></name> tags of your xml file.
 */
class XML_Parser extends PEAR
{
    // {{{ properties

    /**
     * @var  resource  XML parser handle
     */
    var $parser;

    /**
     * @var  resource  File handle if parsing from a file
     */
    var $fp;

    /**
     * @var  boolean  Whether to do case folding
     */
    var $folding = true;

    /**
     * @var  string  Mode of operation, one of "event" or "func"
     */
    var $mode;

    /**
     * Mapping from expat handler function to class method.
     *
     * @var  array
     */
    var $handler = array(
        'character_data_handler'            => 'cdataHandler',
        'default_handler'                   => 'defaultHandler',
        'processing_instruction_handler'    => 'piHandler',
        'unparsed_entity_decl_handler'      => 'unparsedHandler',
        'notation_decl_handler'             => 'notationHandler',
        'external_entity_ref_handler'       => 'entityrefHandler'
    );

    /**
     * @var string source encoding
     */
    var $srcenc;

    /**
     * @var string target encoding
     */
    var $tgtenc;

    /*
     * Use call_user_func when php >= 4.0.7
     * @var boolean
     * @see setMode()
     */
    var $use_call_user_func = true;

    /**
     * @var string XML data
     * @see parse()
     */
    var $data = '';

    // }}}
    // {{{ constructor

    /**
     * Creates an XML parser.
     *
     * @param string $srcenc source charset encoding, use NULL (default) to use
     *                       whatever the document specifies
     * @param string $mode   how this parser object should work, "event" for
     *                       startelement/endelement-type events, "func"
     *                       to have it call functions named after elements
     * @param string $tgenc  a valid target encoding
     *
     * @see xml_parser_create
     */
    function XML_Parser($srcenc = null, $mode = 'event', $tgtenc = null)
    {
        $this->PEAR('XML_Parser_Error');

        if ($srcenc === null) {
            $xp = @xml_parser_create();
        } else {
            $xp = @xml_parser_create($srcenc);
        }
        if (is_resource($xp)) {
            if ($tgtenc !== null) {
                if (!@xml_parser_set_option($xp, XML_OPTION_TARGET_ENCODING,
                                            $tgtenc)) {
                    return $this->raiseError('invalid target encoding');
                }
            }
            $this->parser = $xp;
            $this->setMode($mode);
            xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, $this->folding);
        }
        $this->srcenc = $srcenc;
        $this->tgtenc = $tgtenc;
    }
    // }}}

    // {{{ setMode()

    /**
     * Sets the mode and all handler.
     *
     * @param  string $mode
     * @see    $handler
     */
    function setMode($mode)
    {

        $this->mode = $mode;

        xml_set_object($this->parser, $this);

        switch ($mode) {

            case 'func':
                // use call_user_func() when php >= 4.0.7
                // or call_user_method() if not
                if (version_compare(phpversion(), '4.0.7', 'lt')) {
                    $this->use_call_user_func = false;
                } else {
                    $this->use_call_user_func = true;
                }

                xml_set_element_handler($this->parser, 'funcStartHandler', 'funcEndHandler');
                break;

            case 'event':
                xml_set_element_handler($this->parser, 'startHandler', 'endHandler');
                break;
        }

        foreach ($this->handler as $xml_func => $method)
            if (method_exists($this, $method)) {
                $xml_func = 'xml_set_' . $xml_func;
                $xml_func($this->parser, $method);
            }

    }

    // }}}
    // {{{ setInputFile()

    /**
     * Sets the input xml file to be parsed
     *
     * @param    string      Filename (full path)
     * @return   resource    fopen handle of the given file
     * @throws   XML_Parser_Error
     * @see      setInput(), parse()
     * @access   public
     */
    function setInputFile($file)
    {

        $fp = @fopen($file, 'rb');
        if (is_resource($fp)) {
            $this->fp = $fp;
            return $fp;
        }

        return $this->raiseError("Could not open input file '$file' $php_errormsg");
    }

    // }}}
    // {{{ setInputString()
    
    /**
     * XML_Parser::setInputString()
     * 
     * Sets the xml input from a string
     * 
     * @param string $data a string containing the XML document
     * @return null
     **/
    function setInputString($data)
    {
        $this->fp = $data;
        return null;
    }
    
    // }}}
    // {{{ setInput()

    /**
     * Sets the file handle to use with parse().
     *
     * @param    mixed  $fp  Can be either a resource returned from fopen(),
     *                       a URL, a local filename or a string.
     * @access   public
     * @see      parse(), setInputFile(), setInputString()
     */
    function setInput($fp)
    {
        if (is_resource($fp)) {
            $this->fp = $fp;
            return true;
        }
        // see if it's an absolute URL (has a scheme at the beginning)
        elseif (eregi('^[a-z]+://', substr($fp, 0, 10))) {
            return $this->setInputFile($fp);
        }
        // see if it's a local file
        elseif (file_exists($fp)) {
            return $this->setInputFile($fp);
        }
        // it must be a string
        else {
            $this->fp = $fp;
            return true;
        }

        return $this->raiseError('Illegal input format');
    }

    // }}}
    // {{{ parse()

    /**
     * Central parsing function.
     *
     * @throws   XML_Parser_Error
     * @return   true|Pear Error
     * @see      parseString()
     * @access   public
     */
    function parse()
    {
        // if $this->fp was fopened previously
        if (is_resource($this->fp)) {

            while ($data = fread($this->fp, 4096)) {
                if (!$this->_parseString($data, feof($this->fp))) {
                    return $this->raiseError();
                }
            }
        // otherwise, $this->fp must be a string
        } else {
            if (!$this->_parseString($this->fp, true)) {
                return $this->raiseError();
            }
        }
        $this->free();
        return true;
    }

    /**
     * XML_Parser::_parseString()
     * 
     * @param string $data
     * @param boolean $eof
     * @return bool
     * @access private
     * @see parseString()
     **/
    function _parseString($data, $eof = false)
    {
        return xml_parse($this->parser, $data, $eof);
    }
    
    // }}}
    // {{{ parseString()

    /**
     * XML_Parser::parseString()
     * 
     * Parses a string.
     *
     * @param    string  $data XML data
     * @param    boolean $eof  If set and TRUE, data is the last piece of data sent in this parser
     * @throws   XML_Parser_Error
     * @return   Pear Error|true   true on success or a PEAR Error
     * @see      _parseString()
     */
    function parseString($data, $eof = false)
    {
        if (!$this->_parseString($data, $eof)) {
            return $this->raiseError();
        }
        return true;
    }

    
    /**
     * XML_Parser::free()
     * 
     * Free the internal resources associated with the parser
     * 
     * @return null
     **/
    function free()
    {
        if (is_resource($this->parser)) {
            xml_parser_free($this->parser);
        }
        if (is_resource($this->fp)) {
            fclose($this->fp);
        }
        unset($this->fp);
        return null;
    }
    
    /**
     * XML_Parser::raiseError()
     * 
     * Trows a XML_Parser_Error and free's the internal resources
     * 
     * @param string  $msg   the error message
     * @param integer $ecode the error message code
     * @return XML_Parser_Error 
     **/
    function raiseError($msg = null, $ecode = 0)
    {
        $msg = !is_null($msg) ? $msg : $this->parser;
        $err = new XML_Parser_Error($msg, $ecode);
        $this->free();
        return parent::raiseError($err);
    }
    
    // }}}
    // {{{ funcStartHandler()

    function funcStartHandler($xp, $elem, $attribs)
    {
        $func = 'xmltag_' . $elem;
        if (method_exists($this, $func)) {
            if ($this->use_call_user_func) {
                call_user_func(array(&$this, $func), $xp, $elem, $attribs);
            } else {
                call_user_method($func, $this, $xp, $elem, $attribs);
            }
        }

    }

    // }}}
    // {{{ funcEndHandler()

    function funcEndHandler($xp, $elem)
    {
        $func = 'xmltag_' . $elem . '_';
        if (method_exists($this, $func)) {
            if ($this->use_call_user_func) {
                call_user_func(array(&$this, $func), $xp, $elem);
            } else {
                call_user_method($func, $this, $xp, $elem);
            }
        }
    }

    // }}}
    // {{{ startHandler()

    /**
     *
     * @abstract
     */
    function startHandler($xp, $elem, &$attribs)
    {
        return NULL;
    }

    // }}}
    // {{{ endHandler()

    /**
     *
     * @abstract
     */
    function endHandler($xp, $elem)
    {
        return NULL;
    }


    // }}}
}

class XML_Parser_Error extends PEAR_Error
{
    // {{{ properties

    var $error_message_prefix = 'XML_Parser: ';

    // }}}
    // {{{ constructor()

    function XML_Parser_Error($msgorparser = 'unknown error', $code = 0, $mode = PEAR_ERROR_RETURN, $level = E_USER_NOTICE)
    {
        if (is_resource($msgorparser)) {
            $code = xml_get_error_code($msgorparser);
            $msgorparser = sprintf("%s at XML input line %d",
                                   xml_error_string($code),
                                   xml_get_current_line_number($msgorparser));
        }
        $this->PEAR_Error($msgorparser, $code, $mode, $level);

    }

    // }}}
}
?>
