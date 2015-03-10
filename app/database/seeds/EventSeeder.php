<?php

class EventSeeder extends Seeder
{

    public function run()
    {
        DB::table('events')->delete();    

        $currentDay = time();
        $user = User::find(1);
        // days generated before the current date
        $generatedDay = $currentDay - 370*24*60*60;

        // generating data for ~2 years
        for ($i = 0; $i < 750; $i++) { 
            // timestamp of the current day
            $dailyTimeStamp = $generatedDay + $i*24*60*60;
            $date = date('Y-m-d', $dailyTimeStamp);
            $monthStats = EventSeeder::monthlyStats($dailyTimeStamp);
            $eventTimes = EventSeeder::generateEventTimes($monthStats, $dailyTimeStamp);

            foreach ($eventTimes as $event){
                $temparray = EventSeeder::getEventType($monthStats, $event);
                if ($temparray){
                        DB::table('events')->insert(
                            array(
                                'user' => $user->id,
                                'created' => date('Y-m-d H:i:s', $event),
                                'eventID' => $temparray['id'],
                                'type' => $temparray['type'],
                                'object' => $temparray['object'],
                                'provider' => 'stripe',
                                'previousAttributes' => $temparray['previousAttributes'],
                                'date' => date('Y-m-d', $event)
                            )
                        );
                    }
                }
                // set time to last timestamp +1 
                $event++;
                // calculate all
                Calculator::calculateMetrics($user, $event);
            }

    }
        // returns a random event type with the corresponding data array ready for seeding
        public function getEventType($monthStats, $eventTime){
            $array = array();
            $randomNumber = rand(1,100);
            if ( $randomNumber > 0 && $randomNumber <= $monthStats['subscriptions']){
                $array['type'] = 'customer.subscription.created';
                $array['id'] = EventSeeder::generateRandomString();
                $array['created'] = $eventTime;
                $temparray = EventSeeder::fillObject('subscriptions');
                $array['object'] = $temparray['json'];
                $array['previousAttributes'] = $temparray['previous'];
            }
            elseif ( $randomNumber > $monthStats['subscriptions'] && $randomNumber <= ($monthStats['subscriptions'] + $monthStats['cancels'])){
                $array['type'] = 'customer.subscription.deleted';
                $array['id'] = EventSeeder::generateRandomString();
                $array['created'] = $eventTime;
                $temparray = EventSeeder::fillObject('cancels');
                $array['object'] = $temparray['json'];
                $array['previousAttributes'] = $temparray['previous'];
            }
            elseif ( $randomNumber > ($monthStats['subscriptions'] + $monthStats['cancels']) && $randomNumber <= ($monthStats['subscriptions'] + $monthStats['cancels'] + $monthStats['updates'])){
                $array['type'] = 'customer.subscription.updated';
                $array['id'] = EventSeeder::generateRandomString();
                $array['created'] = $eventTime;
                $temparray = EventSeeder::fillObject('updates');
                $array['object'] = $temparray['json'];
                $array['previousAttributes'] = $temparray['previous'];
            }
            else {
                $array = null;
            }
            return $array;
        }

        // fills the event object with the corresponding data
        public function fillObject($type){
            $name = EventSeeder::generateRandomString(8);
            $plan = EventSeeder::getRandomPlan();
            $object['previous'] = null;
            switch ($type){
                case 'subscriptions':
                // jsonencode
                $object['json'] = '{"plan":{"interval":"month","currency":"usd","object":"plan","name":"' . $plan['name'] . '","amount":' . $plan['amount'] .'}}';
                break;
                case 'cancels':
                // jsonencode
                $object['json'] = '{"plan":{"interval":"month","currency":"usd","object":"plan","name":"' . $plan['name'] . '","amount":' . $plan['amount'] .'}}';
                break;                
                case 'updates':
                // jsonencode
                $object['json'] = '{"plan":{"interval":"month","currency":"usd","object":"plan","name":"' . $plan['name'] . '","amount":' . $plan['amount'] .'}}';
                // i need a previous attributes json
                $object['previous'] = '{"plan":{"id":"' . EventSeeder::generateRandomString(4) . '","interval":"month","name":"' . $plan['nameChange'] . '","amount":' . $plan['amountChange'] .'}}';
                break;
                case 'default':
                break;
            }
            return $object;
        }

        // returns an array of timestamps
        public function generateEventTimes($monthStats, $dailyTimeStamp){
            $min = $dailyTimeStamp;
            $max = $dailyTimeStamp + 24*60*58;

            $modulus = ($max - $min) / $monthStats['eventNumber'];
            $array =[];

            for ($i=0;$i<$monthStats['eventNumber'];$i++){
                array_push($array, $dailyTimeStamp + ($modulus * $i));
            }
            return $array;
        }

        // gives the base number of events on a day and a probability number for event type randomizing
        public function monthlyStats($dailyTimeStamp){
            $month_name = EventSeeder::getMonth($dailyTimeStamp);
            switch ($month_name){
                case 'Jan':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 30;
                    $array['cancels'] = 0;
                    $array['updates'] = 0;
                    break;
                case 'Feb':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 20;
                    $array['cancels'] = 5;
                    $array['updates'] = 15;
                    break;
                case 'Mar':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 20;
                    $array['cancels'] = 10;
                    $array['updates'] = 5;
                    break;
                case 'Apr':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 15;
                    $array['cancels'] = 5;
                    $array['updates'] = 10;
                    break;
                case 'May':
                    $array['eventNumber'] = 25;
                    $array['subscriptions'] = 70;
                    $array['cancels'] = 15;
                    $array['updates'] = 15;
                    break;
                case 'Jun':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 10;
                    $array['cancels'] = 5;
                    $array['updates'] = 5;
                    break;
                case 'Jul':
                    $array['eventNumber'] = 12;
                    $array['subscriptions'] = 10;
                    $array['cancels'] = 2;
                    $array['updates'] = 2;
                    break;
                case 'Aug':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 15;
                    $array['cancels'] = 2;
                    $array['updates'] = 2;
                    break;
                case 'Sep':
                    $array['eventNumber'] = 12;
                    $array['subscriptions'] = 20;
                    $array['cancels'] = 5;
                    $array['updates'] = 5;
                    break;
                case 'Oct':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 20;
                    $array['cancels'] = 2;
                    $array['updates'] = 5;
                    break;
                case 'Nov':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 25;
                    $array['cancels'] = 5;
                    $array['updates'] = 15;
                    break;
                case 'Dec':
                    $array['eventNumber'] = 30;
                    $array['subscriptions'] = 30;
                    $array['cancels'] = 10;
                    $array['updates'] = 10;
                    break; 
                case 'default':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 40;
                    $array['cancels'] = 5;
                    $array['updates'] = 10;
                    break;
                }
            return $array;               
        }

        public function getMonth($timeStamp){
            $months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

            $date = getdate();
            $month = $date['mon'];
            return $months[$month];
        }

        public function generateRandomString($length = 16) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public function getRandomPlan(){
            // plan
            $random = rand(1,3);
            // plan change from
            $random2 = rand(1,3);

            switch ($random) {
                case '1':
                    $plan['name'] = 'ini';
                    $plan['amount'] = 1900;
                    break;
                case '2':
                    $plan['name'] = 'mini';
                    $plan['amount'] = 2900;
                    break;
                case '3':
                    $plan['name'] = 'mino';
                    $plan['amount'] = 4900;
                    break;
                default:
                    error_log('lol');
                    break;
            }

            switch ($random2) {
                case '1':
                    $plan['nameChange'] = 'ini';
                    $plan['amountChange'] = 1900;
                    break;
                case '2':
                    $plan['nameChange'] = 'mini';
                    $plan['amountChange'] = 2900;
                    break;
                case '3':
                    $plan['nameChange'] = 'mino';
                    $plan['amountChange'] = 4900;
                    break;
                default:
                    error_log('lol');
                    break;
            }

            return $plan;
        }

        
}