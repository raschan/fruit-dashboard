# Fruit Analytics

Fruit Analytics is a dashboard solution for startup companies.

## How to build your local development box?
  - download & install [Virtualbox]
  - download & install [Vagrant] (max 1.6.5)
  - download & install [Sourcetree]

### In Sourcetree
  - clone abfinformatika/vagrant-lamp → [YOUR_WORKING_DIRECTORY]
  - clone abfinformatika/supdashboard → [YOUR_WORKING_DIRECTORY/vagrant-lamp/sites/supdashboard]

### In the terminal
Start your vagrant server and ssh into it.
```sh
cd vagrant-lamp
vagrant up
vargrant ssh
```

### In the vagrant terminal
Make your server up to date.
```sh
sudo apt-get update
```

Get the local environment files.
```sh
cd /var/www/supdashboard
wget .env.local.php [ask for it from Rashan]
```

Install laravel
```sh
cd /var/www/supdashboard
composer global require "laravel/installer=~1.1"
```

Create the database
```sh
cd /var/www/supdashboard/scripts
chmod 755 run_sql_commands
./run_sql_commands
```

Update the dependencies
```sh
cd /var/www/supdashboard/
composer update
```

Run the laravel server
```sh
chmod 755 ./serve
./serve
```

### In the browser
Open http://localhost:8001/ 

[Virtualbox]:https://www.virtualbox.org/
[Vagrant]:https://www.vagrantup.com
[Sourcetree]:https://www.sourcetreeapp.com
