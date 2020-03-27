<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Morph;
use Storage;
use App\User;
use App\Http\Controllers\Site\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Events\Registered;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */

	protected $redirectTo = '';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct()
	{
		parent::__construct();

		$this->redirectTo = route('account.dashboard.index');
		$this->middleware('guest');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function social()
	{
		return view('auth.social');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		if ($request->has('social'))
			$request->merge([
				'password'				=> $password = Str::random(6),
				'password_confirmation'	=> $password,
			]);

		$data = [
			'name'					=> $request->name,
			'login'					=> $request->login,
			'email'					=> $request->email,
			'password'				=> $request->password,
			'password_confirmation'	=> $request->password_confirmation,
			'social'				=> $request->social,
			'socialaccount_id'		=> $request->id,
			'avatar'				=> $request->avatar,
		];

		$validator = $this->validator($data);

		if ($validator->fails())
			return redirect($request->has('social') ? 'register/social' : 'register')
				->withInput($data)
				->withErrors($validator)
			;

		$user = $this->create($data);

		event(
			new Registered(array_merge($data, [
				'user_id' => $user->id,
			]))
		);

		$this->guard()->login($user);

		return $this->registered($request, $user)
						?: redirect($this->redirectPath());
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */

	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name'		=> 'nullable|min:2|max:255',
			'login'		=> 'required|min:2|max:255|login|unique:users,login',
			'email'		=> 'required|email|min:3|max:255|unique:users,email',
			'password'	=> 'required|string|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */

	protected function create(array $data)
	{
		$user = new \App\User;
		$role = \App\Role::where('slug', 'customer')->first();

		$user->role_id		= $role->id;
		$user->email		= $data['email'];
		$user->password		= bcrypt($data['password']);
		$user->name			= $data['name'];
		$user->login		= $data['login'];
		$user->balance		= config('register.bonus');
		$user->visited_at	= now();

		$user->save();

		if (!is_null($data['avatar'])) {
			$pathinfo = pathinfo(
				  parse_url($data['avatar'], PHP_URL_SCHEME) . '://'
				. parse_url($data['avatar'], PHP_URL_HOST)
				. parse_url($data['avatar'], PHP_URL_PATH)
			);
			$filename = str_slug($user->id . ' ' . $pathinfo['filename'], '_') . '.' . ($pathinfo['extension'] ?? null);

			Storage::disk('public')->put('users/' . $filename, file_get_contents($data['avatar']));

			$user->avatar = $filename;
			$user->save();
		}

		return $user;
	}
}
