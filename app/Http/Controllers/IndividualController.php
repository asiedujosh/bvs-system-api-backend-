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
use App\Models\RecordingTable;
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
        $recordingTable = new RecordingTable;

        $client->clientId = $request->clientId;
        $client->clientName = $request->clientName;
        $client->clientTel = $request->clientTel;
        $client->clientLocation = $request->clientLocation;
        $res = $client->save();

        if($res){
        $product->clientId = $request->clientId;
        $product->productId = $request->productId;
        $product->carType = $request->carType;
        $product->carColor = $request->carColor;
        $product->carImage = $request->imageUpload;
        $product->plateNo = $request->plateNo;
        $product->chasisNo = $request->chasisNo;
        $product->simNo = $request->simNo;
        $product->deviceNo = $request->deviceNo;
        $product->paymentMode = $request->paymentMode;
        $product->purchaseType = $request->purchaseType;
        $product->plateform = $request->plateform;
        $product->requestDate = $request->requestDate;
        $product->action = "pending";
        $res = $product->save();
        }

        $recordingTable->productId = $request->productId;
        $recordingTable->clientId = $request->clientId;
        $recordingTable->clientName = $request->clientName;
        $recordingTable->clientTel = $request->clientTel;
        $recordingTable->paymentMode = $request->paymentMode;
        $recordingTable->state = "pending";
        $recordingTable->save();
       
        if($res){
       return $this->success([
        'client' => $client,
        'product' => $product,
        'recording' => $recordingTable
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
        $product->carImage = $request->imageUpload;
        $product->plateNo = $request->plateNo;
        $product->chasisNo = $request->chasisNo;
        $product->simNo = $request->simNo;
        $product->deviceNo = $request->deviceNo;
        $product->paymentMode = $request->paymentMode;
        $product->purchaseType = $request->purchaseType;
        $product->plateform = $request->plateform;
        $product->requestDate = $request->requestDate;
        $product->action = "pending";
        $res = $product->save();
        

        $recordingTable->productId = $request->productId;
        $recordingTable->clientId = $request->clientId;
        $recordingTable->clientName = $request->clientName;
        $recordingTable->clientTel = $request->clientTel;
        $recordingTable->paymentMode = $request->paymentMode;
        $recordingTable->state = "pending";
        $recordingTable->save();
       
        if($res){
       return $this->success([
        'product' => $product
        ]);
        }
    }

    public function serviceStore(Request $request){
        $service = new Servicing;
        $status = new Status;
        $recordingTable = new RecordingTable;
        $service->productId = $request->productId;
        $service->startDate = $request->startDate;
        $service->dueDate = $request->dueDate;
        $service->amountPaid = $request->amountPaid;
        $service->serviceType = $request->serviceType;
        $res = $service->save();


        $formField = [
            'serviceOn' => $request->serviceType,
            'amtLastPaid' => $request->amountPaid,
            'lastPaid' => $request->startDate,
            'expiryDate' => $request->dueDate,
            'status' => $request->serviceType === "Installation" ? "online" : "offline"
        ];
          $res = RecordingTable::where('productId', $request->productId)->update($formField);
        

        if ($request->serviceType == "Installation" || $request->serviceType == "Removal") {
            // Your code for installation or removal service
            $productTechnician = new ProductTechnicianModel;
            $productTechnician->productId = $request->productId;
            $productTechnician->actionDate = $request->startDate;
            $productTechnician->supervisor = $request->supervisor;
            $productTechnician->technicalOfficer = $request->techOfficer;
            $productTechnician->serviceType = $request->serviceType;
            $productTechnician->save();
            $formField2 = [
                'status' => $request->serviceType === "Installation" ? "online" : "offline"
            ];
           
            $res = RecordingTable::where('productId', $request->productId)->update($formField2);
        }

            $status->productId = $request->productId;
            $status->status = $request->serviceType === "Installation" ? "online" : "offline";
            $status->save();        
          
        return $this->success([
            'service' => $service,
            'status' => $status
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
        $res = RecordingTable::paginate();
        return $this->success([
            'dashTable' => $res
            ]);
    }


    public function allServices(Request $request){
        $res = Servicing::all();
        return $this->success([
            'services' => $res
        ]);
    }

}
