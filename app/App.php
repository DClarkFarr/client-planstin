<?php

namespace App;

use Illuminate\Foundation\Application as IlluminateFoundationApplication;
use App\Exceptions\SalesforceException;

class App extends IlluminateFoundationApplication{
	private static $request;
	private static $controller;

	private static $salesforce;
	private static $token;

	public function publicPath(){
        return $_SERVER['DOCUMENT_ROOT'];
	}
	public static function getDb($connection = null){
		return \Illuminate\Database\Capsule\Manager::connection($connection);
	}
	public static function setRequest($request){
		self::$request = $request;
	}
	public static function setController($controller){
		self::$controller = $controller;
	}
	public static function request(){
		return self::$request;
	}
	public static function controller(){
		return self::$controller;
	}
	public static function notFoundClass(){
		$namespace = "\\" . \Config::get('controller.service_provider')->getNamespace();
		$controller_action = \Config::get('controller.404');
		if($namespace && $controller_action){
			return explode('@', $namespace . "\\" . $controller_action);
		}
	}

	public static function setToken($token){
		session()->put('token',  (object) [
			'id_token' => $token->id_token,
			'updated_at' => $token->updated_at,
			'type' => $token->type,
		]);
		static::$token = $token;

		static::salesforce($token);
	}
	public static function token(){
		return static::$token;
	}

	public static function getSessionToken($type){
		return \App\Models\Token::where([
				'type' => $type,
				'env' => \Config::get('app.env')
			])
			->orderBy('updated_at', 'desc')
			->orderBy('created_at', 'dec')
			->first();
	}

	public static function authorizeAndSetToken($token = null){
		session()->forget([
			'token',
			'salesforce',
		]);

		if(!$token){
			$token = static::getSessionToken('salesforce');
		}

		if(!$token){
			throw new \Exception('Invalid Site Credentials. Please contact support.');
		}

		$salesforce = static::salesforce($token);

		$refreshToken = $salesforce->refreshAccessToken($token->refresh);
		$token->setAndSave(['token' => $refreshToken['access_token']]);

		static::setToken($token);

	}

	public static function checkSessionToken(){
		$tokenInfo = session('token');
		if(!$tokenInfo){
			return false;
		}

		$latest = static::getSessionToken($tokenInfo->type);

		if( \strtotime($latest->updated_at) > \strtotime($tokenInfo->updated_at) || !static::token()){
			static::setToken($latest);
		}
		
		if(strtotime( static::token()->updated_at) < time() - 3600 ){
			static::authorizeAndSetToken($latest);
		}

		return true;
	}

	public static function saveSessionToken($type, $token){		
		
		$existing = static::getSessionToken($type);
		
		if($existing){
			$token = $existing->setForCreate([
				'type' => $type,
				'data' => $token,
			]);
			$token->save();
		}else{
			list($token, $message) = \App\Models\Token::create([
				'type' => $type,
				'data' => $token,
			]);

			if(!$token){
				throw new \Exception($message);
			}
		}

		return $token;
	}
	public static function salesforce($token = null){
		if(static::$salesforce && !$token){
			return static::$salesforce;
		}

		return static::$salesforce = new \App\Services\Salesforce( $token );
	}

	public static function redirectToLogin(){
        return redirect('/login/' . (session('user.level') ?: 'member') );
	}
	
	public static function redirectToDashboard(){
		return redirect(('/' . session('user.level') ?: 'member') . '/dashboard');
	}
	
}