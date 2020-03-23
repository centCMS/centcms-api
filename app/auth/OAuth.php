<?php
namespace LightCloud\CentCMS\Api\Auth;

use PhalconPlus\Curl\Response as CurlResponse;
use PhalconPlus\Com\Protos\Exceptions\AuthFailedException;
use Phalcon\Text;
use PhalconPlus\Com\Protos\ExceptionBase as BaseException;
use PhalconPlus\Assert\Assertion as Assert;
use Ph\{
	App, Config, Redis, Security, Url, Session, Log,
};

class OAuth
{
	private $client = null;
	const KEY = "uc:accessToken";
	const CLIENT_ID = 1;
	
	public function __construct(string $name = "")
	{
		if(empty($name)) {
			$name = "uc";
		}
		$this->client = App::oauth($name);     
	}
	
	public function authorizeCodeUrl($scopes = [])
	{
		$baseUrl = Config::path("uc.addresses.0");
		$url = $baseUrl . '/authorize/code';
		$codeVerifier = Text::random(Text::RANDOM_ALNUM, 64);
		$state = Text::random(Text::RANDOM_ALNUM, 32);
		$encryptBase64 = base64_encode(hash("sha256", $codeVerifier, true));
		$codeChallengede = strtr(rtrim($encryptBase64, '='), '+/', '-_');
		$queryParams = [
			'response_type' => 'code',
			'client_id' => OAuth::CLIENT_ID,
			'redirect_uri' => Url::get('/oauth/callback'),
			'scope' => join(" ", $scopes),
			'state' => $state,
			'code_challenge' => $codeChallengede,
			'code_challenge_method' => 'S256',
		];
		Log::debug(var_export($queryParams, true));
		Session::set("codeVerifier", $codeVerifier);
		Session::set("oauthState", $state);
		return $url.'?'.http_build_query($queryParams);
	}
	
	public function getAccessTokenByCode(string $code)
	{
    	$response = $this->client->post('/authorize/access-token', 
        	[
           		'grant_type' => 'authorization_code',
           		'client_id'  => OAuth::CLIENT_ID,
           		'client_secret' => 'secret',
           		'redirect_uri' => Url::get('/oauth/callback'),
				'code' => $code,
				'code_verifier' => Session::get("codeVerifier"),
			]
    	);
		$ret = $this->process($response);
		Session::set("oauth", json_encode($ret->data));
	}
	
	public function refreshToken(string $refreshToken, $scopes = [])
	{
    	$response = $this->client->post('/authorize/access-token', 
        	[
           		'grant_type' => 'refresh_token',
           		'client_id'  => 1,
           		'client_secret' => 'secret',
				'refresh_token' => $refreshToken,
				'scope' => join(" ", $scopes),
			]
    	);
		$ret = $this->process($response);
		Session::set("oauth", json_encode($ret->data));
	}
	
	public function getUserInfo()
	{
		if(!Session::has("oauth")) {
			BaseException::throw("OAuth信息不存在"); 
		}
		$oAuth = json_decode(Session::get("oauth"), true);
    	$response = $this->client->post('/user/info', 
        	[
				"userId" => 11,
			],
			[
				'Authorization' => 'Bearer ' . $oAuth['access_token']
			]
    	);
		return $this->process($response);
	}
	
// {
// 	    "errorCode": 0,
// 	    "data": {
// 	        "token_type": "Bearer",
// 	        "expires_in": 3600,
// 	        "access_token": ""
// 	    },
// 	    "errorMsg": "",
// 	    "sessionId": "lllr7jk3t1ejbtc1429daq9f6n"
// 	}
	public function getAccessTokenByClient()
	{
		$needNew = true;
		if(Redis::exists(OAuth::KEY)) {
			$seconds = Redis::ttl(OAuth::KEY);
			if($seconds > 300) { // 5 minutes
				$needNew = false;
			}
		}
		if(true == $needNew) {
        	$response = $this->client->post('/authorize/access-token', 
            	[
                	'grant_type' => 'client_credentials',
                	'client_id'  => 1,
                	'client_secret' => 'secret',
                	'scope' => 'user',
				]
        	);
			$ret = $this->process($response);
			Redis::setEx(OAuth::KEY, $ret->data['expires_in'], $ret->data['access_token']);
	   }
	}
	
	
// {
// 	    "errorCode": 0,
// 	    "data": {
// 	        "oauth_access_token_id": "5d09141212bd2cbe2f1afff3cd4c6f660cc795f8583f6255753e7b134d2c38127c1ddad7cccb434d",
// 	        "oauth_client_id": "1",
// 	        "oauth_user_id": "1",
// 	        "oauth_scopes": [
// 	            "user"
// 	        ],
// 	        "can_access": true
// 	    },
// 	    "errorMsg": "",
// 	    "sessionId": "lllr7jk3t1ejbtc1429daq9f6n"
// 	}
	public function canAccessScope($scope)
	{
		if(is_string($scope)) {
			$scope = [$scope];
		}
		$scopes = join(" ", $scope);
		$response = $this->client->post('/access-token/validate', 
            [
                'scope' => $scopes,
                'accessToken' => Redis::get(OAuth::KEY),
            ]
        );
		$ret = $this->process($response);
	}
	
	private function process($response)
	{
        try {
            $arrayObj = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            Assert::isInstanceOf($response, CurlResponse::class);
            Assert::eq($response->statusCode, 200);
            Assert::isJsonString($response->body, "OAuth服务异常", "/body", $arrayObj);
            Assert::eq($arrayObj->errorCode, 0, $arrayObj->errorMsg);
        } catch(\PhalconPlus\Assert\InvalidArgumentException $e) {
            throw new AuthFailedException();
        }
		return $arrayObj;
	}
}