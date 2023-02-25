<?php

use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validations as CustomValidations;

if (! function_exists('getRule')) {
	function getRule($name, $required = false, $nullable = false) 
	{
		return CustomValidations::getRule($name, $required, $nullable);
	}
}

if (! function_exists('sendEmail')) {
	function sendEmail($input) 
	{	
		$email_body = 'You login password for '.env('APP_NAME').' is '.$input['password'].'.';
		$email_subject = 'Password change on '.env('APP_NAME').'.';

		Mail::send('emails.email', ['email_body' => $email_body], function($message) use ($email_subject, $input) {
			$message->to($input['email'], env('APP_NAME'))
			->subject($email_subject);
		});

		return true;
	}
}

if (! function_exists('sendGenuineEmail')) {
	function sendGenuineEmail($input) 
	{	
		$email_body = $input['email_body'];
		$email_subject = $input['email_subject'];

		Mail::send('emails.email', ['email_body' => $email_body], function($message) use ($email_subject, $input) {
			$message->to($input['email']??env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
			->subject($email_subject);
		});

		return true;
	}
}

if (! function_exists('getDateWithFormat')) {
	function getDateWithFormat($date) 
	{	
		// return date('M d, Y H:i:s A',strtotime($date));
		return date('M d, Y',strtotime($date));
	}
}

if (! function_exists('userStatusText')) {
	function userStatusText($status) 
	{	
		switch($status){

			case '0':
			$text = 'Pending';
			break;

			case '1':
			$text = 'Active';
			break;

			case '2':
			$text = 'Blocked';
			break;

			case '3':
			$text = 'Inactive';
			break;

			default:
			$text = 'Pending';

		}

		return $text;
	}
}

if (! function_exists('paymentGateways')){
	function paymentGateways(){

		$result = [
			"Razorpay"
		];

		return $result;
	}
}