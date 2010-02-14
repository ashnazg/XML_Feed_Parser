<?php
require_once 'PEAR/Config.php';
require_once 'XML/Feed/Parser.php';
require_once 'PHPUnit/Framework/TestCase.php';

abstract class XML_Feed_Parser_TestCase extends PHPUnit_Framework_TestCase {

    protected $backupGlobals = FALSE;

    static function getSampleDir() {
        $config = new PEAR_Config;
        return dirname(__FILE__) . '/../samples';
        // return $config->get('data_dir') . '/XML_Feed_Parser/samples';
    }
}

abstract class XML_Feed_Parser_Converted_TestCase extends XML_Feed_Parser_TestCase {

    function setup() {
        $this->fp_test_dir = XML_Feed_Parser_TestCase::getSampleDir() . 
            DIRECTORY_SEPARATOR . 'feedparsertests';
        if (! is_dir($this->fp_test_dir)) {
            $this->markTestSkipped('Feed parser tests (http://code.google.com/p/feedparser/downloads/list) must be unpacked into the folder ' . 
                $this->fp_test_dir);
        }
    }
}
?>
