<?php 

class OAuth2
{
	public static function getAuthorizeURL()
	{
		$endpoint = 'https://connect.stripe.com/oauth/authorize';
		$params = array(
			'response_type' => 'code',
			'client_id' => $_ENV['STRIPE_CLIENT_ID'] ,
			'scope' => 'read_only',
			'redirect_uri' => $_ENV['STRIPE_REDIRECT_URI'],
			'stripe_landing' => 'login'
			);

		$url = self::makeurl($endpoint,$params);
		return $url;
	}

	public static function getRefreshToken($code)
	{
		$endpoint = 'https://connect.stripe.com/oauth/token';
		$params = array(
			'client_secret' => $_ENV['STRIPE_SECRET_KEY'],
			'code' => $code,
			'grant_type' => 'authorization_code');

		$url = self::makeurl($endpoint,$params);

		$client = new Client();
		$returned_object = $client->post($endpoint, [
			'body' => $params])->json();

		return $returned_object;
	}

	private static function makeurl($endpoint,$params)
	{
		$url = $endpoint.'?';
		foreach ($params as $key => $value) {
			$url .= $key.'='.$value.'&';
		}

		// stripe the last unnecessary character
		$url = rtrim($url, "&");

		return $url;
	}


}