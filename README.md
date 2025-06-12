#This is report system

#There are 4 simple steps to complete this package after installing.

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
        $extra = null;
        $filename = 'sale_record.xlsx';
        $columns  = ['vehicle_license_number','liter','amount','vehicle_types.name AS category_type_name','shop_name','smart_card_number'];
        $senderemail = 'aungmyatmin284@gmail.com';
        $limit       = 5000;  //Optional 
        
       //# This parameter($limit) will decide to download your report from browser if your
       // report  data is less than your limit.if not so, it will send from email. 

        $subject     = 'Your email subject';

        $response = reportingProcess::process($filename,$columns,$senderemail,$limit, $subject , $extra, $main_table , $join_tables);
        return $response;
    }
     

### Warning ### { You can install this package only via composer version-2.}