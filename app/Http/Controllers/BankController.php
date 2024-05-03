<?php

namespace App\Http\Controllers;

use App\Http\Resources\Bank\BankIndexResource;
use App\Http\Resources\Bank\BankStorageResource;
use App\Http\Resources\Bank\BankUpdateResource;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Services\Bank\BankService;
use App\Utils\ConstantMessage\bank\BankMessage;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{

    protected $bank;
    protected $bankService;

    public function __construct(
        Bank $bank,
        BankService $bankService
    ) {
        $this->bank = $bank;
        $this->bankService = $bankService;
    }

    public function index(Request $request)
    {
        $response = $this->bankService->index($request);
        if ($response instanceof Collection)
            return response()->json(new BankIndexResource($response),  Response::HTTP_OK);
        else
            return response()->json($response, Response::HTTP_OK);
    }

    public function show(Request $request)
    {
        //
    }

    public function storage(Request $request)
    {
        try {
            $bank = $request->only($this->bank->getModel()->getFillable());
            $bank = $this->bankService->manageStorageBank($bank);
            if ($bank instanceof Bank) {
                DB::commit();
                return response()->json(new BankStorageResource($bank), Response::HTTP_CREATED);
            }
            DB::rollBack();
            return response()->json($bank, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $bank = $request->only($this->bank->getModel()->getFillable());
            $bank = $this->bankService->manageUpdateBank($bank);
            if ($bank instanceof Bank) {
                DB::commit();
                return response()->json(new BankUpdateResource($bank), Response::HTTP_OK);
            }
            DB::rollBack();
            return response()->json($bank, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        try {
            $bank_id = (int) $request->bank_id;
            $response = $this->bankService->manageDeleteBank($bank_id);
            if (is_bool($response)) {
                DB::commit();
                return response()->json(SuccessMessage::sucessMessage(BankMessage::BANK_DELETED), Response::HTTP_OK);
            }
            DB::rollBack();
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }
}
