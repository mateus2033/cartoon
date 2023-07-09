<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Services\Bank\BankService;

class BankController extends Controller
{

    protected $bank;
    protected $bankService;

    public function __construct(
        Bank $bank,
        BankService $bankService
    ){
        $this->bank = $bank;
        $this->bankService = $bankService;
    }

    public function index(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        //
    }

    public function storage(Request $request)
    {
        dd($request);
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
