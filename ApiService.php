<?php

require_once ('ApiBase.php');
require_once ('CommonConfig.php');
class ApiService
{
    public $apiBase;
    private $common;
    public function __construct()
    {
        $this->apiBase = new ApiBase();
        $this->common = new CommonConfig();
    }

    public function SubTransactionDetail($msisdn){
        $data['service'] = $this->common::SUB_TRANSACTION_DETAIL;
        $data['serviceCode'] = $this->common::SERVICE_CODE;
        $data['param'] = [
            "msisdn" => $msisdn,
            "startDate" => '10/11/2019',
            "endDate" => date('d/m/Y',time()),
            "status" => null
        ];
        $baseURl = $this->common::API_URL_CUSTOM_CARE;
        $response = $this->apiBase->sendContentForVas($data,$this->common::SERVICE_CODE, $baseURl);
        $res = json_decode($response, true);
        if (!isset($res['statusCode']) || $res['statusCode'] != 200 || $res == false) {
            return [];
        }else{
            $result = $this->processDataSubTransaction($res['data']);
            return $result;
        }
    }
    private function processDataSubTransaction($data){
        $aryPack = [];
        foreach ($data['subStatus'] as $item) {
            if($item['status'] == 1){
                array_push($aryPack, $item['packageCode']);
            }
        }
        return $aryPack;
    }

    public function sendPassword($msisdn, $content)
    {
        $data['service'] = $this->common::SEND_MT;
        $data['serviceCode'] = $this->common::SERVICE_CODE;
        $data['param'] = [
            "msisdn" => $msisdn,
            "content" => $content,
            "commandCode" => null,
            "channel" => "wap"
        ];
        $baseURl = $this->common::API_URL_CONTENT;
        $response = $this->apiBase->sendContentForVas($data,$this->common::SERVICE_CODE, $baseURl);
        $res = json_decode($response, true);
        if (isset($res['statusCode']) && $res['statusCode'] == 200) {
            return $this->common::RESPONSE_SUCCESS;
        } else {
            // Check lại phần ghi log permission open file
            return $this->common::RESPONSE_SUCCESS;
        }
    }

}