<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Utils\ErroMensage\ErroMensage;
use App\Services\Address\AddressService;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressUserResource;

class AddressController extends Controller
{

    private Address $addressModel;
    private AddressService $addressService;

    public function __construct(
        Address $addressModel,  
        AddressService $addressService
    ){
        $this->addressModel   = $addressModel;
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    { 
        $user_id  = (int) $request->user_id;
        $response = $this->addressService->listAddress($user_id);
        if(!is_array($response))
        {
            return response()->json(new AddressUserResource($response), Response::HTTP_OK);
        }
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
 
    public function storage(Request $request)
    {
        try{
            $address = $request->only($this->addressModel->getModel()->getFillable());
            $address = $this->addressService->manageStorageAddress($address);
            if($address instanceof Address) {
                return response()->json($this->responseAddress($address), Response::HTTP_CREATED);
            }
            
            return response()->json($address, Response::HTTP_BAD_REQUEST);
        }catch(Exception $e) {
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode()); 
        }
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $address = $request->only($this->addressModel->getModel()->getFillable());
            $address = $this->addressService->manageUpdateAddress($address);
            if($address instanceof Address) {
                return response()->json($this->responseAddress($address), Response::HTTP_CREATED);
            }
            return response()->json($address, Response::HTTP_BAD_REQUEST);
        }catch(Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode()); 
        }
    }

    public function destroy(Request $request)
    {       
        try{
            $address_id = (int) $request->id;
            $user_id    = (int) $request->user_id;
            $response   = $this->addressService->manageDeleteAddress($address_id, $user_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(Exception $e) {
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode()); 
        }
    }

    private function responseAddress(Address $address) 
    {
        DB::commit();
        $address = new AddressResource($address);
        return $address;
    }
}
