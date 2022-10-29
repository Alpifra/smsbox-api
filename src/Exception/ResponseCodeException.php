<?php

namespace Alpifra\SmsboxApi\Exception;

class ResponseCodeException extends SmsboxException
{    

    /**
     * @inheritdoc
     */
    public function __construct(string $message = '', int $code)
    {
        $this->message = self::translateApiErrorCode($message, $code);
        $this->code = $code;
    }
        
    /**
     * translateApiErrorCode
     *
     * @param  mixed $errorCode
     * @param  mixed $httpCode
     * @return string
     */
    public static function translateApiErrorCode(string $errorCode, int $httpCode): string
    {
        $message = "Server returned {$httpCode} status. ";

        $message .= match($errorCode) {
            'ERROR 01' => "Some parameters are missing or invalid. Check the arguments of your request.",
            'ERROR 02' => "Incorrect credentials, suspended API key, suspended account or restriction by source IP address. Check your identification data or go to the « API security » section of your Customer Area.",
            'ERROR 03' => "Exhausted or insufficient balance. Recharge your account by purchasing SMS Credits.",
            'ERROR 04' => "Invalid destination number or not meeting the expected format. Check that your recipient's number is entered correctly. Important: If your account or request restricts the sending to a specific country, this error will occur if the number provided does not match the expected format for that geography.",
            'ERROR 05' => "Internal execution error in our services.",
            'ERROR'    => "The sending failed for another reason (blacklisted number, duplicated content, unsupported prefix, ...).",
            default    => "Error does not match with any of the documented errors."
        };

        return $message;
    }

}
