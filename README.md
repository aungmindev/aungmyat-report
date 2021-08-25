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
      public function method()
    {
  
        $query    = 'Your raw query as text';
        $filename = 'filename;
        $columns  = ['name','email'];
        $senderemail  = 'blabla@gmail.com;

        reportQueueAm::dispatch($query,$filename,$columns,$senderrmail)->delay(now()->addSeconds(5));
        return 'something';
    }
     

### Warning ### { You can install this package only via composer version-2.}