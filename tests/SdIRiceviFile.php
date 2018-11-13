<?php
declare(strict_types=1);

require_once("MyTest.php");

require_once(__DIR__ . "/../core/config.php");
require_once(__DIR__ . "/../soap/SdIRiceviFile/autoload.php");

final class SdIRiceviFile extends Mytest
{

    protected $service;

    // initialize tests
    protected function setUp()
    {
        MyTest::setUp();
        $this->service = new \SdIRiceviFile_service(array('trace' => 1));
        $this->service->__setLocation(HOSTMAIN . 'sdi/soap/SdIRiceviFile/');
    }
    
    public function testRiceviFile()
    {
        $invoice = '<xml></xml>';
        $invoice = base64_encode($invoice);
        $fileSdIBase = new \fileSdIBase_Type(
            'aaa.xml',
            $invoice
        );
        $response = $this->service->RiceviFile($fileSdIBase);
        $this->assertEquals("", $response->getErrore());
    }

    public function tearDown()
    {
        MyTest::tearDown();

        $this->service = null;
    }
}
