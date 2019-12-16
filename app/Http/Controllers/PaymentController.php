<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function register(){
        header("Content-Type:application/json");
        /* put your shortcode number here */
        $shortcodenumber='600512';
        /* put your consumer Key here */
        $consumerkey ="IuGPc3yiImZLHzfDOQHeHJSG1DV3q6G3";
        /* put your consumer Secret here */
        $consumersecret ="GB3jLBDqsfeZyBvm";
        /* put your Validation URL here */
        $validationurl="http://cda4c2b3.ngrok.io/api/paymentsValidate";
        /* put your Comfirmation URL here */
        $confirmationurl="http://cda4c2b3.ngrok.io/api/paymentsConfirm";
        $authenticationurl='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $registerurl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        /* production un-comment the below two lines if you are in production */
        //$authenticationurl='https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        //$registerurl = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $credentials= base64_encode($consumerkey.':'.$consumersecret);
        $username=$consumerkey ;
        $password=$consumersecret;
        // Request headers
        $headers = array(
        'Content-Type: application/json; charset=utf-8'
        );
        // Request
        $ch = curl_init($authenticationurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
        curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); // HTTP Basic Authentication
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token=$result->access_token;
        print_r($access_token);
        curl_close($ch);
        //Register urls
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $registerurl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));
        $curl_post_data = array(
        //Fill in the request parameters with valid values
        'ShortCode' => $shortcodenumber,
        'ResponseType' => 'Cancelled',
        'ConfirmationURL' => $confirmationurl,
        'ValidationURL' => $validationurl
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }
    public function confirmPayment(){
        try
        {
            //Set the response content type to application/json
            header("Content-Type:application/json");
            $resp = '{"ResultCode":0,"ResultDesc":"Confirmation recieved successfully"}';
            //read incoming request
            $postData = file_get_contents('php://input');
            //log file
            $filePath = "\opt\appLogs\messages.log";
            //error log
            $errorLog = "\opt\appLogs\errors.log";
            //Parse payload to json
            $jdata = json_decode($postData,true);
            //perform business operations on $jdata here
            //open text file for logging messages by appending
            $file = fopen($filePath,"a");
            //log incoming request
            fwrite($file, $postData);
            fwrite($file,"\r\n");
            //log response and close file
            fwrite($file,$resp);
            fclose($file);
        } catch (Exception $ex){
            //append exception to errorLog
            $logErr = fopen($errorLog,"a");
            fwrite($logErr, $ex->getMessage());
            fwrite($logErr,"\r\n");
            fclose($logErr);
        }
            //echo response
            echo $resp;
    }

    public function validatePayment(){
        try
        {
            //Set the response content type to application/json
            header("Content-Type:application/json");
            $resp = '{"ResultCode":0,"ResultDesc":"Validation passed successfully"}';
            //read incoming request
            $postData = file_get_contents('php://input');
            $filePath = "\opt\appLogs\messages.log";
            //error log
            $errorLog = "\opt\appLogs\errors.log";
            //Parse payload to json
            $jdata = json_decode($postData,true);
            //perform business operations here
            //open text file for logging messages by appending
            $file = fopen($filePath,"a");
            //log incoming request
            fwrite($file, $postData);
            fwrite($file,"\r\n");
        } catch (Exception $ex){
            //append exception to file
            $logErr = fopen($errorLog,"a");
            fwrite($logErr, $ex->getMessage());
            fwrite($logErr,"\r\n");
            fclose($logErr);
            //set failure response
            $resp = '{"ResultCode": 1, "ResultDesc":"Validation failure due to internal service error"}';
        }
            //log response and close file
            fwrite($file,$resp);
            fclose($file);
            //echo response
            echo $resp;        
    }
}
