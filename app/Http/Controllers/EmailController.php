<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function sendemail(Request $request){
     /*   try{
           
        }
        catch(Exception $ex){
            Log::error('Exception: ' . $ex->getMessage());    dd($ex->getMessage());
          //  return response()->json(['status'=>'error','message'=>'Unexpected error occured.'],500);
        }
       */

       $data = json_decode($request->input('formdata'));
       $subject = "Reminder on ".Carbon::now()->format('jS M Y').": Restock Needed for Inventory Items";
       $recipient = "joeasewe@gmail.com";
       $status = Mail::send('mail.newemail',['data'=>$data],
       function($message) use ($recipient, $subject){
           $message->to($recipient,'')
           ->subject($subject);
           }
       );
       if(!$status){
           return response()->json(['status'=>'error','message'=>'Request not sent.'],500);
       }
       return response()->json(['status'=>'success','message'=>'Request sent'],200);

       
    }
}
