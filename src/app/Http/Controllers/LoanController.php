<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'loans' => $loans
        ], 200);
    }

    public function create(Request $request)
    {


        $loan = Loan::create($request->all());

        return response()->json([
            'loan' => $loan
        ]);
    }

    public function show($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['error' => 'Loan not found'], 404);
        }

        return response()->json([
            'loan' => $loan
        ]);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Loan not found'
            ], 404);
        }



        $loan->update($request->all());

        return response()->json(
            [
                'loan' => $loan
            ]);
    }

    public function destroy($id)
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
