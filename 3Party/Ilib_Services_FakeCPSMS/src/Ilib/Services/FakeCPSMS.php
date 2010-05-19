<?php
/**
 * Class for easy testing of CPSMS gateway.
 *
 * PHP Version 5
 *
 * @category Services
 * @package Ilib_Services_FakeCPSMS
 * @author   Sune Jensen <sj@sunet.dk>
 * @author   Lars Olesen <lars@legestue.net>
 *
 */

require_once 'Ilib/Services/CPSMS.php';

/**
 * Class for easy testing of CPSMS gateway.
 *
 * Extends Ilib_Services_CPSMS
 *
 * Instead of sending sms the it is written to
 * a log file
 *
 *
 * <code>
 * $sms = new Ilib_Services_FakeCPSMS('username', 'password', 'sendername', '/path/to/tempdir/');
 * $sms->setMessage('Test sms');
 * $sms->addRecipient('12345678');
 * $sms->addRecipient('87654321');
 * $sms->send();
 * </code>
 *
 * @category Services
 * @package  Ilib_Services_FakeCPSMS
 * @author   Sune Jensen <sj@sunet.dk>
 * @author   Lars Olesen <lars@legestue.net>
 *
 */
class Ilib_Services_FakeCPSMS extends Ilib_Services_CPSMS
{

    private $tmpdir;

    /**
     * Constructor
     *
     * @param string username
     * @param string password
     * @param string sender name
     * @param string path tmp directory to save sms log
     */
    public function __construct($username, $password, $sendername, $tmp_directory)
    {
        parent::__construct($username, $password, $sendername);
        $this->tmpdir = $tmp_directory;
    }

    /**
     * Writes sms to log file
     *
     * @return boolean true on success
     */
    public function send()
    {
        if (empty($this->message)) {
            $this->setErrorMessage('The message is empty.');
            return false;
        }

        if (!is_array($this->recipient) || empty($this->recipient)) {
            $this->setErrorMessage('No recipients is given.');
            return false;
        }

        $send = "&message=" . $this->message;

        if (count($this->recipient) > 1 ) {
            foreach ($this->recipient AS $recipient) {
                $send .= "&recipient[]=" . $recipient; // Recipient
            }
        } else {
            $send .= "&recipient=" . $this->recipient[0]; // Recipient
        }

        // The url is opened
        if (file_put_contents($this->tmpdir.DIRECTORY_SEPARATOR.'Ilib_Services_FakeCPSMS_SMSLog.txt', $this->url.$send.PHP_EOL, FILE_APPEND)) {
            return true;
        } else {
            return false;
        }
    }
}
