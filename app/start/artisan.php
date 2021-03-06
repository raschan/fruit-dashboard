<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
Artisan::add(new GetEvents);
Artisan::add(new CalculateMetrics);
Artisan::add(new SendDailyEmail);
Artisan::add(new MigrateExternalPackages);
Artisan::add(new GenerateEmailConnect);
Artisan::add(new GenerateEmails);
Artisan::add(new TrialEndCheck);
Artisan::add(new CheckPaymentPastDue);
