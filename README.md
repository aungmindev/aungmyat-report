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
      use Aungmyat\Report\Process_provider\reportingProcess;
      public function method()

     {
  
        $query    = 'Your raw query as text';
        $filename = 'filename.xlsx';
        $columns  = ['name','email'];
        $senderemail  = 'blabla@gmail.com';
        $limit       = 0;  //Optional 
        
       //# This parameter($limit) will decide to download your report from browser if your
           report  data is less than your limit.if not so, it will send from email. 

        $subject     = 'Your email subject';

        return reportingProcess::process($query,$filename,$columns,$senderemail,$limit, $subject);
    }
     

### Warning ### { You can install this package only via composer version-2.}