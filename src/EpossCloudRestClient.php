<?php

namespace BtEcommerce\BTEposs;

class EpossCloudRestClient
{
    $API_TEST			= 'https://ecclients.btrl.ro:5443/payment/rest';
    $API_LIVE			= 'https://ecclients.btrl.ro/payment/rest';
    
    if(config('bteposs.api_mode') == "live"){
    const API_URL = $API_LIVE;
    }else {
    const API_URL = $API_TEST;
    }
    
    const PHASE_ONE_ORDER		= '/register.do';
    const PHASE_TWO_ORDER		= '/registerPreAuth.do';
    const PHASE_TWO_FINISH_ORDER	= '/deposit.do';
    
    const DEBUG_ON_ERROR = false; // use this only in development phase; DON'T USE IN PRODUCTION !!!
    private $hash = '';

    public function __construct($user, $pass)
    {
        $this->api_user = $user;
        $this->api_pass = $pass;
    }

    private function _cURL($url, $data=array(), $request='')
    {
    
	$data['userName'] = $this->api_user;
	$data['password'] = $this->api_pass;
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        if (!empty($request)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        }


        // debugging
        $isDebug = self::DEBUG_ON_ERROR;
        if (!empty($isDebug)) {
            $debug = array(
                'URL: '     => $url,
                'data: '    => $data,
            );
            echo '<pre>' , print_r($debug, true), '</pre>';
        }

        return $ch;
    }

    private function _queryApi($url, $data='', $request='')
    {
        if (empty($url)) {
            return false;
        }

        $ch     = $this->_cURL($url, $data, $request);
        $return = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status!=200) {
            $errorMessage = json_decode($return, true);
            throw new \Exception($errorMessage);
            // empty response
            $return = $errorMessage;
        }

        return $return;
    }

    public function PhaseOnePay($data)
    {
        return $this->_queryApi(self::API_URL.self::PHASE_ONE_ORDER $data);
    }

}
