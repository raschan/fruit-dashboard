<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        
        //$this->call('UserTableSeeder');
        //$this->call('UserTableExtendSeeder');
        //$this->call('supdashboarddbTableSeeder');
        //$this->call('ConnectedServicesSeeder');
        $this->call('ExtendDefaultsSeeder');
    }

}
