<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RichPayController extends Controller
{
    public function payin(Request $request)
    {
        echo "<pre>";  print_r($request->all()); die;
    }
}
