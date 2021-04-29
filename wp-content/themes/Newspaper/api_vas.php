<?php
/* Template Name: API VAS */
if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
    response(404, "User Pass not found");
} else {
    if (!($_SERVER["PHP_AUTH_USER"] == "jofunadmin" && $_SERVER["PHP_AUTH_PW"] == "jofun2019!@#")) {
        response(403, "Không đúng thông tin đăng nhập ");
    }
}
header('Content-type: application/json; charset=utf8');
require_once ($_SERVER['DOCUMENT_ROOT'].'/CommonService.php');
$input = file_get_contents('php://input');
$input = json_decode($input,true);
$serviceCode = (isset($input['service'])) ? $input['service'] : "";
$phone = isset($input['param']['msisdn']) ? $input['param']['msisdn'] : '';
global $wpdb;
switch ($serviceCode){
    case 'get_password':
        get_pass($phone);
        break;
    default :
        response(404, "Service không tồn tại");
        break;
}
function get_pass($phone){
    global $wpdb;
    $objCommon = new CommonService();
    try{
        if (!empty($phone)){
            $result = $wpdb->get_row( sprintf("SELECT * FROM users WHERE msisdn = '%s'",$phone ) );
            if (!empty($result)){
                $data = (array)$result;
                return response(0, $data);
            } else {
                $password = $objCommon->generateRandomString(6);
                $dataInsert = [
                    'msisdn' => $phone,
                    'password' => $password,
                    'createtime' => date('Y-m-d H:i:s', time())
                ];
                $rs = $wpdb->insert('users', $dataInsert);
                if ($rs){
                    return response(0, $dataInsert);
                } else {
                    return response(1, 'Lỗi không tạo được mật khẩu');
                }
            }
        } else {
            response(405, "Số điện thoại không được để trống");
        }
    }catch (Exception $e){
        return response(500, $e->getMessage());
    }


}
function response($statusCode, $data){
    $res = [
        'statusCode' => $statusCode,
        'data' => is_array($data) ? [ "msisdn" => $data['msisdn'], "password" => $data['password'] ] : ["message" => $data ]
    ];
    echo json_encode($res, true);
    exit;
}

