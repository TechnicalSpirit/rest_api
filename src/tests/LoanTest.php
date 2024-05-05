<?php

namespace Tests;

use App\Models\Loan;

class LoanTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/loans')
            ->seeStatusCode(200)
            ->seeJsonStructure(['loans' => [
                        '*' => [
                            'id',
                            'amount',
                            'duration',
                            'interest_rate',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }
    public function testCreate()
    {
        $this->post('/loans', [
                'amount' => 1000,
                'duration' => 12,
                'interest_rate' => 5.5,
            ])
            ->seeStatusCode(200)
            ->seeJsonStructure(['loan' => [
                    'id',
                    'amount',
                    'duration',
                    'interest_rate',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testShow()
    {
        $loan = Loan::factory()->create();

        $this->get("/loans/{$loan->id}")
            ->seeStatusCode(200)
            ->seeJsonStructure(['loan' => [
                    'id',
                    'amount',
                    'duration',
                    'interest_rate',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
    public function testUpdateSuccess()
    {
        $loan = Loan::factory()->create();

        $this->put("/loans/1", [
                'amount' => 1200,
            ])
            ->seeStatusCode(200)
            ->seeJsonStructure(['loan' => [
                    'id',
                    'amount',
                    'duration',
                    'interest_rate',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testUpdateNoItemNoTInTheTable()
    {
        $this->put("/loans/-1", [
            'amount' => 1200,
        ])
        ->seeStatusCode(404)
        ->seeJson([
            'message' => 'Loan not found'
        ]);
    }
    public function testDestroySuccess()
    {
        $loan = Loan::factory()->create();

        $this->delete("/loans/{$loan->id}")
            ->seeStatusCode(200)
            ->seeJson([
                'message' => 'Loan deleted successfully'
            ]);
    }

    public function testDestroyItemNoTInTheTable()
    {
        $this->delete("/loans/-1")
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'Loan not found'
            ]);
    }
}
