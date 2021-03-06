<?php

namespace App\Console\Commands;

use App\Enquiry;
use App\User;
use Illuminate\Console\Command;

class EnquiryDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enquiry_dates:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email any upcoming dates from Enquiries';

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
    public function handle()
    {
        //Command to send any dates booked in for the week in Enquiries - the schedule is in app/console/kernel.php
        //get all users
        $user = User::all();
        //just for the week?
        $datePeriod = 'week';
        //get any enquiries for that period
        $enquiries = Enquiry::Diary($datePeriod)->get();
        $diarylist = '';

        //if any in the list send an email to each user with the customer & date
        if ($enquiries->count() > 0) {
            foreach ($enquiries as $el) {

                $diarylist .= $el->enq_customer . ':' . $el->enq_diarydate . "\n";
            }

            $url = url('/enquiries');
            $diarylist .= $url;

            foreach ($user as $a) {
                \Mail::raw($diarylist, function ($message) use ($a) {
                    $message->from('accounts@weigh-till.co.uk');
                    $message->to($a->email)->subject('Enquiry Weekly Update');

                });
            }
            $this->info('You have ' . $enquiries->count() . ' date alerts!' . $diarylist);
            //break;

        }

        //dd($enquiries);
        else {
            $this->info('There are no alerts this week!');

        }

    }
}