<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\PackageModel;

class PackageController extends Controller
{
    use HttpResponses;
     //
     public function packageAll(){
        $packagies = PackageModel::all();
        return $this->success([
            'package' => $packagies
        ]);
    }


    public function packageStore(Request $request){
        $package = new PackageModel;
        $package->packageName = $request->packageName;
        $package->packagePrice = $request->packagePrice;
        $package->packageMonth = $request->packageMonth;
        $package->packageDetails = $request->packageDetails;
        $res = $package->save();
        if($res){
            return $this->success([ 
                'package' => $package,
                'message' => "Package stored successfully"
            ]);
        }
    }
    

    public function packageProfile($id){
        $res = PackageModel::where('id', $id)->first();
        return $this->success([
            'packageProfile' => $res
        ]);
    }


    public function packageSearch(Request $request){
        $results = PackageModel::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'package' => $results
        ]);
    }


    public function packageUpdate(Request $request, $id){
        $formField = [
            'packageName' => $request->packageName,
            'packagePrice' => $request->packagePrice,
            'packageDetails' => $request->packageDetails
        ];
        $res = PackageModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'message' => "Package Updated Successfully"
            ]);
        }
    }

    public function packageDelete($id){
        $res = PackageModel::where('id', $id)->delete();
        return $this->success([
            'message' => "Package deleted Successfully"
        ]);
    }
}
