<?php

require_once 'Ilib/Services/CPSMS.php';

class Ilib_Services_FakeCPSMS extends Ilib_Services_CPSMS
{
    
    private $tmpdir;

    public function __construct($username, $password, $sendername, $tmp_directory)
    {
        parent::__construct($username, $password, $sendername);
        $this->tmpdir = $tmp_directory;
    }
    
    public function send()
    {
        if(empty($this->message)) {
            $this->setErrorMessage('The message is empty.');
            return false;
        }
        
        if(!is_array($this->recipient) || empty($this->recipient)) {
            $this->setErrorMessage('No recipients is given.');
            return false;
        }
        
        $send = "&message=" . $this->message;
        
        if(count($this->recipient) > 1 ) {
            foreach($this->recipient AS $recipient) {
                $send .= "&recipient[]=" . $recipient; // Recipient
            }
        }
        else {
            $send .= "&recipient=" . $this->recipient[0]; // Recipient
        }
        
        // The url is opened
        if(file_put_contents($this->tmpdir.DIRECTORY_SEPARATOR.'Ilib_Services_FakeCPSMS_SMSLog.txt', $this->url.$send.PHP_EOL, FILE_APPEND)) {
            return true;
        }
        else {
            return false;
        }
    }
}
?>