<?php 

namespace App\Http\Controllers;

use App\Http\Resources\Administrator\AdministratorResource;
use App\Models\User;
use App\Services\Administrator\AdministratorService;
use App\Utils\ErroMensage\ErroMensage;
use App\Utils\SuccessMessage\SuccessMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller  {

    private User $userModel;
    private AdministratorService $administratorService;

    public function __construct(User $userModel, AdministratorService $administratorService)
    {
        $this->userModel = $userModel;  
        $this->administratorService = $administratorService;
    }

    public function saveAdministrator(Request $request)
    {
        try {
            DB::beginTransaction();
            $administrator = $request->only($this->userModel->getModel()->getFillable());
            $administrator = $this->administratorService->manageSaveUserAdministrator($administrator);
            if ($administrator instanceof User) {
                DB::commit();
                return response()->json(new AdministratorResource($administrator), Response::HTTP_CREATED);
            }
            return response()->json($administrator, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function showAdministrator(Request $request)
    {
        $administrator = $this->administratorService->showUserAdministrator((int) $request->adm_id);
        if($administrator instanceof User)
           return response()->json(new AdministratorResource($administrator), Response::HTTP_OK);
        else 
        return response()->json($administrator, Response::HTTP_NOT_FOUND);   
    }

    public function updateAdministrator(Request $request)
    {
        try {
            DB::beginTransaction();
            $administrator = $request->only($this->userModel->getModel()->getFillable());
            $administrator = $this->administratorService->manageUpdateUserAdministrator($administrator);
            if ($administrator instanceof User) {
                DB::commit();
                return response()->json(new AdministratorResource($administrator), Response::HTTP_CREATED);
            }
            return response()->json($administrator, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function destroyAdministrator(Request $request)
    {
        try {
            $administrator = $this->administratorService->manageDeleteUserAdministrator((int) $request->adm_id);
            if(is_string($administrator)) { 
               DB::commit();
               return response()->json(SuccessMessage::sucessMessage($administrator), Response::HTTP_OK);
            } 
            DB::rollBack(); 
            return response()->json($administrator, Response::HTTP_NOT_FOUND); 
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }

    public function updatePicture(Request $request)
    {
        try {
            DB::beginTransaction();
            $administrator = $this->administratorService->manageUpdatePhotoPerfil((int) $request->id, $request->file());
            if ($administrator instanceof User) {
                DB::commit();
                return response()->json(new AdministratorResource($administrator), Response::HTTP_CREATED);
            }
            return response()->json($administrator, Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();
            return ErroMensage::errorMessage($e->getMessage(), $e->getCode());
        }
    }
}