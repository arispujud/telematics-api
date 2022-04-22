<?php

namespace TelematicsApi;

class Telematics
{
    public $token;
    public $lang;
    public $base_url = 'https://telematics.transtrack.id/api';
    public $custom_api = 'https://custom-api.transtrack.id/api';

    public function __construct($token=null, $lang='en'){
        $this->token = $token;
        $this->lang = $lang;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function setLanguage($lang){
        $this->lang = $lang;
    }

    public function post($endpoint, $headers, $body){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url.$endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER  => 0,
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function get($endpoint, $headers, $params){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url.$endpoint."?".http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER  => 0,
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }
    public function getRaw($endpoint, $headers, $params){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url.$endpoint."?".http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER  => 0,
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }

    public function login($email, $password){
        $endpoint = '/login';
        $headers = [
            "content-type: multipart/form-data;"
        ];
        $body = [
            'email' => $email,
            'password' => $password
        ];
        $res = $this->post($endpoint,$headers,$body);
        return $res;
    }

}