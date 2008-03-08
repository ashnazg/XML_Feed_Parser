<?php

require_once 'XML_Feed_Parser_TestCase.php';

/**
 * This is a set of tests for specific reported bugs.
 */
class Regressions extends XML_Feed_Parser_TestCase
{
    function setUp()
    {
        $this->sample_dir = XML_Feed_Parser_TestCase::getSampleDir();
    }
    
    /**
     * Issue 13215 reported some problems with HTML entity parsing not supporting
     * the correct content types
     *
     * @url http://pear.php.net/bugs/bug.php?id=13215
     */
    function test_entitiesSupportForIssue13215() 
    {
      $xml = file_get_contents($this->sample_dir . "/bug13215.xml");
      $feed = new XML_Feed_Parser($xml);
      $entry = $feed->getEntryById('http://www.thepost.ohiou.edu/Articles/News/2008/03/07/23319/');
      $this->assertRegexp('/&ldquo;We&rsquo;re ready to take it to the courts/', $entry->content);
    }
    
    /**
     * Some feeds may have more than one <enclosure> element defined to
     * associate multiple files with a single field (eg., for the same video in
     * multiple formats).  XML_Feed_Parser seems to only support a single
     * <enclosure> element.  If more than one element is included in the feed,
     * only the last one will be accessible through $item->enclosure.
     *
     * @todo Get sample of feed to use in this test
     * @url http://pear.php.net/bugs/bug.php?id=12844
     **/
    // function test_handlesMultipleEnclosures()
    // {
    //   $xml = file_get_contents($this->sample_dir . "/bug12844.xml");
    //   $feed = new XML_Feed_Parser($xml);
    // }
    
    
    /**
     *  German umlauts (ÄÖÜäöüß) from an atom xml file (encoding="iso-8859-1")
     * are displayed wrong after parsing, eg. http://www.keine-gentechnik.de/news-regionen.xml
     *
     * @url http://pear.php.net/bugs/bug.php?id=12916
     **/
    function test_handlesGermanUmlauts()
    {
      $xml = file_get_contents($this->sample_dir . "/bug12916.xml");
      $feed = new XML_Feed_Parser($xml);
      $entry = $feed->getEntryById('sample-feed:1');
      $this->assertEquals('ÄÜÖäüöß', $entry->title);
      $this->assertEquals('&Auml;&Uuml;&Ouml;&auml;&uuml;&ouml;&szlig;', $entry->content);
    }
    
    function test_handlesAmpersandsInUrls()
    {
      $xml = file_get_contents($this->sample_dir . "/bug12919.xml");
      $feed = new XML_Feed_Parser($xml);
      $entry = $feed->getEntryById('entry-id');
      $this->assertEquals('<a href="http://www.vzbv.de/start/index.php?page=presse&amp;bereichs_id=25">Linktext</a>',
        trim($entry->content));
    }
}
