<?php 

namespace Alpifra\SmsboxApi\Client;

use Alpifra\SmsboxApi\Base;

class Sms extends Base
{
    
    /**
     * Perform a send request to the SMSBox API
     *
     * @param  array $recipients
     * @param  string $message
     * @return bool
     */
    public function send(array $recipients, string $message, string $sender = null, string $mode = 'Standard'):bool
    {
        $this->setMessage($message);
        $this->setRecipients($recipients);

        // configure sending
        $this->setRecipients($recipients);
        $this->setMessage($message);
        $this->setSender($sender);
        $this->setMode($mode);

        // perform request to API
        $this->httpRequest();

        return true;
    }

}