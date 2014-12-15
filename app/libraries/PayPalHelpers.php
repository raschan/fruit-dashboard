<?php

class PayPalHelpers {
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
}
