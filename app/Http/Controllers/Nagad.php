<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\PaymentController;
use App\Models\PaymentGateway;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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
class Nagad extends Controller
{
    protected $nagad_public_key;
    protected $nagad_secret_key;
    protected $merchant_id;
    protected $merchant_number;

function __construct(){
	//set nagad API credentials
    $paymentCredentials = PaymentGateway::where('method_slug', 'nagad')->where('status', 1)->first();

    if($paymentCredentials){
	    $this->nagad_public_key = $paymentCredentials->public_key;
	    $this->nagad_secret_key = $paymentCredentials->secret_key;
	    $this->merchant_number = $paymentCredentials->merchant_number;
	    $this->merchant_id = $paymentCredentials->merchant_id;
	}else{
		Toastr::error('Payment failed something went wrong.');
        return redirect()->back();
	}

}
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
    $pgPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjBH1pFNSSRKPuMcNxmU5jZ1x8K9LPFM4XSu11m7uCfLUSE4SEjL30w3ockFvwAcuJffCUwtSpbjr34cSTD7EFG1Jqk9Gg0fQCKvPaU54jjMJoP2toR9fGmQV7y9fz31UVxSk97AqWZZLJBT2lmv76AgpVV0k0xtb/0VIv8pd/j6TIz9SFfsTQOugHkhyRzzhvZisiKzOAAWNX8RMpG+iqQi4p9W9VrmmiCfFDmLFnMrwhncnMsvlXB8QSJCq2irrx3HG0SJJCbS5+atz+E1iqO8QaPJ05snxv82Mf4NlZ4gZK0Pq/VvJ20lSkR+0nk+s/v3BgIyle78wjZP1vWLU4wIDAQAB";
    $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";
    // echo $public_key;
    // exit();
    $key_resource = openssl_get_publickey($public_key);
    openssl_public_encrypt($data, $cryptText, $key_resource);
    return base64_encode($cryptText);
}

function SignatureGenerate($data)
{
    $merchantPrivateKey = "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCJakyLqojWTDAVUdNJLvuXhROV+LXymqnukBrmiWwTYnJYm9r5cKHj1hYQRhU5eiy6NmFVJqJtwpxyyDSCWSoSmIQMoO2KjYyB5cDajRF45v1GmSeyiIn0hl55qM8ohJGjXQVPfXiqEB5c5REJ8Toy83gzGE3ApmLipoegnwMkewsTNDbe5xZdxN1qfKiRiCL720FtQfIwPDp9ZqbG2OQbdyZUB8I08irKJ0x/psM4SjXasglHBK5G1DX7BmwcB/PRbC0cHYy3pXDmLI8pZl1NehLzbav0Y4fP4MdnpQnfzZJdpaGVE0oI15lq+KZ0tbllNcS+/4MSwW+afvOw9bazAgMBAAECggEAIkenUsw3GKam9BqWh9I1p0Xmbeo+kYftznqai1pK4McVWW9//+wOJsU4edTR5KXK1KVOQKzDpnf/CU9SchYGPd9YScI3n/HR1HHZW2wHqM6O7na0hYA0UhDXLqhjDWuM3WEOOxdE67/bozbtujo4V4+PM8fjVaTsVDhQ60vfv9CnJJ7dLnhqcoovidOwZTHwG+pQtAwbX0ICgKSrc0elv8ZtfwlEvgIrtSiLAO1/CAf+uReUXyBCZhS4Xl7LroKZGiZ80/JE5mc67V/yImVKHBe0aZwgDHgtHh63/50/cAyuUfKyreAH0VLEwy54UCGramPQqYlIReMEbi6U4GC5AQKBgQDfDnHCH1rBvBWfkxPivl/yNKmENBkVikGWBwHNA3wVQ+xZ1Oqmjw3zuHY0xOH0GtK8l3Jy5dRL4DYlwB1qgd/Cxh0mmOv7/C3SviRk7W6FKqdpJLyaE/bqI9AmRCZBpX2PMje6Mm8QHp6+1QpPnN/SenOvoQg/WWYM1DNXUJsfMwKBgQCdtddE7A5IBvgZX2o9vTLZY/3KVuHgJm9dQNbfvtXw+IQfwssPqjrvoU6hPBWHbCZl6FCl2tRh/QfYR/N7H2PvRFfbbeWHw9+xwFP1pdgMug4cTAt4rkRJRLjEnZCNvSMVHrri+fAgpv296nOhwmY/qw5Smi9rMkRY6BoNCiEKgQKBgAaRnFQFLF0MNu7OHAXPaW/ukRdtmVeDDM9oQWtSMPNHXsx+crKY/+YvhnujWKwhphcbtqkfj5L0dWPDNpqOXJKV1wHt+vUexhKwus2mGF0flnKIPG2lLN5UU6rs0tuYDgyLhAyds5ub6zzfdUBG9Gh0ZrfDXETRUyoJjcGChC71AoGAfmSciL0SWQFU1qjUcXRvCzCK1h25WrYS7E6pppm/xia1ZOrtaLmKEEBbzvZjXqv7PhLoh3OQYJO0NM69QMCQi9JfAxnZKWx+m2tDHozyUIjQBDehve8UBRBRcCnDDwU015lQN9YNb23Fz+3VDB/LaF1D1kmBlUys3//r2OV0Q4ECgYBnpo6ZFmrHvV9IMIGjP7XIlVa1uiMCt41FVyINB9SJnamGGauW/pyENvEVh+ueuthSg37e/l0Xu0nm/XGqyKCqkAfBbL2Uj/j5FyDFrpF27PkANDo99CdqL5A4NQzZ69QRlCQ4wnNCq6GsYy2WEJyU2D+K8EBSQcwLsrI7QL7fvQ==";
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
    $merchantPrivateKey = "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCJakyLqojWTDAVUdNJLvuXhROV+LXymqnukBrmiWwTYnJYm9r5cKHj1hYQRhU5eiy6NmFVJqJtwpxyyDSCWSoSmIQMoO2KjYyB5cDajRF45v1GmSeyiIn0hl55qM8ohJGjXQVPfXiqEB5c5REJ8Toy83gzGE3ApmLipoegnwMkewsTNDbe5xZdxN1qfKiRiCL720FtQfIwPDp9ZqbG2OQbdyZUB8I08irKJ0x/psM4SjXasglHBK5G1DX7BmwcB/PRbC0cHYy3pXDmLI8pZl1NehLzbav0Y4fP4MdnpQnfzZJdpaGVE0oI15lq+KZ0tbllNcS+/4MSwW+afvOw9bazAgMBAAECggEAIkenUsw3GKam9BqWh9I1p0Xmbeo+kYftznqai1pK4McVWW9//+wOJsU4edTR5KXK1KVOQKzDpnf/CU9SchYGPd9YScI3n/HR1HHZW2wHqM6O7na0hYA0UhDXLqhjDWuM3WEOOxdE67/bozbtujo4V4+PM8fjVaTsVDhQ60vfv9CnJJ7dLnhqcoovidOwZTHwG+pQtAwbX0ICgKSrc0elv8ZtfwlEvgIrtSiLAO1/CAf+uReUXyBCZhS4Xl7LroKZGiZ80/JE5mc67V/yImVKHBe0aZwgDHgtHh63/50/cAyuUfKyreAH0VLEwy54UCGramPQqYlIReMEbi6U4GC5AQKBgQDfDnHCH1rBvBWfkxPivl/yNKmENBkVikGWBwHNA3wVQ+xZ1Oqmjw3zuHY0xOH0GtK8l3Jy5dRL4DYlwB1qgd/Cxh0mmOv7/C3SviRk7W6FKqdpJLyaE/bqI9AmRCZBpX2PMje6Mm8QHp6+1QpPnN/SenOvoQg/WWYM1DNXUJsfMwKBgQCdtddE7A5IBvgZX2o9vTLZY/3KVuHgJm9dQNbfvtXw+IQfwssPqjrvoU6hPBWHbCZl6FCl2tRh/QfYR/N7H2PvRFfbbeWHw9+xwFP1pdgMug4cTAt4rkRJRLjEnZCNvSMVHrri+fAgpv296nOhwmY/qw5Smi9rMkRY6BoNCiEKgQKBgAaRnFQFLF0MNu7OHAXPaW/ukRdtmVeDDM9oQWtSMPNHXsx+crKY/+YvhnujWKwhphcbtqkfj5L0dWPDNpqOXJKV1wHt+vUexhKwus2mGF0flnKIPG2lLN5UU6rs0tuYDgyLhAyds5ub6zzfdUBG9Gh0ZrfDXETRUyoJjcGChC71AoGAfmSciL0SWQFU1qjUcXRvCzCK1h25WrYS7E6pppm/xia1ZOrtaLmKEEBbzvZjXqv7PhLoh3OQYJO0NM69QMCQi9JfAxnZKWx+m2tDHozyUIjQBDehve8UBRBRcCnDDwU015lQN9YNb23Fz+3VDB/LaF1D1kmBlUys3//r2OV0Q4ECgYBnpo6ZFmrHvV9IMIGjP7XIlVa1uiMCt41FVyINB9SJnamGGauW/pyENvEVh+ueuthSg37e/l0Xu0nm/XGqyKCqkAfBbL2Uj/j5FyDFrpF27PkANDo99CdqL5A4NQzZ69QRlCQ4wnNCq6GsYy2WEJyU2D+K8EBSQcwLsrI7QL7fvQ==";
    $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
    openssl_private_decrypt(base64_decode($cryptText), $plain_text, $private_key);
    return $plain_text;
}

public function nagadPayment(){

	date_default_timezone_set('Asia/Dhaka');

    $payment_data = Session::get('payment_data');

    if(!Session::has('payment_data')){
    	Toastr::error('Payment failed something went wrong.');
        return redirect()->back();
    }

    if(Session::has('offer_id')) {
        $total_price = $payment_data['total_price'];
        $order_id = $payment_data['order_id'];
    }else{
        $total_price = $payment_data['total_price'];
        $order_id = $payment_data['order_id'];
    }

    $MerchantID = "683002007104225";
	$DateTime = Date('YmdHis');
	$amount = $total_price;
	$OrderId = 'TEST'.strtotime("now").rand(1000, 10000);
	$random = $this->generateRandomString();

	$PostURL = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/check-out/initialize/" . $MerchantID . "/" . $OrderId;


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
	            $OrderSubmitUrl = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/check-out/complete/" . $paymentReferenceId;
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
        $url = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/verify/payment/".$payment_ref_id;

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
