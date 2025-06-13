<?php

namespace Aungmyat\Report\Process_provider;

use Aungmyat\Report\Exports\ReportExcelAm;
use Aungmyat\Report\Jobs\reportQueueAm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class reportingProcess{
   public function __construct()
   {
       
   }

   public static function process($filename,$columns,$senderemail,$limit = false,$subject ,$extra = [],$main_table = null , $join_tables = [],$query = null)
   {
      $overlimit = intval($limit) + 5;
      if($query){
         $checkquery = trim(trim($query) , ';').' limit '.$overlimit;  
         $checkquery = DB::select($checkquery);
         $count = count($checkquery);
      }else{
         $checkquery = DB::table($main_table)->limit($overlimit)->get();  
         $count = $checkquery->count();
      }
      //update the syntax for updated laravel 11
    
      if($limit == false || $count > $limit){
         reportQueueAm::dispatch($filename,$columns,$senderemail,$subject)
         ->delay(now()->addSeconds(3));
         return redirect()->back();
      }else{
         return Excel::download(new ReportExcelAm($columns,$extra, $main_table , $join_tables , $query), $filename);
      }
   }
}