<?php
/**
 * Created by PhpStorm.
 * User: shanedejager
 * Date: 02/07/15
 * Time: 10:00
 */

require_once 'sslLabsApi.php';

class SSL_Labs_Admin_API_Client {

    protected $api;
    protected $host;
    protected $response;
    protected $grades = array('A+','A-','A','B','C','D','E','F','T','M');

    public function __construct($host){
        //Return API response as JSON object
        $this->host = $host;
        $this->api = new sslLabsApi(true);
    }

    public function analyse($startnew = false){
        $response = $this->api->fetchHostInformation($this->host, false, $startnew, false, null, true, true);
        $this->response = $response;
        return $response;
    }

    public function check_grade($grade){
        $invalid_endpoints = array();
        $level = array_search($grade,$this->grades);
        foreach($this->response->endpoints as $endpoint){
            $endpoint_level = array_search($endpoint->grade,$this->grades);
            if($endpoint_level > $level){
                $invalid_endpoints[] = $endpoint;
            }
        }
        return (count($invalid_endpoints) <= 0);
    }

}