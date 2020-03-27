<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class RegistrationSent extends Mailable
{
	use Queueable, SerializesModels;

	public $name;
	public $login;
	public $email;
	public $password;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 *
	 * @param array		$fields;
	 * @param string	$role;
	 */

	public function __construct($fields)
	{
		$this->name		= $fields['name'];
		$this->login	= $fields['login'];
		$this->email	= $fields['email'];
		$this->password	= $fields['password'];
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */

	public function build()
	{
		return $this
			->subject(
				trans('email.site.registration.subject', [
					'login' => $this->login,
				])
			)
			->view('email.site.registration.' . config('app.locale') . '.sent')
		;
	}
}
