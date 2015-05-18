<?php

return array(

   /*
   |--------------------------------------------------------------------------
   | Mail Driver
   |--------------------------------------------------------------------------
   |
   | Laravel supports both SMTP and PHP's "mail" function as drivers for the
   | sending of e-mail. You may specify which one you're using throughout
   | your application here. By default, Laravel is setup for SMTP mail.
   |
   | Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "log"
   |
   */

   'driver' => 'smtp',
   //'driver' => 'log',

   /*
   |--------------------------------------------------------------------------
   | Mail "Pretend"
   |--------------------------------------------------------------------------
   |
   | When this option is enabled, e-mail will not actually be sent over the
   | web and will instead be written to your application's logs files so
   | you may inspect the message. This is great for local development.
   |
   */

   'pretend' => false,

  

   'from' => array('address' => 'hello@tryfruit.com', 'name' => 'Staging'),

   

   /*
   |--------------------------------------------------------------------------
   | SMTP Server Username
   |--------------------------------------------------------------------------
   |
   | If your SMTP server requires a username for authentication, you should
   | set it here. This will get used to authenticate with your server on
   | connection. You may also set the "password" value below this one.
   |
   */

   'username' => 'hello@tryfruit.com',

   /*
   |--------------------------------------------------------------------------
   | SMTP Server Password
   |--------------------------------------------------------------------------
   |
   | Here you may set the password required by your SMTP server to send out
   | messages from your application. This will be given to the server on
   | connection so that the application will be able to send messages.
   |
   */

   'password' => 'almafa123'

);