<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        TransactionService $transactionService
    ) {
        $this->transactionService = $transactionService;
    }

    /**
    * @api {post} /transactions transactions
    * @apiDescription Route for performing transactions between accounts
    * @apiHeader {String} ContentType=application/json;charset=UTF-8 ContentType
    * @apiHeader {String} Accept=application/json;charset=UTF-8 Accept
    * @apiVersion 1.0.0
    * @apiName transactions
    * @apiGroup transactions
    *
    * @apiParam {String} payer Identifier of the wallet from which the transfer will be made
    * @apiParam {String} payee Identifier of the wallet that will receive the transfer amount
    * @apiParam {Float} value transfer amount
    *
    *
    * @apiSuccessExample Success-Response:
    * HTTP/1.1 200 OK
    * {
    *  "code": 200,
    *  "isSuccess": true,
    *  "message": "Transaction successfy"
    * }
    *
    * @apiErrorExample Error-Response:
    *   HTTP/1.1 404 Not Found
    *  {
    *     "code": 404,
    *     "isSuccess": false,
    *     "message": "Wallet not found"
    *  }
    *   HTTP/1.1 500 Not Found
    *  {
    *     "code": 500,
    *     "isSuccess": false,
    *     "message": "Insufficient balance"
    *  }
    *  {
    *     "code": 500,
    *     "isSuccess": false,
    *     "message": "Transaction not successfy"
    *  }
    *
    *
    */
    public function transactions(Request $request)
    {
        $this->validate($request, [
            'payer' => "required|string",
            'payee' => "required|string",
            'value' => 'required|numeric|not_in:0'
        ]);

        $result = $this->transactionService->transfer(
            $request->payer,
            $request->payee,
            $request->value
        );

        return response()->json($result, $result['code']);
    }
}
