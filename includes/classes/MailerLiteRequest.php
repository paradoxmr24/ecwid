<?php
class MailerLiteRequest
{

    static $url = 'https://api.mailerlite.com/api/v2/subscribers/';
    static $apiKey = ''; // bugfix

    function __construct()
    {
    }

    function updateSubscriber($email, $dates)
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => MailerLiteRequest::$url . $email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => json_encode([
                'fields' => [
                    'custom_field_1bestellung' => array_shift($dates),
                    'custom_field_2bestellung' => array_shift($dates),
                    'custom_field_3bestellung' => array_shift($dates),
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "X-MailerLite-ApiDocs: true",
                'X-MailerLite-ApiKey: ' . MailerLiteRequest::$apiKey,
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return null;
        }

        return json_decode($response, true);
    }
}