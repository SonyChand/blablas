<?php

namespace App\Traits;

use Twilio\Rest\Client;
use Exception;

trait TwilioTrait
{
    public function sendWhatsAppMessage($recipientNumber, $message, $mediaUrl = null)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');

        try {
            $twilio = new Client($twilioSid, $twilioToken);

            $messageData = [
                "from" => "whatsapp:+{$twilioWhatsAppNumber}",
                "body" => $message,
            ];

            if ($mediaUrl) {
                $messageData["mediaUrl"] = [$mediaUrl];
            }

            $twilio->messages->create(
                "whatsapp:+{$recipientNumber}",
                $messageData
            );

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
