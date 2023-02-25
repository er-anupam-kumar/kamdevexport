<?php 
namespace App\CustomClasses;

use Mail;
use App\CustomClasses\SandEmail as Email;

class EmailProvider extends Email
{
	public static function emailSlugs()
	{
		// Keys are fixed 					# Changable
		return [		
			'user-credentials-details-mail'		=> 'user-credentials-details-mail',
			'new-order-mail'		   			=> 'new-order-mail',
			'forgot-password-mail'		   		=> 'forgot-password-mail',
			'client-new-order-mail'		   	    => 'client-new-order-mail',
			'payment-confirmation-mail'		   	=> 'payment-confirmation-mail',
			'order-status-update-mail'		   	=> 'order-status-update-mail',
		];
	}

	public static function sendMail($slug, $input = array())
	{
		$callback = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $slug))));
		
		if(method_exists(get_class(), $callback)){
			self::$callback(self::getSlug($slug), $input);
		}else{
			parent::send($slug, $input);
		}
	}

	public static function getSlug($key)
	{
		return self::emailSlugs()[$key];
	}

	private static function userWelcomeMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userProfileApprovalMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	/*
	* resetPasswordMail send reset password mail
	* params string $slug, array $input
	*/
	private static function userProfileRejectedMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userCredentialsDetailMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function forgotPasswordMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function registrationRequestMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
		
	private static function newProductMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
	private static function orderConfirmationMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}private static function paymentConfirmationMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}private static function orderReceivedMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}private static function orderApprovalMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}private static function orderStatusMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
	private static function dispatchDetailsMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
}