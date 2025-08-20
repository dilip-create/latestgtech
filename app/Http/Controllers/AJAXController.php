<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Qrgenerater;
use App\Models\GatewayAccount;
use Illuminate\Support\Facades\Validator;

class AJAXController extends Controller
{
    // public function getRecord($id)
    // {
    //     $record = Qrgenerater::find($id);
    //     // print_r($record->customer_name); 
    //     return $record;
    // }

    // public function toggleStatus(Request $request)
    // {
    //         $gateway = GatewayAccount::find($request->id);

    //         if ($gateway) {
    //             $gateway->status = $request->status;
    //             $gateway->save();

    //             return response()->json(['success' => true]);
    //         }

    //         return response()->json(['success' => false], 404);
    // }

    // public function getgatewayAccountRecord($id)
    // {
    //     $record = GatewayAccount::find($id);
    //     // print_r($record->customer_name); 
    //     return $record;
    // }


    // public function saveGatewayAccountData(Request $request)
    // {
    //      $validatedData = $request->validate([
    //          'gateway_name' => 'required|string|max:255',
    //         'website_url' => 'required|url',
    //         'payment_method' => 'required|string',
    //     ]);
    //     // $request->validate([
    //     //     'gateway_name' => 'required|string|max:255',
    //     //     'website_url' => 'required|url',
    //     //     'payment_method' => 'required|string',
    //     // ]);
    //     echo "<pre>";  print_r($request->all()); die;
       

    //     $gateway = GatewayAccount::findOrFail($request->id);
    //     $gateway->update([
    //         'gateway_name' => $request->gateway_name,
    //         'website_url' => $request->website_url,
    //         'payment_method' => $request->payment_method,
    //     ]);

    //     return redirect()->back()->with('success', 'Gateway account updated successfully!');
    // }


}
