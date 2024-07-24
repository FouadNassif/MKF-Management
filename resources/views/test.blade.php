<?php
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
    require_once '/path/to/vendor/autoload.php';
    use Twilio\Rest\Client;

    $sid    = "ACb2c7bebe8eb627070f36f5c0b62a5fb2";
    $token  = "ce56fd4d8b9d6d5d7b9a5bc93a60a466";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create(
        array(
                  "body" => "Your Message"
        )
      );

print($message->sid);