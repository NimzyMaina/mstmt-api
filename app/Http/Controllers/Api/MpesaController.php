<?php

namespace App\Http\Controllers\Api;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Safaricom\Mpesa\Mpesa;

class MpesaController extends Controller
{
    public function stk(Request $request,Mpesa $mpesa)
    {
        $this->val($request->all(),[
            'phone' => 'required',
            'amount' => 'required',
            'description' => 'required'
        ]);

        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $Amount = $request->amount;
        $PartyA = full_phone($request->phone);
        $PartyB = '174379';
        $PhoneNumber = $PartyA;
        $CallBackURL = url('v1/callback');
        $AccountReference = 'boo-boo';
        $TransactionDesc = $request->deescription;
        $Remarks = 'Just testing';


        $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode,
            $LipaNaMpesaPasskey, 'CustomerPayBillOnline', $Amount,
            $PartyA, $PartyB, $PhoneNumber, $CallBackURL,
            $AccountReference, $TransactionDesc, $Remarks);

        return($stkPushSimulation);
    }

    public function callBack(Request $request,Mpesa $mpesa)
    {
        Log::info("MPESA: ",$request->all());

        $result = json_decode($request->getContent());
        if (!property_exists($result, "Body")) {
            //NOT from Safaricom
            return $this->respond("Invalid content",400);
        }

        $stkCallback = $result->Body->stkCallback;
        $ResultCode = $stkCallback->ResultCode;
        $ResultDesc = $stkCallback->ResultDesc;
        if($ResultCode == 0){
            $Status = 'COMPLETE';
        }
        elseif ($ResultCode == 1032)
        {
            $Status = 'CANCELED';
        }
        else{
            $Status = 'PENDING';
        }

        $transaction = new Transaction([
            'result_code' => $ResultCode,
            'result_desc' => $ResultDesc,
            'status' => $Status
        ]);

        if ((!property_exists($stkCallback, "CallbackMetadata"))) {
            $transaction->save();
            $mpesa->finishTransaction();
        }

        $Item = $stkCallback->CallbackMetadata->Item;

        //Wtf Safaricom! This should be an object not array :(
        foreach ($Item as $key => $value) {
            $Name = $value->Name;
            if (property_exists($value, "Value")) {
                $Value = $value->Value;
                if (strcasecmp($Name, "Amount") == 0) {
                    $transaction->amount = $Value;
                }
                if (strcasecmp($Name, "MpesaReceiptNumber") == 0) {
                    $transaction->mpesa_receipt_number = $Value;
                }
                if (strcasecmp($Name, "Balance") == 0) {
                    $transaction->balance = $Value;
                }
                if (strcasecmp($Name, "TransactionDate") == 0) {
                    $year = substr($Value, 0, 4);
                    $month = substr($Value, 4, 2);
                    $day = substr($Value, 6, 2);
                    $hour = substr($Value, 8, 2);
                    $minute = substr($Value, 10, 2);
                    $second = substr($Value, 12, 2);
                    $transaction->transaction_date = Carbon::create($year, $month, $day, $hour, $minute, $second, 'Africa/Nairobi');
                }
                if (strcasecmp($Name, "PhoneNumber") == 0) {
                    $transaction->phone_number = (string)$Value;
                }
            }
        }
        $transaction->save();

        sms($transaction->phone_number,"Dear Member, we have received your transaction. {$transaction->mpesa_receipt_number} of amount KES ".number_format($transaction->amount,2).". Thank you for using our service.");

        return $mpesa->finishTransaction();
    }

    public function registerUrl(Request $request)
    {

    }

}
