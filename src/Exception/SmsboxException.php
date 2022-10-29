<?php 

namespace Alpifra\SmsboxApi\Exception;

/**
 * Base exception catcher for SMS Box package
 */
class SmsboxException extends \RuntimeException
{
    
    /**
     * @inheritdoc
     */ 
    public function __construct(string $message = '', int $code, ?\Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->previous = $previous;
    }

}
