<?php

namespace App\Http\Controllers;

use App\Http\Resources\Enterprise\EnterpriseShowResource;
use Exception;
use App\Models\Enterprise;
use App\Services\Enterprise\EnterpriseService;
use App\Utils\ErroMensage\ErroMensage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Enterprise\EnterpriseStorageResource;
use Ramsey\Collection\Collection;

class EnterpriseController extends Controller
{
    private Enterprise $enterpriseModel;
    private EnterpriseService $enterpriseService;

    public function __construct(
        Enterprise $enterpriseModel,
        EnterpriseService $enterpriseService
    ) {
        $this->enterpriseModel = $enterpriseModel;
        $this->enterpriseService = $enterpriseService;
    }

    public function show(Request $request)
    {   
        $enterprise_id = (int) $request->id;
        $response = $this->enterpriseService->show($enterprise_id);
        if ($response instanceof Collection)
            return response()->json(new EnterpriseShowResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function storage(Request $request)
    {
        try {
            DB::beginTransaction();
            $address[]  = $request->address;
            $enterprise = $request->only($this->enterpriseModel->getModel()->getFillable());
            $enterprise = $this->enterpriseService->manageStorageEnterprise($enterprise, $address);
            if ($enterprise instanceof Enterprise) {
                return response()->json(new EnterpriseStorageResource($enterprise), Response::HTTP_CREATED);
            }
            return response()->json($enterprise, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        //
    }

    public function delete(Request $request)
    {
        //
    }
}
