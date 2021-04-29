<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/CommonConfig.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/logging.php');
$objDefine = new CommonConfig();
$logObj = new Logging();
class CommonService
{

    public function __construct()
    {

    }

    /**
     * Lấy random mk gửi người dùng
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 4)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
// check mạng mobifone
    function isVinaphone($msisdn){
        $moblieVNP = '/^(84|0)(91|94|81|82|83|84|85|88)\d{7}$/';
        if (preg_match($moblieVNP, $msisdn) == true) {
            return 1;
        } else {
            return 2;
        }
    }
    // Nhận diện thuê bao
    public function gms() {
        $ms = $_SERVER['HTTP_MSISDN'];
        if (!isset($ms)){
            $ms = "";
        } else {
            $_SESSION['phone'] = $ms;
        }
        return $ms;
    }
    // Get IP client
    public function GetClienIP() {
        //check ip from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //to check ip is pass from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Hàm nhận diện 3G
     * @return int
     */
    public function Is3GVNP(){
        $ipRanges =  array(
            '127.0.0.0/16',
            '118.70.233.163/32',
            '192.168.0.0/16',
            '113.185.0.0/18',
            '10.0.0.0/8',
            '172.16.30.11/32',
            '172.16.30.12/32',
            '37.228.104.0/21',
            '58.67.157.0/24',
            '59.151.95.128/25',
            '59.151.98.128/27',
            '59.151.106.224/27',
            '59.151.120.32/27',
            '80.84.1.0/24',
            '80.239.242.0/23',
            '82.145.208.0/20',
            '91.203.96.0/22',
            '116.58.209.36/27',
            '116.58.209.128/27',
            '141.0.8.0/21',
            '195.189.142.0/23',
            '203.81.19.0/24',
            '209.170.68.0/24',
            '217.212.230.0/23',
            '217.212.226.0/24',
            '185.26.180.0/22'
        );
        $clientIP = $this->GetClienIP();
        $found = false;
        $accessType = 0;
        $clientIP = explode(',', $clientIP);

        foreach ($ipRanges as $range) {
            foreach ($clientIP as $item){
                if($this->cidrMatch($item, $range)) {
                    $found = true;
                    $accessType = 1;
                    break;
                }
            }
        }
        return $accessType;
    }

    public function cidrMatch($ip, $range){
        list ($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }

    /**
     * Hàm chuyển đầu số 0-> 84
     * @param $phone
     * @return mixed|string
     */
    function reversephone($phone)
    {
        $phone = str_replace("+", "", $phone);
        $rest = substr($phone, 0, 1);
        if ($rest == '0') {
            $phone = "84" . substr($phone, 1);
        }
        $rest = substr($phone, 0, 2);
        if ($rest != '84') {
            $phone = "84" . $phone;
        }
        return $phone;
    }

    function checkLogin($phone, $password){
        global $wpdb;
        global $objDefine;
        $result = $wpdb->get_row( sprintf("SELECT * FROM users WHERE msisdn = '%s' AND password = %d",$phone,$password ));
        return (!empty($result)) ? $objDefine::RESPONSE_SUCCESS  : $objDefine::RESPONSE_ERROR;
    }

    function forgetPass($phone){
        global $wpdb;
        global $objDefine;
        $result = $wpdb->get_row( sprintf("SELECT * FROM users WHERE msisdn = '%s' ",$phone ));
        return (!empty($result)) ? $result->password  : $objDefine::RESPONSE_ERROR;
    }

    function checkMobile(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;
        else
            return false;
    }
// check os
    function getOS() {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }
        return $os_platform;
    }

    public function getListCatRegister($catParent){
        $list_cat = get_category_children($catParent);
        $arrCat = array_map('intval', explode('/', $list_cat));
        array_push($arrCat,$catParent);
        return $arrCat;
    }

    /**
     * Check đăng ký gói cước theo chuyên mục
     * @param $catId
     * @return bool
     */
    public function isRegister($catId) {
        global $objDefine;
        if(in_array($catId, $_SESSION['VIDEO'])){
            if(isset($_SESSION['package'])  && in_array('VIDEO', $_SESSION['package']))
            return $objDefine::IS_REGISTER;
            else return $objDefine::UN_REGISTER;
        }else if(in_array($catId, $_SESSION['TINTUC'])){
            if(isset($_SESSION['package'])  && in_array('TINTUC', $_SESSION['package']))
            return $objDefine::IS_REGISTER;
            else return $objDefine::UN_REGISTER;
        }else if(!in_array($catId, $_SESSION['VIDEO']) && !in_array($catId, $_SESSION['TINTUC'])){
            return $objDefine::IS_REGISTER;
        }else{
            return $objDefine::UN_REGISTER;
        }
    }
    public function writeLog($message){
        global $logObj;
        $dir_log_name = 'wp-content/themes/Newspaper/log/';
        if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'))) {
            if (!mkdir($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d'), 0777, true)) {
                $error = error_get_last();
                echo $error['message'];
            }
        }
        if (!file_exists($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt')) {
            fopen($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt', "w");
        }
        $logObj->lfile($dir_log_name . date('Y') . '/' . date('m') . '/' . date('d') . '/log_call_api.txt');
        $logObj->lwrite($message);
    }
}