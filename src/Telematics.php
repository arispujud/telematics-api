<?php

namespace TelematicsApi;

class Telematics
{
    public $token;
    public $lang;
    public $base_url = 'https://telematics.transtrack.id/api';
    public $custom_api = 'https://custom-api.transtrack.id/api';

    /**
     * [Constructor]
     *
     * @param mixed $token=null
     * @param mixed $lang='en'
     * 
     */
    public function __construct($token=null, $lang='en'){
        $this->token = $token;
        $this->lang = $lang;
    }

    /**
     * [Set Telematics Token]
     *
     * @param mixed $token
     * 
     * @return [type]
     * 
     */
    public function setToken($token){
        $this->token = $token;
    }

    /**
     * [Set Response Language]
     *
     * @param mixed $lang
     * 
     * @return [type]
     * 
     */
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

    /**
     * [Login by email & password to TransTRACK Telematics]
     *
     * @param mixed $email
     * @param mixed $password
     * 
     * @return [Object]
     * 
     */
    public function login($email, $password){
        $endpoint = '/login';
        $headers = [
            "content-type: multipart/form-data;"
        ];
        $body = [
            'email' => $email,
            'password' => $password,
            'lang' => $this->lang
        ];
        $res = $this->post($endpoint,$headers,$body);
        return $res;
    }

    /**
     * [Get human readable for address]
     *
     * @param mixed $lat
     * @param mixed $lng
     * 
     * @return [Object]
     * 
     */
    public function get_address($lat, $lng){
        $endpoint = '/geo_address';
        $headers = [];
        $params = [
            'lat' => $lat,
            'lon' => $lng
        ];
        $res = $this->getRaw($endpoint,$headers,$params);
        return ['status' => 1, "address" => $res];
    }

    /**
     * [Get All Devices]
     *
     * @return [Object]
     * 
     */
    public function get_devices(){
        $endpoint = '/get_devices';
        $headers = [];
        $params = [
            'user_api_hash' => $this->token,
            'lang' => $this->lang
        ];
        $res = $this->get($endpoint,$headers,$params);
        return $res;
    }

}