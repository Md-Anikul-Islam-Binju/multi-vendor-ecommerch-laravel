<?php
namespace App\Traits;


use App\Models\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait Sms
{
    function sendSms($contact,$msg) {

        $url = "http://portal.metrotel.com.bd/smsapi";
        $data = [
            "api_key" => env('METROBD_API_KEY'),
            "type" => "text",
            "contacts" => $contact,
            "senderid" => env('METROBD_SENDER_ID'),
            "msg" => $msg,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function systemMessage(string $number, string $message): string
    {
        $url = "http://api.icombd.com/api/v1/campaigns/sendsms/plain?username=redsoft&password=redsoft@167&sender=03590003131&text=".urlencode($message)."&to=+88".$number;
        $response = Http::get($url);

        Toastr::success($response->body());
        if ($response->ok())
        {
            return $response->body();

        }
        return $response->status()." || ".$response->clientError(). " || ". $response->serverError();

    }
}




