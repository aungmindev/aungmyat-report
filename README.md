#This is report system

#There are 4 simple steps to complete this package after installing.

#Installation =
(composer require aungmyat/report:v2.0.1)
1. add following Serviceprovider in config/app.php.

    \Aungmyat\Report\ReportServiceProvider::class,
    

2. Set up Mail in .env

3. If You are not set up Queue.
     * Set up driver for QueueConnection in .env {Change => database}
     * Run (php artisan queue:table)
     * Run (php artisan migrate)

4 . Usage
      
      
      * use Aungmyat\Report\Process_provider\reportingProcess;
      
      
    public function method()

     {
  
        //method 1
        // if(!$request->download_date){
        //     $start_date = Carbon::now()->format('Y-m-d').' 00:00:00';
        //     $end_date = Carbon::now()->format('Y-m-d').' 23:59:59';
        // }else{
        //     $start_date = Carbon::parse($request->download_date)->format('Y-m-d').' 00:00:00';
        //     $end_date = Carbon::parse($request->download_date)->format('Y-m-d').' 23:59:59';
        // }
        
        //  $query = "select car_cycle_infos.vehicle_license_number as license_number,liter,amount,vehicle_types.name AS category_type_name,shop_name,smart_card_number from `petro_shop_sale_records` left join `petro_shops` on `petro_shop_sale_records`.`petro_shop_id` = `petro_shops`.`id` left join `vehicles` on `petro_shop_sale_records`.`vehicle_id` = `vehicles`.`id` left join `car_cycle_infos` on `vehicles`.`vehicleable_id` = `car_cycle_infos`.`id` left join `vehicle_types` on `petro_shop_sale_records`.`category_type` = `vehicle_types`.`id` where `petro_shop_sale_records`.`created_at` >= '$start_date' and `petro_shop_sale_records`.`created_at` <= '$end_date'";
        //  $main_table = null;
        //  $join_tables = [];
        //  $extra = [];
        //  $columns  = ['car_cycle_infos.vehicle_license_number as license_number','liter','amount','vehicle_types.name AS category_type_name','shop_name','smart_card_number'];
        //  $filename = 'sale_record.xlsx';
        //  $senderemail = 'aungmyatmin284@gmail.com';
        //  $limit       = 5000;  //Optional 
        //  $subject     = 'Your email subject';

        
        // method 2 => if you don't want to use custom query , you can use this code.
        
        if(!$request->download_date){
            $start_date = Carbon::now()->format('Y-m-d').' 00:00:00';
            $end_date = Carbon::now()->format('Y-m-d').' 23:59:59';
        }else{
            $start_date = Carbon::parse($request->download_date)->format('Y-m-d').' 00:00:00';
            $end_date = Carbon::parse($request->download_date)->format('Y-m-d').' 23:59:59';
        }
        $query = null;
        $main_table = 'petro_shop_sale_records';
        $join_tables = [
            [
                'table_name' => 'petro_shops',
                'foreign_key' => 'petro_shop_id',
                'nested_join' => []
                
            ],
            [
                'table_name' => 'vehicles',
                'foreign_key' => 'vehicle_id', //key store in main table , petro_shop_sale_records will be the main table for this join
                'nested_join' => [
                    [
                        'table_name' => 'car_cycle_infos',
                        'foreign_key' => 'vehicleable_id',//key store in main table , vehicles will be the main table for this join
                        'nested_join' => []
                    ]
                ]
            ],
            [
                'table_name' => 'vehicle_types',
                'foreign_key' => 'category_type',
                'nested_join' => []
                
            ],
        ];
        
        //optional default value = []
        $extra = [
            'created_at' => [
                'start_date' => $start_date,
                'end_date' => $end_date
            ], // if you want date range , you can use this parameter and exactly same as this example format. column name created_at is the column name in your table.
        ]; 

        // if you don't want to use custom query , you can use this code.
        //end here

        $columns  = ['car_cycle_infos.vehicle_license_number as license_number','liter','amount','vehicle_types.name AS category_type_name','shop_name','smart_card_number'];
        $filename = 'sale_record.xlsx';
        $senderemail = 'aungmyatmin284@gmail.com';
        $limit       = 5000;  //Optional 
        
       //# This parameter($limit) will decide to download your report from browser if your
       // report  data is less than your limit.if not so, it will send from email. 

        $subject     = 'Your email subject';

        $response = reportingProcess::process($filename,$columns,$senderemail,$limit, $subject , $extra, $main_table , $join_tables , $query);
        return $response;
    }
     

### Warning ### { You can install this package only via composer version-2.}