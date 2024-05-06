<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Validators\LoanValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Loan::query();

        if ($request->has('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }
        if ($request->has('amount')) {
            $query->where('amount', $request->amount);
        }

        $loans = $query->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $validatedData = LoanValidator::validate($request->all());
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }

        $loan = Loan::create($validatedData);

        return response()->json([
            'loan' => $loan
        ]);
    }

    public function show($id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Loan not found'
            ], 404);
        }

        return response()->json([
            'loan' => $loan
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Loan not found'
            ], 404);
        }

        try {
            $validatedData = LoanValidator::validate($request->all());
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }

        $loan->update($validatedData);

        return response()->json([
                'loan' => $loan
            ]);
    }

    public function destroy($id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Loan not found'
            ], 404);
        }

        $loan->delete();

        return response()->json([
            'message' => 'Loan deleted successfully'
        ]);
    }
}
