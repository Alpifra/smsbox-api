# SMS BOX API

A PHP client to help dealing with the SMS BOX API v1.1 to send direct message or commercial campaign from HTTPS requests to SMS notificaiton.

For more information on the API, please read the SMS BOX Documentation.

## Useful links

The SMS BOX API v1.1 [documentation](https://en.smsbox.net/docs/doc-API-SMSBOX-1.1-EN.html)

---

## Usage

#### Sending simple SMS

```php
<?php

$client = new Alpifra\SmsboxApi\Client\Sms('***API_KEY***', 4, false)
$recipients = ['336*********', '336*********'];
$message = 'Hello SMS world!';

$client->send($recipients, $message);
```