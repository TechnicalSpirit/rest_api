<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        // Логика для получения списка всех займов
    }

    public function create(Request $request)
    {
        // Логика для создания нового займа
    }

    public function show($id)
    {
        // Логика для получения информации о займе
    }

    public function update(Request $request, $id)
    {
        // Логика для обновления информации о займе
    }

    public function destroy($id)
    {
        // Логика для удаления займа
    }
}
