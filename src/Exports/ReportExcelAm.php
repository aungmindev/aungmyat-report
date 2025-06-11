<?php

namespace Aungmyat\Report\Exports;

use App\Models\Reportam;
use App\Models\User;
use Aungmyat\Report\Models\Reportam as ModelsReportam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExcelAm implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $query;
    protected $columns;
    protected $extra;
    public function __construct($query,$columns,$extra = []){
        $this->query = $query;
        $this->columns = $columns;
        $this->extra = $extra;
    }
   
    public function collection()
    {
        $data = DB::select($this->query);
       return collect($data);
    }

    public function headings() : array
    {
         $heading = $this->columns;
        return $heading;
    }
}
