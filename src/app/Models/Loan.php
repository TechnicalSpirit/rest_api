<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';
    protected $fillable = [
        'amount',
        'duration',
        'interest_rate'
    ];

    public static function getByFilters(array $data): Collection|array
    {
        $query = Loan::query();

        if (key_exists('created_at', $data)) {
            $query->whereDate('created_at', $data['created_at']);
        }
        if (key_exists('amount', $data)) {
            $query->where('amount', $data['amount']);
        }

        return $query->get();
    }
}
