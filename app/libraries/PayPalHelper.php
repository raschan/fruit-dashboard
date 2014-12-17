<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;

class PayPalHelper {

    /**
     * Getting the API context for the application
     * change the clientID and clientSecret accordingly
     *
     * @return boolean
    */
    public static function getApiContext() {
        // setting api codes
        $clientId = "AY1PlRC0yK6SExlx8aRDW-hF2REkl90Qmza0Ak5LUacd-LFAczGmXfanQYK-";
        $clientSecret = "EBXUZxD6PobEUtc-WldtZgbG8eUzl4IkOFAeMxpAGhNDt-mESoj3a3QRRIGw";


        // getting the ApiContext from oauth
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        // setting api context
        $apiContext->setConfig(
            array(
                'mode'                   => 'sandbox',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled'         => true,
                'log.FileName'           => '../PayPal.log',
                'log.LogLevel'           => 'FINE',
                'validation.level'       => 'log',
                'cache.enabled'          => 'true'
            )
        );

        // returning api context
        return $apiContext;
    }

    /**
     * Generating an access token for the user
     * from the previously stored refresh token
     * false on no token
     *
     * @return String/boolean
    */
    public static function generateAccessTokenFromRefreshToken($user)
    {
        // if the user is not connected to PP, our job is done here
        if (!$user->isPayPalConnected()) {
            return false;
        }

        $refreshToken = $user->paypal_key;

        try {
            // getting token info
            $tokenInfo = new PPOpenIdTokeninfo();
            $tokenInfo = $tokenInfo->createFromRefreshToken(array('refresh_token' => $refreshToken), $apiContext);

        } catch (Exception $ex) {
            // something went wrong
            // redirect to 500
            exit(1);
        }

        // everything's fine, returning accessToken
        return $tokenInfo->getAccessToken();

    }
}
