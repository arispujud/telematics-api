<?php

namespace TelematicsApi;

class Telematics
{
    public $token;
    public $lang;
    public $base_url = 'https://telematics.transtrack.id/api';
    public $speed_limit=null;
    public $ignition_off=null;
    public $event_types=null;
    public $geofences = null;

    /**
     * [Constructor]
     *
     * @param mixed $token=null
     * @param mixed $lang='en'
     * 
     */
    public function __construct($token=null, $lang='id'){
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

    public function post($endpoint, $headers, $body, $params=null){
        $curl = curl_init();
        $baseUrl = $this->base_url;
        $url = $baseUrl.$endpoint;
        if(!is_null($params)){
            $url .="?".http_build_query($params);
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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

    /**
     * [Description for get]
     *
     * @param string $endpoint
     * @param mixed $headers
     * @param mixed $params
     * 
     * @return [type]
     * 
     */
    public function get($endpoint, $headers, $params){
        $curl = curl_init();
        $baseUrl = $this->base_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl.$endpoint."?".http_build_query($params),
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
            'lon' => $lng,
            'lang' => $this->lang
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

    /**
     * [Get All Devices Latest]
     *
     * @return [Object]
     * 
     */
    public function get_devices_latest(){
        $endpoint = '/get_devices_latest';
        $headers = [];
        $params = [
            'user_api_hash' => $this->token,
            'lang' => $this->lang
        ];
        $res = $this->get($endpoint,$headers,$params);
        return $res;
    }
    
    /**
     * [Generating Custom Report]
     *
     * @param array $devices
     * @param datetime $date_from
     * @param datetime $date_to
     * @param string $format='json'
     * @param integer $type
     * @param bool $show_addresses=false
     * 
     * @return JSON
     * 
     */
    public function generate_custom_report($devices, $date_from, $date_to, $type, $format, $show_addresses=false, $zones_instead=false, $skip_blank_result=true, $stop=60){
        $endpoint = '/generate_report';
        $headers = [
            "content-type: application/json;"
        ];
        $params = [
            'user_api_hash' =>$this->token,
            'lang' => $this->lang
        ];
        $body = [
            'devices' => $devices,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'format' => $format,
            'type' => $type,
            'send_to_email'=> null,
            'show_addresses' => $show_addresses,
            'zones_instead' => $zones_instead,
            'skip_blank_result' => $skip_blank_result,
            'stops' => $stop,
            'generate' => true,
        ];
        if(!is_null($this->speed_limit)){
            $body['speed_limit'] = $this->speed_limit;
        }
        if(!is_null($this->ignition_off)){
            $body['ignition_off'] = $this->ignition_off;
        }
        if(!is_null($this->event_types)){
            $body['event_types'] = $this->event_types;
        }
        if(!is_null($this->geofences)){
            $body['geofences'] = $this->geofences;
        }
        $res = $this->post($endpoint,$headers,json_encode($body), $params);
        return $res;
    }

    /**
     * [Description for get_object_history_report]
     *
     * @param array $devices
     * @param string $date_from
     * @param string $date_to
     * @param bool $show_addresses=false
     * 
     * @return [type]
     * 
     */
    public function get_object_history_report($devices, $date_from, $date_to, $show_addresses=false){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,25,'json',$show_addresses);
        return $res;
    }   
    /**
     * [Description for get_travelsheet_report]
     *
     * @param array $devices
     * @param string $date_from
     * @param string $date_to
     * @param bool $show_addresses=false
     * 
     * @return [type]
     * 
     */
    public function get_travelsheet_report($devices, $date_from, $date_to, $show_addresses=false,$stop=60){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,39,'json',$show_addresses,true,true,$stop);
        return $res;
    }   
    /**
     * [Description for get_drive_and_stop_report]
     *
     * @param array $devices
     * @param string $date_from
     * @param string $date_to
     * @param bool $show_addresses=false
     * 
     * @return [type]
     * 
     */
    public function get_drive_and_stop_report($devices, $date_from, $date_to, $show_addresses=false, $stop=60){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,3,'json',$show_addresses,true,true,$stop);
        return $res;
    }   
    public function get_general_information_report($devices, $date_from, $date_to, $show_addresses=false, $stop=60, $speed=100){
        $this->speed_limit = $speed;
        $res = $this->generate_custom_report($devices,$date_from,$date_to,1,'json',$show_addresses,true,true,$stop);
        return $res;
    }   
    public function get_temperature_report($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,13,'json',false,false,false,60);
        return $res;
    }   
    public function get_ignition_report($devices, $date_from, $date_to, $ignition_off=1){
        $this->ignition_off = $ignition_off;
        $res = $this->generate_custom_report($devices,$date_from,$date_to,30,'json',false,false,false,60);
        return $res;
    }
    public function get_fuel_level_report($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,10,'json',false,false,false,60);
        return $res;
    }   
    public function get_event_report($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,8,'json',false,false,false,60);
        return $res;
    }  
    public function get_geofences(){
        $endpoint = '/get_geofences';
        $headers = [];
        $params = [
            'user_api_hash' => $this->token,
            'lang' => $this->lang
        ];
        $res = $this->get($endpoint,$headers,$params,true);
        if($res->status){
            return $res->items->geofences;
        }
        return [];
    } 
    public function get_geofence_report($devices, $date_from, $date_to, $geofence_ids){
        $this->geofences = $geofence_ids;
        $res = $this->generate_custom_report($devices,$date_from,$date_to,7,'json',false,false,false,60);
        $this->geofences = null;
        return $res;
    }  
    public function get_geofence_touch_report($devices, $date_from, $date_to, $geofence_ids){
        $this->geofences = $geofence_ids;
        $res = $this->generate_custom_report($devices,$date_from,$date_to,31,'json',false,false,false,60);
        $this->geofences = null;
        return $res;
    }  
    public function get_routes_report($devices, $date_from, $date_to, $speed=100){
        $this->speed_limit = $speed;
        $res = $this->generate_custom_report($devices,$date_from,$date_to,43,'json',false,false,false,60);
        $this->speed_limit = null;
        return $res;
    }  
    public function get_fuel_filling_report($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,11,'json',false,false,false,60);
        return $res;
    }  
    public function get_fuel_theft_report($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices,$date_from,$date_to,12,'json',false,false,false,60);
        return $res;
    } 
    public function get_drives_and_stop_geofences($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices, $date_from, $date_to, 18, 'json', false, false, false, 60);
        return $res;
    } 
    public function odometer($devices, $date_from, $date_to){
        $res = $this->generate_custom_report($devices, $date_from, $date_to, 62, 'json', false, false, false, 60);
        return $res;
    }
}