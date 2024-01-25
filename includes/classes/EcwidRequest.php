<?php
class EcwidRequest
{
    static $urls = array(
        'ORDER' => 'https://app.ecwid.com/api/v3/44217093/orders',
    );

    public $url, $totalPages, $currentPage;
    static $token = 'secret_2S6Njz7EUVeNkZwy9bif2fx7hMic4PqR';

    function __construct($type)
    {
        $this->url = EcwidRequest::$urls[$type];
        $this->totalPages = 1;
        $this->currentPage = 0;
    }

    function makeRequest($query)
    {
        echo 'makeRequest';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . '?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . EcwidRequest::$token,
                "accept: application/json"
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

    function next()
    {
        // echo 'Before';
        // echo $this->totalPages;
        // echo $this->currentPage;
        if ($this->totalPages >= $this->currentPage + 1) {
            $response = $this->makeRequest([
                'offset' => $this->currentPage * 100,
            ]);

            if ($response === null)
                return null;
        } else {
            return null;
        }

        // $this->totalPages = ceil($response['total'] / 100);
        $this->totalPages = 1;
        $this->currentPage = ($response['offset'] / 100) + 1;
        $orders = $response['items'];

        echo 'After';
        echo $this->totalPages;
        echo $this->currentPage;

        return $orders;
    }
}