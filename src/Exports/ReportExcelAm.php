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
    protected $query;
    public function __construct($columns,$extra = [] , $main_table = null ,  $join_tables = [],$query = null){
        $this->columns = $columns;
        $this->extra = $extra;
        $this->join_tables = $join_tables;
        $this->main_table = $main_table;
        $this->query = $query;
    }
   
    public function collection()
    {
        if($this->query != null){
            $data = DB::select($this->query);
            return collect($data);
        }else{
            $query = DB::table($this->main_table);
            $this->applyJoins($query, $this->main_table, $this->join_tables);
            $this->applyFilters($query, $this->extra);
            $data = $query->select($this->columns)->get();
            return collect($data);
        }
        
    }

    protected function applyJoins(&$query, $main_table, $join_tables)
    {
        if(!empty($join_tables)){
            foreach($join_tables as $join_table){
                $query->leftJoin($join_table['table_name'], $main_table.'.'.$join_table['foreign_key'], '=', $join_table['table_name'].'.id');
                
                if(!empty($join_table['nested_join'])){
                    $this->applyJoins($query, $join_table['table_name'], $join_table['nested_join']);
                }
            }
        }

    }

    protected function applyFilters(&$query, $extra)
    {
        if(!empty($extra)){
            foreach ($extra as $field => $condition) {
                // If it's a date range filter
                if (is_array($condition) && isset($condition['start_date'], $condition['end_date'])) {
                    $query->where("{$this->main_table}.{$field}", '>=', $condition['start_date'])
                        ->where("{$this->main_table}.{$field}", '<=', $condition['end_date']);
                } else {
                    $query->where("{$this->main_table}.{$field}", $condition);
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
