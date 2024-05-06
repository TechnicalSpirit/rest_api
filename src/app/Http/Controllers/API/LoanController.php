<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Validators\LoanValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'loans' => Loan::getByFilters($request->all())
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

        return response()->json(['loan' => $loan]);
    }

    public function show($id): JsonResponse
    {
        $loan = Loan::find($id);

        return $loan ?
            response()->json(['loan' => $loan]) :
            response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        try {
            $validatedData = LoanValidator::validate($request->all());
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }

        $loan->update($validatedData);

        return response()->json(['loan' => $loan]);
    }

    public function destroy($id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $loan->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
