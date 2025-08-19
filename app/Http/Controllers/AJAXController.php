<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Qrgenerater;
use App\Models\GatewayAccount;

class AJAXController extends Controller
{
    public function getRecord($id)
    {
        $record = Qrgenerater::find($id);
        // print_r($record->customer_name); 
        return $record;
    }

    public function toggleStatus(Request $request)
    {
            $gateway = GatewayAccount::find($request->id);

            if ($gateway) {
                $gateway->status = $request->status;
                $gateway->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false], 404);
    }


}
