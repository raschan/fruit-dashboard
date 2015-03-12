<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendDailyEmail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'metrics:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends email to all the users with their previous days metrics.';

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
		// get all the users
		$users = User::all();
		// previous day's date
		$date = date('Y-m-d', time()-86400);
		// currently calculated metrics
		$currentMetrics = Calculator::currentMetrics();
		// for each user send email with their metrics
		foreach ($users as $user) {
			// check if user finished the connect process
			if ($user->isConnected())
			{
				// get the user's metrics
				$metrics = Metric::where('user', $user->id)	
								->where('date', $date)
								->first();
				// format metrics to presentable data
				$metrics->formatMetrics();
				$data = array(
					'metrics' => $metrics,
					'currentMetrics' => $currentMetrics
					);

				// login the user (necessary to get the email address)	
				Auth::login($user);


				// send the email to the user
				Mail::send('emails.summary', $data, function($message)
				{
					// get the currently logged in user
					$user = Auth::user();
					$message->to($user->email /*, name of the user*/)
							->subject('Daily summary');
				});

				// logout the user
				Auth::logout();
			}
		}
	}
}
