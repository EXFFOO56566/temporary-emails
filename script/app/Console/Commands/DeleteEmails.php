<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TrashMail;
use Carbon\Carbon;
use File;

class DeleteEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all Emails After X Time';

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

        // Check the mail is it expired and delete all files and messages from this mail

        $now = Carbon::now();

        $emails = TrashMail::where('delete_in', '<=', "$now")->get();

        if ($emails->count() > 0) {

            foreach ($emails as $email) {

                $result = TrashMail::DeleteEmail($email->email);

                echo $result;

            }
        }
        
    }
}
