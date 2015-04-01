<?php 

class OAuth2
{
	public static function getAuthorizeURL()
	{
		$endpoint = 'https://connect.stripe.com/oauth/authorize';
		$params = array(
			'response_type' => 'code',
			'client_id' => 'ca_5GWsCM72IcIz9vtWMMR7PnzQwHENneZE',
			'scope' => 'read_only',
			'redirect_uri' => 'http://localhost:8001/connect/stripe',
			'stripe_landing' => 'login'
			);

		$url = self::makeurl($endpoint,$params);
		return $url;
	}

	public static function getRefreshToken($code)
	{
		$endpoint = 'https://connect.stripe.com/oauth/token';
		$params = array(
			'client_secret' => 'sk_test_YOhLG7AgROpHWUyr62TlGXmg',
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

		$url = rtrim($url, "&");

		return $url;
	}


}