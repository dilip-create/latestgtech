<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Qrgenerater;

class AJAXController extends Controller
{
    public function getRecord($id)
    {
        $record = Qrgenerater::find($id);
        // print_r($record->customer_name); 
        return $record;
    }

}
