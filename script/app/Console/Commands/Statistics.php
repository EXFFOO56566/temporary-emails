<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Statistic;
use App\Models\Settings;
use Carbon\Carbon;


class Statistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Statistis Site Daily';

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
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->format("d-m-Y");


        $total_emails    = Settings::selectSettings('total_emails_created');
        $total_messages  = Settings::selectSettings('total_messages_received');

        $statistics_messgaes = Statistic::where("key" , "total_messges_pay_day")->sum('value');
        $statistics_emails   = Statistic::where("key" , "total_email_pay_day")->sum('value');

        if($statistics_messgaes != 0 OR $statistics_emails != 0){

            $last_email   = Statistic::where("key" , "total_email_pay_day")->orderBy('created_at', 'desc')->limit(1)->first();

            $last_email_date = $last_email->created_at->format("d-m-Y");

            if(Carbon::now()->diffInDays(Carbon::parse($last_email_date)) > 0){

                $email_statistic = new Statistic();
                $email_statistic->key = "total_email_pay_day";
                $email_statistic->value = $total_emails - $statistics_emails;
                $email_statistic->save();

                $message_statistic = new Statistic();
                $message_statistic->key = "total_messges_pay_day";
                $message_statistic->value = $total_messages - $statistics_messgaes;
                $message_statistic->save();

                echo "New statistics have been added on " . $now . "\n";

            } 


            if(Carbon::now()->diffInDays(Carbon::parse($last_email_date)) == 0){

                $last_email   = Statistic::where("key" , "total_email_pay_day")->orderBy('created_at', 'desc')->limit(1)->first();
                $last_message   = Statistic::where("key" , "total_messges_pay_day")->orderBy('created_at', 'desc')->limit(1)->first();

                $last_email->update([
                    'value' => $last_email->value + $total_emails - $statistics_emails,
                ]);
                $last_message->update([
                    'value' => $last_message->value + $total_messages - $statistics_messgaes,
                ]);

                echo "Updated...";

            }

        }else{

            $email_statistic = new Statistic();
            $email_statistic->key = "total_email_pay_day";
            $email_statistic->value = $total_emails - $statistics_emails;
            $email_statistic->save();

            $message_statistic = new Statistic();
            $message_statistic->key = "total_messges_pay_day";
            $message_statistic->value = $total_messages - $statistics_messgaes;
            $message_statistic->save();

            echo "New statistics have been added on " . $now . "\n";

        }

    }
}

