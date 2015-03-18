<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateExternalPackages extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'migrate:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrates all needed external package tables';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->call('migrate:refresh');
		//$this->call('db:seed');
		$this->call('migrate', array('--package' => 'barryvdh/laravel-async-queue'));
	}
}
