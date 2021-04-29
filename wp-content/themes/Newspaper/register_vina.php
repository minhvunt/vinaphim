<?php
/**
 * Created by PhpStorm.
 * User: anhnv
 * Date: 7/6/2018
 * Time: 4:07 PM
 */
	/*
		Template Name: REGISTER VNP
	*/
	session_start();
    require_once('apinnx.php');
    $modal = new ApiNnx();
	header("Content-Type: text/html;charset=UTF-8");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$msisdn = $modal->gms();
	$ip = $modal->GetClienIP();
	$url = $_SERVER["REQUEST_URI"];
	$uriArray = explode("p=",$url);
    $packArray = array("LUA","LUA1","LUA30","CF","CF1","CF30","CB","TIEU","TIEU1","TIEU30","TOM","TOM1","TOM30","CA","CA1","CA30","CS","DIEU","CB1","BTB","DB","NB","TB","CBHN","SH","NTB","TN","LCT","AT","AT7","G","G7","LV","LV7","TN","TN7","NONGNGHIEP","GT","GT7","GIAOTHONG","TA","TA7","THOITRANG","TD","TD7","DULICH","TK","TK7","SUCKHOE","CT","CT7","CANHBAO","TT");
	if(in_array($uriArray[1],$packArray)) $goi = $uriArray[1]; //else wp_redirect( home_url() );

	/**** DANG KY VASGATE VNP ********/
	$requestid = time();
	$backurl = "http://v.nhanongxanh.vn";
	$returnurl = "http://v.nhanongxanh.vn";
	$returnurl_endcode = urlencode(strtolower("http://v.nhanongxanh.vn"));
	$backurl_endcode = urlencode(strtolower("http://v.nhanongxanh.vn"));
	$cp	= "CP_AGRIMEDIA_NONGTHONXANH";
	$service = "NHANONGXANH";
	$now = date('Y-m-d H:i:s');
	$requestdatetime = date('YmdHis');
	$channel = "WAP";
	$packagename = $goi;
	$pass = "CP_AGRIMEDIA@201608";
	$note = "dk wap";
	$securecode = md5($requestid.$returnurl.$backurl.$cp.$service.$packagename.$requestdatetime.$channel.$pass);
	//echo $securecode;die;
	$link = "http://dk1.vinaphone.com.vn/reg.jsp?requestid=$requestid&returnurl=$returnurl_endcode&backurl=$backurl_endcode&cp=$cp&service=$service&package=$packagename&requestdatetime=$requestdatetime&channel=$channel&securecode=$securecode&language=vi&note=$note";
	// echo $link;die;

	wp_redirect($link);

	/******** END *****/


?>
