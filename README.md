# Fruit Analytics

Fruit Analytics is a dashboard solution for startup companies.

## Table of contents
[TOC]

## How to build your local development box?
  - download & install [Virtualbox]
  - download & install [Vagrant] (max 1.6.5)
  - download & install [Sourcetree]

### In Sourcetree
  - clone ```abfinformatika/vagrant-lamp``` → ```[YOUR_WORKING_DIRECTORY]```
  - clone ```abfinformatika/supdashboard``` → ```[YOUR_WORKING_DIRECTORY/vagrant-lamp/sites/supdashboard]```

### In the terminal
Start your vagrant server and ssh into it.
```sh
cd vagrant-lamp
vagrant up
vargrant ssh
```

### In the vagrant terminal
####Make your server up to date.
```sh
sudo apt-get update
```

####Get the local environment files.
```sh
cd /var/www/supdashboard
wget .env.local.php [ask for it from fellow developers]
```

####Install laravel
```sh
cd /var/www/supdashboard
composer global require "laravel/installer=~1.1"
```

####Update the dependencies
```sh
cd /var/www/supdashboard/
composer update
```

####Create the database
```sh
cd /var/www/supdashboard/scripts
sh run_sql_commands
```

####Migrate an external dependencys database
```sh
cd /var/www/supdashboard/
php artisan migrate --package=barryvdh/laravel-async-queue
```

####Setup cron

- replace ```/var/www/fruit-analytics/``` with whatever is needed (f.e. ```/home/abfinfor/public_html/dashboard.tryfruit.com/```)
- replace ```/usr/bin/php``` with whatever is needed (f.e. ```/usr/local/bin/php/```)

```sh
crontab -e
```

```sh
# get events
1-59/5 * * * * /usr/bin/php /var/www/fruit-analytics/artisan events:get
# calculate daily values
2-59/5 * * * * /usr/bin/php /var/www/fruit-analytics/artisan metrics:calc
# daily summary email
0 9 * * * /usr/bin/php /var/www/fruit-analytics/artisan metrics:send
```

####Some small fixes, till the vendor package is fixed

```sh
mcedit vendor/waavi/mailman/src/Waavi/Mailman/Mailman.php
```

Row 93 should be changed to this:
```
$this->setCss(Config::get('waavi/mailman::css.file'));
```

Row 98 should be changed to this:
```
$this->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
```

####Run the laravel server
```sh
sh serve
```

### In the browser
Open ```http://localhost:8001/ ```


**...aaaaaand you are done.**

[Virtualbox]:https://www.virtualbox.org/
[Vagrant]:https://www.vagrantup.com
[Sourcetree]:https://www.sourcetreeapp.com
