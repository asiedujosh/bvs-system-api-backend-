<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\CompanyPermissionModel;
use App\Models\PackagePermissionModel;
use App\Models\ProductPermissionModel;
use App\Models\ServicePermissionModel;
use App\Models\UserPermissionModel;

class AccessControlController extends Controller
{
    use HttpResponses;
    //
    public function roleStore(Request $request){
        $role = new RoleModel;
        $role->role = $request->role_id;
        $res = $role->save();

        if($res){
            $roleInfo = RoleModel::where('role', $request->role_id)->first();
           // return $roleInfo;
            $companyPermission = new CompanyPermissionModel;
            $companyPermission->role_id = $roleInfo->id;
            $companyPermission->view = false;
            $companyPermission->create = false;
            $companyPermission->update = false;
            $companyPermission->delete = false;
            $companyPermission->save();

            $permission = new PermissionModel;
            $permission->role_id = $roleInfo->id;
            $permission->view = false;
            $permission->create = false;
            $permission->update = false;
            $permission->delete = false;
            $permission->save();

            $packagePermission = new PackagePermissionModel;
            $packagePermission->role_id = $roleInfo->id;
            $packagePermission->view = false;
            $packagePermission->create = false;
            $packagePermission->update = false;
            $packagePermission->delete = false;
            $packagePermission->save();

            $userPermission = new UserPermissionModel;
            $userPermission->role_id = $roleInfo->id;
            $userPermission->view = false;
            $userPermission->create = false;
            $userPermission->update = false;
            $userPermission->delete = false;
            $userPermission->save();

            $servicePermission = new ServicePermissionModel;
            $servicePermission->role_id = $roleInfo->id;
            $servicePermission->view = false;
            $servicePermission->create = false;
            $servicePermission->update = false;
            $servicePermission->delete = false;
            $servicePermission->save();

            $productPermission = new ProductPermissionModel;
            $productPermission->role_id = $roleInfo->id;
            $productPermission->view = false;
            $productPermission->create = false;
            $productPermission->update = false;
            $productPermission->delete = false;
            $productPermission->save();
        }

        return $this->success([
            'res' => $res
            ]);
    }

    public function getAllRole(){
        $allRole = RoleModel::all();
        return $this->success([
            'allRole' => $allRole
            ]);
    }

    public function getAllClientPermission(){
        $clientPermission = PermissionModel::all();
        return $this->success([
            'clientPermission' => $clientPermission
        ]);
    }

    public function getSingleClientPermission($id){
        $singleClientPermission = PermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singleClientPermission' => $singleClientPermission
        ]);
    }

    public function getAllCompanyPermission(){
        $companyPermission = CompanyPermissionModel::all();
        return $this->success([
            'companyPermission' => $companyPermission
        ]);
    }

    public function getSingleCompanyPermission($id){
        $singleCompanyPermission = CompanyPermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singleCompanyPermission' =>  $singleCompanyPermission
        ]);
    }

    public function getAllPackagePermission(){
        $packagePermission = PackagePermissionModel::all();
        return $this->success([
            'packagePermission' => $packagePermission
        ]);
    }

    public function getSinglePackagePermission($id){
        $singlePackagePermission = PackagePermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singlePackagePermission' =>  $singlePackagePermission
        ]);
    }

    public function getAllUserPermission(){
        $userPermission = UserPermissionModel::all();
        return $this->success([
            'userPermission' => $userPermission
        ]);
    }

    public function getSingleUserPermission($id){
        $singleUserPermission = UserPermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singleUserPermission' => $singleUserPermission
        ]);
    }


    public function getAllServicePermission(){
        $servicePermission = ServicePermissionModel::all();
        return $this->success([
            'servicePermission' => $servicePermission
        ]);
    }

    public function getSingleServicePermission($id){
        $singleServicePermission = ServicePermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singleServicePermission' => $singleServicePermission
        ]);
    }


    public function getAllProductPermission(){
        $productPermission = ProductPermissionModel::all();
        return $this->success([
            'productPermission' => $productPermission
        ]);
    }

    public function getSingleProductPermission($id){
        $singleProductPermission = ProductPermissionModel::where('role_id', $id)->first();
        return $this->success([
            'singleProductPermission' => $singleProductPermission
        ]);
    }


    public function updatePermission(Request $request){
        $roleId = $request->role['id'];
       // return $roleId;
        $data = $request->permissionData;
        // // Find the object with the specified label
        foreach ($data as &$item) {
                switch ($item['label']) {
                    case 'Users':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        UserPermissionModel::where('role_id', $roleId)->update($formField);
                        break;
                    
                    case 'Package':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        PackagePermissionModel::where('role_id', $roleId)->update($formField);
                        break;
                    
                    case 'Clients':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        PermissionModel::where('role_id', $roleId)->update($formField);
                        break;
                    
                    case 'Company':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        CompanyPermissionModel::where('role_id', $roleId)->update($formField);
                        break;

                    case 'Product':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        ProductPermissionModel::where('role_id', $roleId)->update($formField);
                        break;

                    case 'Service':
                        $formField = [
                            'view' => $item['read'],
                            'create' => $item['create'],
                            'update' => $item['update'],
                            'delete' => $item['delete']
                        ];
                        ServicePermissionModel::where('role_id', $roleId)->update($formField);
                        break;
                    
                    default:
                        echo 'Default processing';
                        break;
                }
            }
            return $this->success([
                'permissionUpdate' => "Update successful"
            ]);

    }

    public function deleteRole($id){
        $roleId = $id;
        $res = RoleModel::where('id', $roleId)->delete();
        $res = PermissionModel::where('role_id', $roleId)->delete();
        $res = PackagePermissionModel::where('role_id', $roleId)->delete();
        $res = CompanyPermissionModel::where('role_id', $roleId)->delete();
        $res = UserPermissionModel::where('role_id', $roleId)->delete();
        $res = ProductPermissionModel::where('role_id', $roleId)->delete();
        $res = ServicePermissionModel::where('role_id', $roleId)->delete();

        return $this->success([
            'res' => $res
        ]);
    }
}
