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
        $date1 = array_shift($dates);
        $date2 = array_shift($dates);
        $date3 = array_shift($dates);
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
                    'custom_field_1bestellung' => $date1,
                    'custom_field_2bestellung' => $date2,
                    'custom_field_3bestellung' => $date3,
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

        echo "Updated -> email: " . $email . " Dates: " . implode(', ', [$date1, $date2, $date3]) . "<br>";

        echo $response . "<br><br>";

        return json_decode($response, true);
    }
}