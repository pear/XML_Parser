<?PHP
    require_once 'XML/Util.php';

    /**
    * creating a start element
    */
    print "creating a start element:<br>";
    print htmlentities(XML_Util::createStartElement("myNs:myTag", array("foo" => "bar"), "http://www.w3c.org/myNs#"));
    print "\n<br><br>\n";


    /**
    * creating a start element
    */
    print "creating a start element:<br>";
    print htmlentities(XML_Util::createStartElement("myTag", array(), "http://www.w3c.org/myNs#"));
    print "\n<br><br>\n";


    /**
    * creating an end element
    */
    print "creating an end element:<br>";
    print htmlentities(XML_Util::createEndElement("myNs:myTag"));
    print "\n<br><br>\n";

    /**
    * creating a CData section
    */
    print "creating a CData section:<br>";
    print htmlentities(XML_Util::createCDataSection("I am content."));
    print "\n<br><br>\n";

?>