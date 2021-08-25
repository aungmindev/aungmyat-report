<?php

namespace Aungmyat\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Aungmyat\Report\Exports\ReportExcelAm;
use Aungmyat\Report\Jobs\reportQueueAm;
use Aungmyat\Report\Mail\MailReportByAm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('report::report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendmail()
    {
  
        $query = 'select name,email from users';
        $filename = uniqid().'_ViberReport.xlsx';
        $columns = ['name','email'];
        $senderemail = 'ptech731@gmail.com';
        reportQueueAm::dispatch($query,$filename,$columns,$senderemail)
                    ->delay(now()->addSeconds(5));
        return view('report::mailsend');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
