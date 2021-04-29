<?php
/**
 * Created by PhpStorm.
 * User: anhnv
 * Date: 11/8/2019
 * Time: 10:21 AM
 */
require_once ('logging.php');
require_once ('CommonConfig.php');
class ApiBase
{

    private $log;
    private $common;
    public function __construct()
    {
        $this->log = new Logging();
        $this->common = new CommonConfig();
    }

    public function sendContentForVas($data, $serviceName, $url)
    {
        $userName = $this->common::API_USER_NAME;
        $passWord = $this->common::API_PASSWORD;
        $auth = base64_encode($userName . ":" . $passWord);
        $auth = "Basic " . $auth;
        $ch = curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_HTTPAUTH, CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(

                'Authorization: ' . $auth,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $message = "";
        $message .= "=============================BEGIN " . $serviceName . "&&" . $data['service'] . " =========================\n";
        $message .= "URL : " . $url . " : Username: " . $userName . " : Password: " . $passWord;
        $message .= "\nDATA SEND : " . json_encode($data);
        $response = curl_exec($ch);
        $message .= "\nDATA RECEIVE : " . json_encode($response) . "\n";
        $message .= "SERVER_ERROR : " . curl_error($ch) . "\n";
        $message .= "=============================END " . $serviceName . "=========================\n\n\n";
        $this->writeLog($message);
        return $response;
    }

    public function writeLog($message){
        $dir_log_name = 'wp-content/themes/Newspaper/log/';
        if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'))) {
            if (!mkdir($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'), 0777, true)) {
                $error = error_get_last();
                echo $error['message'];
            }
        }
        if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt')) {
            fopen($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt', "wr");
        }
        $this->log->lfile($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt');
        $this->log->lwrite($message);
    }

}

