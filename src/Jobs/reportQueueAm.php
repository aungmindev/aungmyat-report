<?php

namespace Aungmyat\Report\Jobs;

use Aungmyat\Report\Exports\ReportExcelAm;
use Aungmyat\Report\Mail\MailReportByAm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class reportQueueAm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $query;
    protected $filename;
    protected $columns;
    protected $extra;
    protected $senderemail;
    protected $subject;
    public function __construct($query,$filename,$columns,$senderemail,$subject,$extra = [])
    {
        $this->query = $query;
        $this->filename = $filename;
        $this->columns = $columns;
        $this->extra = $extra;
        $this->senderemail = $senderemail;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    //    Log::debug($this->columns);
         
        Excel::store(new ReportExcelAm($this->query,$this->columns,$this->extra), $this->filename);
        Mail::to($this->senderemail)->send(new MailReportByAm($this->filename,$this->subject));

    }
}
