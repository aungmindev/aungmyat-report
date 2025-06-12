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

   public static function process($filename,$columns,$senderemail,$limit = false,$subject ,$extra = '',$main_table = null , $join_tables = [])
   {
      $overlimit = intval($limit) + 5;
      $checkquery = DB::table($main_table)->limit($overlimit)->get();     
      //update the syntax for updated laravel 11
    
      if($limit == false || $checkquery->count() > $limit){
         reportQueueAm::dispatch($filename,$columns,$senderemail,$subject)
         ->delay(now()->addSeconds(3));
         return redirect()->back();
      }else{
         return Excel::download(new ReportExcelAm($columns,$extra, $main_table , $join_tables), $filename);
      }
   }
}