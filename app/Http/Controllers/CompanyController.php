<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\CompanyModel;
use App\Models\CompanyRecordingTable;

class CompanyController extends Controller
{
    use HttpResponses;
    //
    public function companyAll(){
        $companies = CompanyModel::all();
        return $this->success([ 
            'company' => $companies
        ]);
    }


    public function companyRecordTable(){
        $companyRecord =  CompanyRecordingTable::all();
        return $this->success([
            'companyRecord' => $companyRecord
        ]);
    }


    public function companyStore(Request $request){
        $company = new CompanyModel;
        $company->companyName = $request->companyName;
        $company->companyTel = $request->companyTel;
        $company->companyAddress = $request->companyAddress;
        $company->companyEmail = $request->companyEmail;
        $company->relationOfficer = $request->relationOfficer;
        $company->officerPosition = $request->officerPosition;
        $company->officerTel = $request->officerTel;
        $res = $company->save();
        if($res){
            return $this->success([ 
                'company' => $company
            ], $message = "Company stored successfully");
        }
    }
    

    public function companyProfile($id){
        $res = CompanyModel::where('id', $id)->first();
        return $this->success([
            'companyProfile' => $res
        ]);
    }


    public function companySearch(Request $request){
        $results = CompanyModel::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'company' => $results
        ]);
    }


    public function companyUpdate(Request $request, $id){
        $formField = [
            'companyName' => $request->companyName,
            'companyTel' => $request->companyTel,
            'companyAddress' => $request->companyAddress,
            'companyEmail' => $request->companyEmail,
            'relationOfficer' => $request->relationOfficer,
            'officerPosition' => $request->officerPosition,
            'officerTel' => $request->officerTel
        ];
        $res = CompanyModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'message' => "Company Updated Successfully"
            ]);
        }
    }

    public function companyDelete($id){
        $res = CompanyModel::where('id', $id)->delete();
        if($res){
            return $this->success([
                'message' => "Company deleted Successfully"
            ]);
        }
    }
}
