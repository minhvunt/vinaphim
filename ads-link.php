<?php

$partner = 'AGRIMEDIA';
if (isset($_GET['partner'])) {
    $partner = $_GET['partner'];
}

require_once('wp-load.php');
require_once('logging.php');
require_once('mobiadsCommon.php');
define('URL_VNM_MSISDN_GW', 'https://gateway.vietnamobile.com.vn/query/ldap?');
define('URL_LANDING_PAGE', 'http://vm.nhanongxanh.vn/landing-page/');
define('URL_REGISTER', 'http://117.6.87.214:50002/vnm-nnx/report/');

//B1: Get client ip
$ipaddress = mobiadsCommon::get_client_ip_server();
$check = mobiadsCommon::Is3GVNM($ipaddress);

$log = new Logging();
$dir_log_name = 'wp-content/themes/Newspaper/log/';

if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'))) {
    if (!mkdir($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'), 0777, true)) {
        $error = error_get_last();
        echo $error['message'];
    }
}
// set path and name of log file (optional)
if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api_reg_lua.txt')) {
    fopen($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api_reg_lua.txt', "w");
}

$log->lfile($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api_reg_lua.txt');

$log->lwrite('Nhận partner: ' . $partner);
if (isset($_GET['partner'])) {
    $log->lwrite('Nhận GET: ' . $_GET['partner']);
}

//date_default_timezone_set("Asia/Bangkok");
if (!isset($_REQUEST['response_code'])) {
    $log->lwrite('----------------------------------------');
    if ($check == 1) {
        $current_time = time();

        $date = new DateTime();

        $log->lwrite('Call nhận diện');
        $date = $date->format('Y-m-d\TH:i:s\Z');

        $http_build = 'cp_id=AgMediaGreenAg&request_id=' . $current_time . '&request_time=' . $date . '&return_url=http://vm.nhanongxanh.vn/CTKM/thoitiet01/' . $partner;

        $signature = hash_hmac('sha256', $http_build, 'CGaEqv3J$876f7174260689ad318ee0f325aa1d7ae8adfacd75a33c2d1387bb9977924da3');
        $log->lwrite('Signature: ' . $signature);


        $request_data = $http_build . '&signature=' . $signature;
        $log->lwrite('Input: ' . $request_data);

        $url = URL_VNM_MSISDN_GW . $request_data;

        $log->lwrite('Url: ' . $url);
        header('Location: ' . $url);
    } else {
        $log->lwrite('Không thuộc dải IP ip:' . $ipaddress);
        header('Location: ' . URL_LANDING_PAGE);
    }



} else {

    $log->lwrite('----------------------------------------');
    $log->lwrite('Nhận response');

    if (isset($_REQUEST['response_code']) && !empty($_REQUEST['message'])) {
        $log->lwrite('Output: ' . $_REQUEST);
        if ($_REQUEST['response_code'] == 0 && mobiadsCommon::checkPhoneNumber($_REQUEST['message'])) {
            $msisdn = $_REQUEST['message'];
            $log->lwrite('MSISDN: ' . $msisdn);
            //Đăng ký ngầm gói lúa + gói thời tiết.
            //B2: DataRequest gói lúa. //no empty
            //B4: Data request gói thời tiết.

            $author = base64_encode('nhanongxanhvnm:nhanongxanhvnm123!@#');

            $data_lua_request = array(
                'service' => 'Register_cancel',
                'serviceCode' => 'NNXVNM',
                'param' =>
                    array(
                        'msisdn' => $msisdn,
                        'packageCode' => 'LUA',
                        'action' => 'Reg',
                        'freeDays' => NULL,
                        'noMt' => 1,
                        'channel' => 'ADS',
                        'userName' => 'ADS',
                        'userIp' => $ipaddress,
                        'partner' => $partner,
                    ),
            );

            // write message to the log file
            //B3: Call api đăng ký gói lúa.
            $data_lua_request = json_encode($data_lua_request);

            $log->lwrite('Input LUA: ' . $data_lua_request);

            $ch_lua = curl_init();

            $opt_header_lua_arr = array(
                'Content-Type: application/json',
//                'Content-Length: ' . strlen($data_lua_request),
                'Authorization: Basic ' . $author
            );

            curl_setopt($ch_lua, CURLOPT_HEADER, FALSE);
            curl_setopt($ch_lua, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch_lua, CURLOPT_URL, URL_REGISTER);
            curl_setopt($ch_lua, CURLOPT_POST, TRUE);
            curl_setopt($ch_lua, CURLOPT_POSTFIELDS, $data_lua_request);
            curl_setopt($ch_lua, CURLOPT_HTTPHEADER, $opt_header_lua_arr);
            curl_setopt($ch_lua, CURLOPT_TIMEOUT, 100);
            $data_lua = curl_exec($ch_lua);
            if (!$data_lua) {
                echo curl_error($ch_lua);
                $log->lwrite('OUTPUT ERROR: ' . curl_error($ch_lua));
            } else {
                $log->lwrite('OUTPUT LUA: ' . $data_lua);
            }
            $http_lua_status = curl_getinfo($ch_lua, CURLINFO_HTTP_CODE);

            // Close connection
            curl_close($ch_lua);


        } else {
            $log->lwrite('Error: Không nhận diện được số');
        }
    }
    header('Location: ' . URL_LANDING_PAGE);
}
