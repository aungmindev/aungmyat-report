<?php

namespace Aungmyat\Report\Process_provider;

use Aungmyat\Report\Exports\ReportExcelAm;
use Aungmyat\Report\Jobs\reportQueueAm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class reportingProcess{
   public function __construct()
   {
       
   }

   public static function process($query,$filename,$columns,$senderemail,$limit = false,$subject ,$extra = '')
   {
    $checkquery = trim(trim($query) , ';').' limit '.$limit;      
    $checkqueryCount = DB::select(DB::raw("$checkquery"));
     if($limit == false || count($checkqueryCount) > $limit){
        reportQueueAm::dispatch($query,$filename,$columns,$senderemail,$subject)
        ->delay(now()->addSeconds(5));
        return redirect()->back();
     }else{
        return Excel::download(new ReportExcelAm($query,$columns,$extra), $filename);
     }
   }
}