<?php

namespace App\Http\Controllers;

use App\Events\CsvUploadedEvent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('home');
  }
  public function fileUpload()
  {
    // $fileName =  basename(request('file')->store('public/csv'));
    // $filePath = asset('storage/csv/' . $fileName);
    $fileName = "storage/csv/elC2ZIlevIQ2GjmITKOVMek7y5b1cp6PrxLpYb25.csv";
    CsvUploadedEvent::dispatch($fileName);
    return $fileName;
  }
}
