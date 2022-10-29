<?php 

namespace Alpifra\SmsboxApi;

use Alpifra\SmsboxApi\Exception\RequestException;
use Alpifra\SmsboxApi\Exception\ResponseException;
use Alpifra\SmsboxApi\Exception\ResponseCodeException;
 

 class Base {

    public const BASE_URL = 'https://api.smsbox.pro/1.1/api.php';
    public const ALLOWED_MODE = ['Standard', 'Expert', 'Reponse'];
    public const ALLOWED_STRATEGY = [1, 2, 3, 4];
    
    /**
     * API key available on your manager
     *
     * @var string
     */
    private $apiKey;    

    /**
     * Sending message
     *
     * @var string
     */
    private $message;    

    /**
     * Phone numbers
     *
     * @var array
     */
    private $recipients;

    /**
     * Sending mode : Standard, Expert, Reponse 
     * More info on http://fr.smsbox.net/docs/doc-API-SMSBOX-1.1-FR.html
     *
     * @var string
     */
    private $mode;    

    /**
     * Sending strategy : 1, 2, 3 or 4
     * More info on http://fr.smsbox.net/docs/doc-API-SMSBOX-1.1-FR.html
     *
     * @var int
     */
    private $strategy;

    /**
     * Allow reply to the SMS
     *
     * @var bool
     */
    private $reply;

    /**
     * The SMS sender
     *
     * @var string|null
     */
    private $sender;
    
    /**
     * __construct
     *
     * @param  string $apiKey
     * @param  string $mode
     * @param  int $strategy
     * @param  bool $reply
     * @return void
     */
    public function __construct(string $apiKey, int $strategy = 4, bool $reply = false)
    {
        $this->apiKey = $apiKey;
        $this->strategy = $strategy;
        $this->reply = $reply;
    }
    
    /**
     * Set the content message to send
     *
     * @param  string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    
    /**
     * Set recipients
     *
     * @param  array $recipients
     * @return void
     */
    public function setRecipients(array $recipients): void
    {
        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        $this->recipients = $recipients;
    }
    
    /**
     * Set mode according mode
     *
     * @param  string $mode
     * @return void
     */
    public function setMode(string $mode): void
    {
        if ($this->reply) {
            $this->mode = 'Reponse';
            return;
        } else if (!in_array($mode, self::ALLOWED_MODE)) {
            return;
        }

        $this->mode = $mode;
    }
    
    /**
     * Set the sender
     *
     * @param  string|null $sender
     * @return void
     */
    public function setSender(?string $sender): void
    {
        $this->sender = $sender;
    }

    public function httpRequest()
    {
        set_time_limit(0);

        $header = [
            "Accept: text/xml",
            "Authorization: App {$this->apiKey}"
        ];

        $postFields = [
            'dest'     => $this->recipients,
            'msg'      => $this->message,
            'mode'     => $this->mode,
            'strategy' => $this->strategy,
        ];

        $ch = curl_init(self::BASE_URL);

        if ($ch === false) {
            throw new RequestException( sprintf('Request initialization to "%s" failed.', self::BASE_URL), 500 );
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);

        if ($result === false) {
            curl_close($ch);

            throw new ResponseException( sprintf('Failed to get response from "%s"', self::BASE_URL), 404 );
        }

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result !== 'OK') {
            throw new ResponseCodeException($result, $code);
        }

        curl_close($ch);

        return $result;
    }

 }