<?php
/*
    Template Name: Đăng ký dịch vụ
*/
session_start();
header("Content-Type: text/html;charset=UTF-8");
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonService.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/CommonConfig.php');
    $objCommon = new CommonService();
    $objDefine = new CommonConfig();
    $packCode = isset($_GET['p']) ? trim($_GET['p']) : "";
    $aryPackage = $objDefine::LIST_PACKAGE_SERVICE;
    if (!in_array($packCode, $aryPackage)) {wp_redirect( home_url() );}

/**** DANG KY VASGATE VNP ********/
    $requestId = time();
    $backUrl = $objDefine::BACK_URL;
    $returnUrl = $objDefine::RETURN_URL;
    $returnUrlEnCode = urlencode(strtolower($returnUrl));
    $backUrlEndCode = urlencode(strtolower($backUrl));
    $cp = $objDefine::CP;
    $service = $objDefine::SERVICEID;
    $now = date('Y-m-d H:i:s');
    $requestDateTime = date('YmdHis');
    $channel = "WAP";
    $key = $objDefine::KEY;
    $note = "dk wap";
    $packId = $objDefine::LIST_PACKAGE_ID[$packCode];
    $securecode = md5($requestId . $returnUrl . $backUrl . $cp . $service . $packId . $requestDateTime . $channel . $key);
    $h_sc = md5($key.rand(1,999999));
// bss.vascloud.com.vn/unify/register.jsp
    if($packCode == $objDefine::PACKAGE_FREE){
        $link = "http://bssfreezone.vascloud.com.vn/unify/register.jsp?requestid=$requestId&returnurl=$returnUrlEnCode&backurl=$backUrlEndCode&cp=$cp&service=$service&package=$packId&requestdatetime=$requestDateTime&channel=$channel&securecode=$securecode&h_sc=$h_sc&language=vi&note=$note";
    }else {
        $link = "http://bss.vascloud.com.vn/unify/register.jsp?requestid=$requestId&returnurl=$returnUrlEnCode&backurl=$backUrlEndCode&cp=$cp&service=$service&package=$packId&requestdatetime=$requestDateTime&channel=$channel&securecode=$securecode&h_sc=$h_sc&language=vi&note=$note";
    }
// echo $link;die;

wp_redirect($link);

/******** END *****/


?>
