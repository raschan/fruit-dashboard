<?php
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid\PPOpenIdSession;
use PayPal\Rest\ApiContext;

use PayPal\Auth\Openid\PPOpenIdTokeninfo;
use PayPal\Exception\PPConnectionException;


/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
    public function showHello()
    {
        if (Auth::check()) {
            return View::make('hello');
        } else {
            return Redirect::route('auth.signin');
        }
    }

    /*
    |====================================================
    | <GET> | showStripe: renders the stripe testing page
    |====================================================
    */
    public function showStripe()
    {
        Auth::user()->buildMrr();
        // trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                //'balance' => Auth::user()->balance,
                //'charges' => Auth::user()->getCharges(),
                //'mrr' => Auth::user()->getMrr(),
                //'events' => Auth::user()->getEvents(),
            )
        );
    }

    /*
    |====================================================
    | <GET> | showPaypal: renders the paypal testing page
    |====================================================
    */
    public function showPaypal()
    {
        // setting api codes
        $clientId = "AY1PlRC0yK6SExlx8aRDW-hF2REkl90Qmza0Ak5LUacd-LFAczGmXfanQYK-";
        $clientSecret = "EBXUZxD6PobEUtc-WldtZgbG8eUzl4IkOFAeMxpAGhNDt-mESoj3a3QRRIGw";


        /** @var \Paypal\Rest\ApiContext $apiContext */
        $apiContext = $this->getApiContext($clientId, $clientSecret);

        // building up redirect url
        $redirectUrl = PPOpenIdSession::getAuthorizationUrl(
            route('dev.buildToken'),
            array('profile', 'email', 'phone'),
            null,
            null,
            null,
            $apiContext
        );

        $user = Auth::user();

        $refreshToken = $user->paypal_key;

        try {

            $tokenInfo = new PPOpenIdTokeninfo();
            $tokenInfo = $tokenInfo->createFromRefreshToken(array('refresh_token' => $refreshToken), $apiContext);

            $params = array('access_token' => $tokenInfo->getAccessToken());
            $userInfo = PPOpenIdUserinfo::getUserinfo($params, $apiContext);
            print "User Information".var_dump($userInfo);

        } catch (Exception $ex) {
            print "no pp key";
        }


        // making view
        return View::make(
            'dev.paypal',
            array(
                'redirect_url' => $redirectUrl
            )
        );
    }


    /*
    |====================================================
    | <GET> | showStripe: renders the stripe testing page
    |====================================================
    */
    public function doStripe()
    {

        //check if its our form
        if (Session::token() !== Input::get('_token')) {
            return Response::json(array(
                'msg' => 'Unauthorized attempt to create setting'
            ));
        }
        $charges = Auth::user()->getCharges();

        return Response::json($charges);
    }
    /*
    |========================================================
    | <AJAX/POST> | ajaxGetMrr: gets the logged in user's mrr
    |========================================================
    */
    public function ajaxGetMrr()
    {
        $mrr = Auth::user()->getMrr();
        Log::info("ready");
        return "test";
    }

    /**
     * Helper method for getting an APIContext for all calls
     *
     * @return PayPal\Rest\ApiContext
     */
    function getApiContext($clientId, $clientSecret)
    {
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

    /*
    |====================================================
    | <GET> | createRefreshTokenfromAuthToken: renders the paypal testing page
    |====================================================
    */
    public function createRefreshTokenfromAuthToken()
    {
        // setting api codes
        $clientId = "AY1PlRC0yK6SExlx8aRDW-hF2REkl90Qmza0Ak5LUacd-LFAczGmXfanQYK-";
        $clientSecret = "EBXUZxD6PobEUtc-WldtZgbG8eUzl4IkOFAeMxpAGhNDt-mESoj3a3QRRIGw";


        /** @var \Paypal\Rest\ApiContext $apiContext */
        $apiContext = $this->getApiContext($clientId, $clientSecret);
        $code = $_GET['code'];

        try {
            // Obtain Authorization Code from Code, Client ID and Client Secret
            $accessToken = PPOpenIdTokeninfo::createFromAuthorizationCode(array('code' => $code), null, null, $apiContext);
        } catch (PPConnectionException $ex) {
            return "error";
            exit(1);
        }
        //saving refresh token
        // updating the user
        $user = Auth::user();

        $user->paypal_key = $accessToken->getRefreshToken();

        // saving user
        $user->save();

        // redirect
        return Redirect::route('dev.paypal');
   }
}
