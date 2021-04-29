<?php
class CommonConfig
{

    public const API_USER_NAME = "vnpjotv";
    public const API_PASSWORD = "vnpjotv123!@#";
    public const API_URL_CUSTOM_CARE = "http://cms-api.jofun.vn:8084/customer-care";
    public const API_URL_CONTENT = "http://cms-api.jofun.vn:8083/update-content";

    public const SERVICE = '';
    public const SERVICE_CODE = 'VNPJOTV';
    public const SUB_TRANSACTION_DETAIL = 'Sub_transaction_details';
    public const SEND_MT = "Send_mt";


    /**
     * STATUS RESPONSE
     */
    public const RESPONSE_SUCCESS = 1;
    public const RESPONSE_ERROR = 2;
    public const RESPONSE_ERROR_COMMON = 3;
    public const RESPONSE_ERROR_VERIFY_PHONE = 4;

    public const LIST_PACKAGE_SERVICE = [
        "VIDEO",
        "TINTUC",
        "GIAITRIMIENPHI"
    ];
    //6280 6274
    public const CATEGORY_VIDEO = 795;
    public const CATEGORY_TIN_TUC = 40993;

    public const IS_REGISTER = 1;
    public const UN_REGISTER = 2;


    /** THAM SO KÊT NÔI */
    public const FIRST_NUMBER = 1286;
    public const RETURN_URL = "http://jofun.vn";
    public const BACK_URL = "http://jofun.vn";
    public const CP = "BANVIET";
    public const SERVICEID = "1001044";
    public const KEY = "vasgate@13579";
    public const LIST_PACKAGE_ID = [
        "VIDEO" => "1012517",
        "TINTUC" => "1012518",
        "GIAITRIMIENPHI" => "1012749"
    ];
    /***  */
    public const RESPONSE_STATUS = [
        'error_login' => "Thông tin đăng nhập không đúng, Nhập số điện thoại và ấn lấy mật khẩu nếu bạn quên mật khẩu",
        'error_empty' => "Số điện thoại không được để trống",
        'error_verify' => "Không phải số điện thoại",
        'error_un_register' => "Thuê bao chưa đăng ký, Vui lòng đăng ký tham gia dịch vụ",
        'error' => "Có lỗi xảy ra. Bạn vui lòng thử lại trong giây lát",
        'success' => "Mật khẩu đã được gửi vào số thuê bao quý khách"
    ];

    // Sytax register
    public const LIST_SYSTAX = [
        "VIDEO" => "OK",
        "TINTUC" => "DK",
        "GIAITRIMIENPHI" => "MP"
    ];

    const LIST_IMG_PACKAGE = [
        "VIDEO" =>  "http://jofun.vn/wp-content/uploads/2019/12/huy_video.jpg",
        "TINTUC" => "http://jofun.vn/wp-content/uploads/2019/12/huy_tintuc.jpg"
    ];

    const PACKAGE_FREE = "GIAITRIMIENPHI";

}