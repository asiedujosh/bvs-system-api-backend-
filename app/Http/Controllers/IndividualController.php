<?php

namespace App\Http\Controllers;
//use App\Constants\ProductConstants;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Client;
use App\Models\Product;
use App\Models\Servicing;
use App\Models\Status;
use App\Models\ProductTechnicianModel;
use App\Models\CompanyModel;
use App\Models\CompanyRecordingTable;
use App\Models\RecordingTable;
use App\Models\historyRecordingTable;
use App\Http\Requests\AddIndividualRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IndividualController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $user = User::all();
        return $this->success([
            'user' => $user
           ]);
    }

   
    public function search(Request $request) {
        // $keyword = $request->input('keyword');
        $results = RecordingTable::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'dashTable' => $results
           ]);
    }
    

    public function store(Request $request){
       // Log::info($request);
        //$request->validated($request->all());
        $client = new Client;
        $product = new Product;
        $companyRecordingTable = new CompanyRecordingTable;
        $recordingTable = new RecordingTable;
        $historyRecordingTable = new historyRecordingTable;
        $servicing = new Servicing;

        $client->clientId = $request->clientId;
        $client->clientName = $request->clientName;
        $client->clientTel = $request->clientTel;
        $client->clientLocation = $request->clientLocation;
        $res = $client->save();

        if($res){
        $product->clientId = $request->clientId;
        $product->productId = $request->productId;
        $product->carType = $request->carType;
        $product->carBrand = $request->carBrand;
        $product->carColor = $request->carColor;
        $product->carImage = $request->imageUpload;
        $product->plateNo = $request->plateNo;
        $product->chasisNo = $request->chasisNo;
        $product->simNo = $request->simNo;
        $product->deviceNo = $request->deviceNo;
        $product->purchaseType = $request->purchaseType;
        $product->package = $request->package;
        $product->technicalOfficer = $request->technicalOfficer;
        $product->plateform = $request->plateform;
        $product->startDate = $request->startDate;
        $product->action = "active";
        $res = $product->save();
        }

        $servicing->productId = $request->productId;
        $servicing->startDate = $request->startDate;
        $servicing->expireDate = $request->expireDate;
        $servicing->amtPaid = floatval($request->amtPaid);
        $res = $servicing->save();

        $company = CompanyModel::where('companyName', $request->companyName)->first();
        $companyId = $request->associate == "Company" ? $company->id : null;

        if($request->associate == "Company"){
            $companyRec = CompanyRecordingTable::where('companyName', $companyId)->get();
            if (count($companyRec) == 0) {
                $companyRecordingTable->companyName = $companyId;
                $companyRecordingTable->totalProducts = "1";
                $companyRecordingTable->save();
                } else {
                $newData = $companyRec[0]->totalProducts + 1;
                $formField = [
                    'totalProducts' => $newData,
                ];
                  $res = CompanyRecordingTable::where('companyName', $companyId)->update($formField);
                }
            }

            $historyRecordingTable->productId = $request->productId;
            $historyRecordingTable->clientId = $request->clientId;
            $historyRecordingTable->associate = $request->associate;
            $historyRecordingTable->clientName = $request->clientName;
            $historyRecordingTable->clientLocation = $request->clientLocation;
            $historyRecordingTable->clientTel = $request->clientTel;
            $historyRecordingTable->companyName = $companyId;
            $historyRecordingTable->package = $request->package;
            $historyRecordingTable->startDate = $request->startDate;
            $historyRecordingTable->expireDate = $request->expireDate;
            $historyRecordingTable->status = "install";
            $historyRecordingTable->state = "active";
            $res = $historyRecordingTable->save();

            if($res){
            $recordingTable->productId = $request->productId;
            $recordingTable->clientId = $request->clientId;
            $recordingTable->associate = $request->associate;
            $recordingTable->clientName = $request->clientName;
            $recordingTable->clientLocation = $request->clientLocation;
            $recordingTable->clientTel = $request->clientTel;
            $recordingTable->companyName = $companyId;
            $recordingTable->package = $request->package;
            $recordingTable->startDate = $request->startDate;
            $recordingTable->expireDate = $request->expireDate;
            $recordingTable->status = "install";
            $recordingTable->state = "active";
            $res = $recordingTable->save();
            }
       
            if($res){
            return $this->success([
            'client' => $client,
            'product' => $product,
            'recording' => $recordingTable
            ]);
            }
    }

    public function updateClient(Request $request, $id){
        $formField = [
            'clientName' => $request->clientName,
            'clientTel' => $request->clientTel,
            'clientLocation' => $request->clientLocation
        ];

        $res = Client::where('clientId', $id)->update($formField);
        $res2 = RecordingTable::where('clientId', $id)->update($formField);
        $res3 = historyRecordingTable::where('clientId', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function updateProduct(Request $request, $id){
        $formField = [
            'carType' => $request->carType,
            'carBrand' => $request->carBrand,
            'carColor' => $request->carColor,
            'carImage' => $request->carImage,
            'plateNo' => $request->plateNo,
            'chasisNo' => $request->chasisNo,
            'simNo' => $request->simNo,
            'deviceNo' => $request->deviceNo,
            'technicalOfficer' => $request->technicalOfficer
        ];

        $res = Product::where('productId', $id)->update($formField);
        if($res){
            return $this->success([
            'data' => $res
            ]);
        }
    }

    public function deactivateProduct(Request $request, $id){
        $formField = [
            'action' => "deactive"
        ];

        $res = Product::where('productId', $id)->update($formField);
        $res2 = RecordingTable::where('productId', $id)->update($formField);
        $res3 = historyRecordingTable::where('productId', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function reactivateProduct(Request $request, $id){
        $formField = [
            'action' => 'active'
        ];

        $res = Product::where('productId', $id)->update($formField);
        $res2 = RecordingTable::where('productId', $id)->update($formField);
        $res3 = historyRecordingTable::where('productId', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function productStore(Request $request){
        $product = new Product;
        $recordingTable = new RecordingTable;
        $product->clientId = $request->clientId;
        $product->productId = $request->productId;
        $product->carType = $request->carType;
        $product->carColor = $request->carColor;
        $product->carBrand = $request->carBrand;
        $product->carImage = $request->imageUpload;
        $product->plateNo = $request->plateNo;
        $product->chasisNo = $request->chasisNo;
        $product->simNo = $request->simNo;
        $product->deviceNo = $request->deviceNo;
        $product->purchaseType = $request->purchaseType;
        $product->package = $request->package;
        $product->technicalOfficer = $request->technicalOfficer;
        $product->plateform = $request->plateform;
        $product->startDate = $request->startDate;
        $product->action = "active";
        $res = $product->save();

        $servicing->productId = $request->productId;
        $servicing->startDate = $request->startDate;
        $servicing->expireDate = $request->expireDate;
        $servicing->amtPaid = floatval($request->amtPaid);
        $res = $servicing->save();

        $recordingTable->productId = $request->productId;
        $recordingTable->clientId = $request->clientId;
        $recordingTable->associate = $request->associate;
        $recordingTable->clientName = $request->clientName;
        $recordingTable->clientLocation = $request->clientLocation;
        $recordingTable->clientTel = $request->clientTel;
        $recordingTable->companyName = $request->companyName;
        $recordingTable->package = $request->package;
        $recordingTable->startDate = $request->startDate;
        $recordingTable->expireDate = $request->expireDate;
        $recordingTable->status = "install";
        $recordingTable->state = "active";
        $res = $recordingTable->save();

        $historyRecordingTable->productId = $request->productId;
        $historyRecordingTable->clientId = $request->clientId;
        $historyRecordingTable->associate = $request->associate;
        $historyRecordingTable->clientName = $request->clientName;
        $historyRecordingTable->clientLocation = $request->clientLocation;
        $historyRecordingTable->clientTel = $request->clientTel;
        $historyRecordingTable->companyName = $request->companyName;
        $historyRecordingTable->package = $request->package;
        $historyRecordingTable->startDate = $request->startDate;
        $historyRecordingTable->expireDate = $request->expireDate;
        $historyRecordingTable->status = "install";
        $historyRecordingTable->state = "active";
        $res = $historyRecordingTable->save();
       
        if($res){
       return $this->success([
        'product' => $product
        ]);
        }
    }

    public function serviceStore(Request $request){
        $service = new Servicing;
        $recordingTable = new RecordingTable;
        $historyRecordingTable = new historyRecordingTable;
        
        $service->productId = $request->productId;
        $service->startDate = $request->datePaid;
        $service->expireDate = $request->expireDate;
        $service->amtPaid = floatval($request->amtPaid);
        $res = $service->save();


        $recordingInfo = $recordingTable::where('productId', $request->productId)->first();

        if($recordingInfo){
        $historyRecordingTable->productId = $request->productId;
        $historyRecordingTable->clientId = $recordingInfo->clientId;
        $historyRecordingTable->associate = $recordingInfo->associate;
        $historyRecordingTable->clientName = $recordingInfo->clientName;
        $historyRecordingTable->clientLocation = $recordingInfo->clientLocation;
        $historyRecordingTable->clientTel = $recordingInfo->clientTel;
        $historyRecordingTable->companyName = $recordingInfo->companyName;
        $historyRecordingTable->package = $recordingInfo->package;
        $historyRecordingTable->startDate = $request->startDate;
        $historyRecordingTable->expireDate = $request->expireDate;
        $historyRecordingTable->status = "install";
        $historyRecordingTable->state = "active";
        $res = $historyRecordingTable->save();
        }

        $formField = [
            'startDate' => $request->startDate,
            'expireDate' => $request->expireDate
        ];
          $res = RecordingTable::where('productId', $request->productId)->update($formField);
                
          
        return $this->success([
            'service' => $service
            ]);
    }


    public function showClientProfile($id){
        $res = Client::where('clientId', $id)->first();
        return ([
            'client' => $res
        ]);
    }

    public function showProductsOfClient($id){
        $res = Product::where('clientId', $id)->get();
        return ([
            'products' => $res
        ]);
    }


    public function showRecordingTable(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $res = RecordingTable::paginate($perPage, ['*'], 'perPage', $pageNo);
        return $this->success([
            'dashTable' => $res,
            'pagination' => [
                'total' => $res->total(),
                'current_page' => $res->currentPage(),
                'last_page' => $res->lastPage(),
            ],
            ]);
    }

    public function dueRecordingTable(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $res = RecordingTable::paginate($perPage, ['*'], 'perPage', $pageNo);

        $data = [];
        foreach ($res as $resObject) {
            $result = checkExpiryDate($resObject->expireDate);
            if(!$result){
                array_push($data, $resObject);
            }
        }

        return $this->success([
            'dueData' => $data,
            'pagination' => [
                'total' => $res->total(),
                'current_page' => $res->currentPage(),
                'last_page' => $res->lastPage(),
            ],
        ]);

    }

    public function remindDueRecordTable(){
        $res = RecordingTable::all();
        $data = [];
        foreach ($res as $resObject) {
            $result = checkExpiryDate($resObject->expireDate);
            if(!$result){
                array_push($data, $resObject);
            }
        }

        return $this->success([
            'remindDueData' => $data
        ]);
    }

    public function remindAllRecordTable(){
        $res = RecordingTable::all();
        return $this->success([
            'remindAllData' => $res
        ]);
    }


    public function allServices(Request $request){
        $res = Servicing::all();
        return $this->success([
            'services' => $res
        ]);
    }

}
