<?php
use PayPal\Rest\ApiContext;

use PayPal\Exception\PPConnectionException;
use PayPal\Auth\Openid\PPOpenIdUserinfo;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;

class PaypalController extends BaseController
{
    /**
     * we will need the context in almost all functions
     *
     * @var apiContext
    */
    var $apiContext = null;


    /**
     * in the construct we set the context up
     *
     * @return null
    */
   function __construct() {
        // getting api context
       $this->apiContext = PayPalHelper::getApiContext();
   }


    /*
    |====================================================
    | <GET> | createRefreshTokenfromAuthToken: renders the paypal testing page
    |====================================================
    */
    public function createRefreshToken()
    {
        Log::info("we've reached this point");
        // checking if we have code
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
        } else {
            return "error";
            exit(1);

        }

        try {
            // Obtain Authorization Code from Code, Client ID and Client Secret
            $accessToken = PPOpenIdTokeninfo::createFromAuthorizationCode(array('code' => $code), null, null, $this->apiContext);
        } catch (PPConnectionException $ex) {
            return "error";
            exit(1);
        }

        // updating the user
        $user = Auth::user();

        //saving refresh token
        $user->paypal_key = $accessToken->getRefreshToken();

        Log::info($user->paypal_key);

        // saving user
        $user->save();

        // redirect
        return Redirect::route('dev.paypal');
   }
}
