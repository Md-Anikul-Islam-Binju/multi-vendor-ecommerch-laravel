<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\PaymentController;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

/**
 * *****************************************************************
 * Copyright 2019.
 * All Rights Reserved to
 * Nagad
 * Redistribution or Using any part of source code or binary
 * can not be done without permission of Nagad
 * *****************************************************************
 *
 * author - Md Nazmul Hasan Nazim
 * @email - nazmul.nazim@nagad.com.bd
 * @date: 18/11/2019
 * @time: 10:20 AM
 * ****************************************************************
 */
class NagadPaymentController extends Controller
{

    function generateRandomString($length = 40)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function EncryptDataWithPublicKey($data)
    {
        $pgPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiCWvxDZZesS1g1lQfilVt8l3X5aMbXg5WOCYdG7q5C+Qevw0upm3tyYiKIwzXbqexnPNTHwRU7Ul7t8jP6nNVS/jLm35WFy6G9qRyXqMc1dHlwjpYwRNovLc12iTn1C5lCqIfiT+B/O/py1eIwNXgqQf39GDMJ3SesonowWioMJNXm3o80wscLMwjeezYGsyHcrnyYI2LnwfIMTSVN4T92Yy77SmE8xPydcdkgUaFxhK16qCGXMV3mF/VFx67LpZm8Sw3v135hxYX8wG1tCBKlL4psJF4+9vSy4W+8R5ieeqhrvRH+2MKLiKbDnewzKonFLbn2aKNrJefXYY7klaawIDAQAB";
        $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";
        // echo $public_key;
        // exit();
        $key_resource = openssl_get_publickey($public_key);
        openssl_public_encrypt($data, $cryptText, $key_resource);
        return base64_encode($cryptText);
    }

    function SignatureGenerate($data)
    {
        $merchantPrivateKey = "MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCPprwss0hzyUiINgdXbNUyVQ/9CRa4o3p5oObMYiyX40R2tiZef7bVDtc2JIOfR2QbRJXSq+VRF7YNTIrDNfZRyNjpg5x4qoDifiji77WeKcWPiLIs7fLDBVvy4Y9HYIaeUtcOBgAHIpcfTxW8e0+j8U97rVbHipY5cCmEaC/gRrWH4MpiDzNuv4jZrf40+gxWiBevqZqhwVHekPG0O7kV/2VuLTnQI+oRPIn1qsDYNPLHNVKSyc0OCiCWXFffAOXI0l2NmHZ7HS3/XjDWfliv+5Bm4IosUqxeOgtrKFUQc/swJrpKokbVojrfLwQNaYthz8RkZg4quDZCZ3OGpzkZAgMBAAECggEATRd7FzYj5NeZ0FfGetmSVM+no/ETu4UoPkvmcLsjGWRDIr5AOyipExBC2PChnoIurB+TlBriFzH1Zo+0TG0SQvPZzP/voiZGwsZX5Ool+rqKJqyCinAsfxLKNL9uKC0aMa9dcE4yB6I9nfTQQnWe2Omw8TumPbIXSr3x2fgb8WzSGauEY8HmAs2lVVFalCdmr1BhnrbLrQ2Ie7JKtRDDcJylL+ozDdhBIlwkbk4l3a3CgX0l6Nv9oUWaqD0hqcWFRx/ac/DCj3QIBDu8TlIJBqryYXfhUD83BReXFDDY34zPfFlld/ReJq5By9YNE1FCihBGHb5W8qO7BUwUGFqrMQKBgQDVAInJMbjeDCO/XLHS6xn4p3Br2LI9ucQ57A8Blwos1lz7VSknXZaeD7jWsBsAiT9tXMMFrhPOZ8Lx7K5grf9LM8z2oW2ev9AoReoDXqG1DdbKRYEIvUoe8Vb6oyY2OvMs/P1X93626xIWIH2wiCUhONee0RR4StVU167iVybSFQKBgQCspk5sLx6d2Ni89Fu/LIrM79Q2Z3Im8zuVszw6BuF+JZ6hh0VtjhAyl2c4XCSoeMzGBRt6Eof9WD+ZLkjuKqD2v3Ze9C3/fmcbG34lQeUaEVGu7hex/xcOl2IMhlrPrMuo29yLPkHoChduASud4nYqcm9R7LK3CVzd/Qelydk/9QKBgQCKPkIvMbVBcHGXFqtXMD138/x0En2EsFfaHAqVRplVBn/so5YFNam2xo95z2yHCY0ABs+QlS3HrfKJn8qBdwyVm3YwsA78lJOeP9ok+7tKTkQUnc2khW5g7NQ98buwQMxpa31mJXy5bZIciFPrSkGG8WSIcDyv4inZWe7oehX5DQKBgQCGm0MZZcNhHegdqga+DmRJU9MId66wX4NdO9kBBMxaJcp/9Y9T0ycdyp1Xe7+4+jXtTZ4Wlswf4eXz7/o8dk/5EV2gupACWvLYV58KPU35/PbKhCdFR7UaUzzGtxmmQPqoNILGrUuFNhj+UztGZYHrpjzUis7rlgkpqlWEFNOk4QKBgQCcTvckkTS2FrkXry7VbEjrH1fNy6LNyA4f0cCz7o2b0Smia/QJtM9nzDUMurmFhmtR2d9yZSGxkiaPWXFCrzvFU1RxZ62To5SG8CrJn+ixIYtMqmp2xQMFv87D4BOYMo3qeAU5jRUKzmvn/OaVP6nWfoaMPqR6piK798aH0VD/0g==";

        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        // echo $private_key;
        // exit();
        openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    function HttpPostMethod($PostURL, $PostData)
    {
        $url = curl_init($PostURL);
        $postToken = json_encode($PostData);
        $header = array(
            'Content-Type:application/json',
            'X-KM-Api-Version:v-0.2.0',
            'X-KM-IP-V4:' . $this->get_client_ip(),
            'X-KM-Client-Type:PC_WEB'
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($url, CURLOPT_HEADER, 1);

        $resultData = curl_exec($url);
        $ResultArray = json_decode($resultData, true);
        $header_size = curl_getinfo($url, CURLINFO_HEADER_SIZE);
        curl_close($url);
        $headers = substr($resultData, 0, $header_size);
        $body = substr($resultData, $header_size);
        print_r($body);
        print_r($headers);
        return $ResultArray;

    }

    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function DecryptDataWithPrivateKey($cryptText)
    {
        $merchantPrivateKey = "MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCPprwss0hzyUiINgdXbNUyVQ/9CRa4o3p5oObMYiyX40R2tiZef7bVDtc2JIOfR2QbRJXSq+VRF7YNTIrDNfZRyNjpg5x4qoDifiji77WeKcWPiLIs7fLDBVvy4Y9HYIaeUtcOBgAHIpcfTxW8e0+j8U97rVbHipY5cCmEaC/gRrWH4MpiDzNuv4jZrf40+gxWiBevqZqhwVHekPG0O7kV/2VuLTnQI+oRPIn1qsDYNPLHNVKSyc0OCiCWXFffAOXI0l2NmHZ7HS3/XjDWfliv+5Bm4IosUqxeOgtrKFUQc/swJrpKokbVojrfLwQNaYthz8RkZg4quDZCZ3OGpzkZAgMBAAECggEATRd7FzYj5NeZ0FfGetmSVM+no/ETu4UoPkvmcLsjGWRDIr5AOyipExBC2PChnoIurB+TlBriFzH1Zo+0TG0SQvPZzP/voiZGwsZX5Ool+rqKJqyCinAsfxLKNL9uKC0aMa9dcE4yB6I9nfTQQnWe2Omw8TumPbIXSr3x2fgb8WzSGauEY8HmAs2lVVFalCdmr1BhnrbLrQ2Ie7JKtRDDcJylL+ozDdhBIlwkbk4l3a3CgX0l6Nv9oUWaqD0hqcWFRx/ac/DCj3QIBDu8TlIJBqryYXfhUD83BReXFDDY34zPfFlld/ReJq5By9YNE1FCihBGHb5W8qO7BUwUGFqrMQKBgQDVAInJMbjeDCO/XLHS6xn4p3Br2LI9ucQ57A8Blwos1lz7VSknXZaeD7jWsBsAiT9tXMMFrhPOZ8Lx7K5grf9LM8z2oW2ev9AoReoDXqG1DdbKRYEIvUoe8Vb6oyY2OvMs/P1X93626xIWIH2wiCUhONee0RR4StVU167iVybSFQKBgQCspk5sLx6d2Ni89Fu/LIrM79Q2Z3Im8zuVszw6BuF+JZ6hh0VtjhAyl2c4XCSoeMzGBRt6Eof9WD+ZLkjuKqD2v3Ze9C3/fmcbG34lQeUaEVGu7hex/xcOl2IMhlrPrMuo29yLPkHoChduASud4nYqcm9R7LK3CVzd/Qelydk/9QKBgQCKPkIvMbVBcHGXFqtXMD138/x0En2EsFfaHAqVRplVBn/so5YFNam2xo95z2yHCY0ABs+QlS3HrfKJn8qBdwyVm3YwsA78lJOeP9ok+7tKTkQUnc2khW5g7NQ98buwQMxpa31mJXy5bZIciFPrSkGG8WSIcDyv4inZWe7oehX5DQKBgQCGm0MZZcNhHegdqga+DmRJU9MId66wX4NdO9kBBMxaJcp/9Y9T0ycdyp1Xe7+4+jXtTZ4Wlswf4eXz7/o8dk/5EV2gupACWvLYV58KPU35/PbKhCdFR7UaUzzGtxmmQPqoNILGrUuFNhj+UztGZYHrpjzUis7rlgkpqlWEFNOk4QKBgQCcTvckkTS2FrkXry7VbEjrH1fNy6LNyA4f0cCz7o2b0Smia/QJtM9nzDUMurmFhmtR2d9yZSGxkiaPWXFCrzvFU1RxZ62To5SG8CrJn+ixIYtMqmp2xQMFv87D4BOYMo3qeAU5jRUKzmvn/OaVP6nWfoaMPqR6piK798aH0VD/0g==";
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        openssl_private_decrypt(base64_decode($cryptText), $plain_text, $private_key);
        return $plain_text;
    }

    public function nagadPayment(){
        date_default_timezone_set('Asia/Dhaka');
        $payment_data = Session::get('payment_data');
        $order = Order::where('order_id', $payment_data['order_id'])->first();
        if(!Session::has('payment_data')  && !$order){
            Toastr::error('Payment failed something went wrong.');
            return redirect()->back();
        }

        $total_price = $order->total_price + $order->shipping_cost - $order->coupon_discount;
        $order_id = $payment_data['order_id'];
        $random_invoice = rand(100, 999);
        $MerchantID = "683161003265331";
        $DateTime = Date('YmdHis');
        $amount = $total_price;
        $OrderId = $random_invoice.'NI'.$payment_data['order_id'];
        $random = $this->generateRandomString();

        $PostURL = "https://api.mynagad.com/api/dfs/check-out/initialize/" . $MerchantID . "/" . $OrderId;

        $merchantCallbackURL = route('nagadPaymentSuccess');

        $SensitiveData = array(
            'merchantId' => $MerchantID,
            'datetime' => $DateTime,
            'orderId' => $OrderId,
            'challenge' => $random
        );

        $PostData = array(
            'accountNumber' => "01316100326", //Replace with Merchant Number
            'dateTime' => $DateTime,
            'sensitiveData' => $this->EncryptDataWithPublicKey(json_encode($SensitiveData)),
            'signature' =>  $this->SignatureGenerate(json_encode($SensitiveData))
        );

        $Result_Data = $this->HttpPostMethod($PostURL, $PostData);

        if (isset($Result_Data['sensitiveData']) && isset($Result_Data['signature'])) {
            if ($Result_Data['sensitiveData'] != "" && $Result_Data['signature'] != "") {

                $PlainResponse = json_decode($this->DecryptDataWithPrivateKey($Result_Data['sensitiveData']), true);

                if (isset($PlainResponse['paymentReferenceId']) && isset($PlainResponse['challenge'])) {

                    $paymentReferenceId = $PlainResponse['paymentReferenceId'];
                    $randomServer = $PlainResponse['challenge'];

                    $SensitiveDataOrder = array(
                        'merchantId' => $MerchantID,
                        'orderId' => $OrderId,
                        'currencyCode' => '050',
                        'amount' => $amount,
                        'challenge' => $randomServer
                    );

                    // print_r($SensitiveDataOrder);
                    // exit;

                    $merchantAdditionalInfo = '{"Service Name": "woadi.com"}';

                    $PostDataOrder = array(
                        'sensitiveData' => $this->EncryptDataWithPublicKey(json_encode($SensitiveDataOrder)),
                        'signature' => $this->SignatureGenerate(json_encode($SensitiveDataOrder)),
                        'merchantCallbackURL' => $merchantCallbackURL,
                        'additionalMerchantInfo' => json_decode($merchantAdditionalInfo)
                    );

                    //             print_r($SensitiveDataOrder);
                    // echo "<br>";
                    // print_r($PostDataOrder);
                    // echo "<br>";
                    // exit;
                    $OrderSubmitUrl = "https://api.mynagad.com/api/dfs/check-out/complete/" . $paymentReferenceId;
                    $Result_Data_Order =  $this->HttpPostMethod($OrderSubmitUrl, $PostDataOrder);

                    // echo json_encode($Result_Data_Order);

                    if ($Result_Data_Order['status'] == "Success") {
                        $url = json_encode($Result_Data_Order['callBackUrl']);
                        echo "<script>window.open($url, '_self')</script>";
                    }
                    else {
                        echo json_encode($Result_Data_Order);
                    }
                } else {
                    echo json_encode($PlainResponse);
                }
            }
        }
    }

    function HttpGet($url)
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $file_contents = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $file_contents;
    }

    public function paymentSuccess(){
        try{
            $Query_String  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1] );
            $payment_ref_id = substr($Query_String[2], 15);
            $url = "https://api.mynagad.com/api/dfs/verify/payment/".$payment_ref_id;
            $json = $this->HttpGet($url);
            $arr = json_decode($json, true);
            //return json_encode($arr);

            if(isset($arr['status']) && $arr['status'] == 'Success') {
                //after payment success update payment status
                $tran_id = $arr['orderId'];
                $tran_id = explode('NI', trim($tran_id))[1];

                $data = [
                    'order_id' => $tran_id,
                    'trnx_id' => $arr['orderId'],
                    'payment_status' => 'paid',
                    'payment_info' => 'Account:'. $arr['clientMobileNo'] . ' ,txId:' . $arr['issuerPaymentRefNo'],
                    'payment_method' => 'nagad',
                    'status' => 'success'
                ];
                Session::put('payment_data', $data);

                //check whether offer order
                $make_array = (explode('K', $tran_id));
                if(count($make_array)>1){
                    $offerPayment = new OfferController();
                    return $offerPayment->offerPrizeSelect();
                }

                $paymentController = new PaymentController();
                //redirect payment success method
                return $paymentController->paymentSuccess();
            } else {
                Toastr::error('Payment failed');
                $payment_data = Session::get('payment_data');
                if ($payment_data) {
                    $make_array = (explode('K', $payment_data['order_id']));
                    if(count($make_array)>1){
                        if(Session::has('redirectLink')){
                            return redirect(Session::get('redirectLink'));
                        }
                        return Redirect::route('offers');
                    }
                    return Redirect::route('order.paymentGateway', $payment_data['order_id']);
                }
                return redirect('/');
            }
        }catch (\Mockery\Exception $exception){
            Toastr::error('Payment failed');
            return redirect('/');
        }
    }
}
