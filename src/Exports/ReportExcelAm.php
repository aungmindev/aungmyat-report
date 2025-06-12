<?php

namespace Aungmyat\Report\Exports;

use App\Models\Reportam;
use App\Models\User;
use Aungmyat\Report\Models\Reportam as ModelsReportam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;

class ReportExcelAm implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $columns;
    protected $extra;
    protected $join_tables;
    protected $main_table;

    public function __construct($columns,$extra = [] , $main_table = null ,  $join_tables = []){
        $this->columns = $columns;
        $this->extra = $extra;
        $this->join_tables = $join_tables;
        $this->main_table = $main_table;
    }
   
    public function collection()
    {
        
        $query = DB::table($this->main_table);
        $this->applyJoins($query, $this->main_table, $this->join_tables);
        $data = $query->select($this->columns)->get();
        return collect($data);
    }

    protected function applyJoins(&$query, $main_table, $join_tables)
    {
        if(!empty($join_tables)){
            foreach($join_tables as $join_table){
                $data = $query
                      ->leftJoin($join_table['table_name'], $main_table.'.'.$join_table['foreign_key'], '=', $join_table['table_name'].'.id')
                      ->select();
                if(!empty($join_table['nested_join'])){
                    $this->applyJoins($query, $join_table['table_name'], $join_table['nested_join']);
                }
            }
        }

    }

    public function headings() : array
    {
        $columns = $this->columns;
        $cleanedColumns = array_map(function ($column) {
            if (stripos($column, ' as ') !== false) {
                // Split by ' as ' case-insensitively and return the alias part
                $parts = preg_split('/\s+as\s+/i', $column);
                return trim($parts[1]); // the alias
            }
            return $column;
        }, $columns);
        
        $heading = $cleanedColumns;
        return $heading;
    }
}
