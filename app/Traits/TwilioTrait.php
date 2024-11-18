<?php

namespace App\Traits;

use Twilio\Rest\Client;
use Exception;

trait TwilioTrait
{
    public function sendWhatsAppMessageToAdmin($message, $mediaUrl = null)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');
        $twilioRecipientNumber = env('TWILIO_RECIPIENT_NUMBER');

        try {
            $twilio = new Client($twilioSid, $twilioToken);

            $messageData = [
                "from" => "whatsapp:{$twilioWhatsAppNumber}",
                "body" => $message,
            ];

            if ($mediaUrl) {
                $messageData["mediaUrl"] = [$mediaUrl];
            }

            $twilio->messages->create(
                "whatsapp:{$twilioRecipientNumber}",
                $messageData
            );

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
