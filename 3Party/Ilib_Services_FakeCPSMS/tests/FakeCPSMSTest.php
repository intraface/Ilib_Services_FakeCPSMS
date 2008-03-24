<?php
require_once 'config.test.php';

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../src/Ilib/Services/FakeCPSMS.php';

class FakeCPSMSTest extends PHPUnit_Framework_TestCase
{
    private $sms;

    function setUp()
    {
        $this->sms = new Ilib_Services_FakeCPSMS(ILIB_SERVICES_CPSMS_TEST_USERNAME, ILIB_SERVICES_CPSMS_TEST_PASSWORD, 'CPSMS_TEST', ILIB_SERVICES_CPSMS_TEST_TMPDIR);
    }

    function tearDown()
    {
        unset($this->sms);
    }

    function testConstructor()
    {
        $this->assertTrue(is_object($this->sms));
    }

    function testSendReturnsTrue()
    {
        $this->sms->setMessage('Test');
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->assertTrue($this->sms->send(), $this->sms->getErrorMessage());
    }
    
    function testSendToMultipleRecipientsReturnsTrue() {
        $this->sms->setMessage('Test');
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->assertTrue($this->sms->send(), $this->sms->getErrorMessage());
    }
}
