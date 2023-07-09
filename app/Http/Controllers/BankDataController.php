<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Bank;
use App\Models\BankData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Utils\ErroMensage\ErroMensage;
use App\Services\BankData\BankDataService;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\BankData\BankDataIndexResource;
use App\Http\Resources\BankData\BankDataShowResource;
use App\Http\Resources\BankData\BankDataStorageResource;
use App\Utils\ConstantMessage\bankData\BankDataMessage;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\SuccessMessage\SuccessMessage;

class BankDataController extends Controller
{
    private Bank $bankModel;
    private BankData $bankDataModel;
    private BankDataService $bankDataService;

    public function __construct(
        Bank $bankModel,
        BankData $bankDataModel,
        BankDataService $bankDataService
    ) {
        $this->bankModel   = $bankModel;
        $this->bankDataModel = $bankDataModel;
        $this->bankDataService = $bankDataService;
    }

    public function index(Request $request)
    {   
        $response = $this->bankDataService->index($request->page);
        if ($response instanceof Collection)
            return response()->json(new BankDataIndexResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function show(Request $request)
    {
        $bankDataId = (int) $request->id;
        $response = $this->bankDataService->showBankDataById($bankDataId);
        if ($response instanceof BankData)
            return response()->json(new BankDataShowResource($response), Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_NOT_FOUND);
    }

    public function storage(Request $request)
    {
        try {
            DB::beginTransaction();
            $bank = $request->only($this->bankModel->getModel()->getFillable());
            $bankData = $request->only($this->bankDataModel->getModel()->getFillable());
            $bankData = $this->bankDataService->manageStorageBankData($bankData, $bank);
            if ($bankData instanceof BankData) {
                DB::commit();
                return response()->json(new BankDataStorageResource($bankData), Response::HTTP_CREATED);
            }
            return response()->json($bankData, Response::HTTP_BAD_REQUEST);
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
        try {
            DB::beginTransaction();
            $user_id     = (int) $request->user_id;
            $bankdata_id = (int) $request->bankdata_id;
            $response = $this->bankDataService->destroy($bankdata_id, $user_id);
            if (is_bool($response)) {
                DB::commit();
                return response()->json(SuccessMessage::sucessMessage(BankDataMessage::BANK_DATA_DELETED), Response::HTTP_OK);
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }
}
