<?php

namespace TestApi;

use App\Models\Loan;
use Tests\TestCase;

class LoanTest extends TestCase
{
    public function testGetAllLoans()
    {
        $currentLoanData = $this->get('/loans')
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

        $expectedLoanCount = count(Loan::all());
        $actualLoanCount = count($currentLoanData->response->json('loans'));

        $this->assertEquals($expectedLoanCount, $actualLoanCount);
    }

    public function testGetLoansByAmountAndCreatedAtFilters()
    {
        Loan::factory()->create([
            'amount' => 1000,
            'created_at' => '2022-01-01'
        ]);
        Loan::factory()->create([
            'amount' => 2000,
            'created_at' => '2022-01-02'
        ]);

        $currentLoanData = $this->get('/loans?created_at=2022-01-01&amount=1000')
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

        $expectedLoans = Loan::query()
            ->whereDate('created_at', '2022-01-01')
            ->where('amount', 1000)
            ->get();

        $expectedLoanCount = count($expectedLoans);
        $actualLoanCount = count($currentLoanData->response->json('loans'));

        $this->assertEquals($expectedLoanCount, $actualLoanCount);
    }

    public function testGetLoansByAmountFilter()
    {
        Loan::factory()->create([
            'amount' => 1000,
            'created_at' => '2022-01-01'
        ]);
        Loan::factory()->create([
            'amount' => 2000,
            'created_at' => '2022-01-02'
        ]);

        $currentLoanData = $this->get('/loans?amount=1000')
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

        $expectedLoans = Loan::query()
            ->where('amount', 1000)
            ->get();

        $expectedLoanCount = count($expectedLoans);
        $actualLoanCount = count($currentLoanData->response->json('loans'));

        $this->assertEquals($expectedLoanCount, $actualLoanCount);
    }

    public function testGetLoansByCreatedAtFilter()
    {
        Loan::factory()->create([
            'amount' => 1000,
            'created_at' => '2022-01-01'
        ]);
        Loan::factory()->create([
            'amount' => 2000,
            'created_at' => '2022-01-02'
        ]);

        $currentLoanData = $this->get('/loans?created_at=2022-01-01')
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

        $expectedLoans = Loan::query()
            ->whereDate('created_at', '2022-01-01')
            ->get();

        $expectedLoanCount = count($expectedLoans);
        $actualLoanCount = count($currentLoanData->response->json('loans'));

        $this->assertEquals($expectedLoanCount, $actualLoanCount);
    }

    public function testCreateSuccess()
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

    public function testCreateInvalidAmount()
    {
        $this->post('/loans', [
            'amount' => "InvalidData",
            'duration' => 12,
            'interest_rate' => 5.5,
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The amount must be a number.'
            ]);
    }

    public function testCreateInvalidDuration()
    {
        $this->post('/loans', [
            'amount' => 1000,
            'duration' => "InvalidData",
            'interest_rate' => 5.5,
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The duration must be an integer.'
            ]);
    }

    public function testCreateInvalidInterestRate()
    {
        $this->post('/loans', [
            'amount' => 1000,
            'duration' => 12,
            'interest_rate' => "InvalidData",
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The interest rate must be a number.'
            ]);
    }

    public function testShowSuccess()
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

    public function testShowItemNoTInTheTable()
    {
        $this->get("/loans/-1")
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'Loan not found'
            ]);
    }

    public function testUpdateSuccess()
    {
        $loan = Loan::factory()->create();

        $this->put("/loans/{$loan->id}", [
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

    public function testUpdateInvalidAmount()
    {
        $loan = Loan::factory()->create();

        $this->put("/loans/{$loan->id}", [
            'amount' => "InvalidData",
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The amount must be a number.'
            ]);
    }

    public function testUpdateInvalidDuration()
    {
        $loan = Loan::factory()->create();

        $this->put("/loans/{$loan->id}", [
            'duration' => "InvalidData",
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The duration must be an integer.'
            ]);
    }

    public function testUpdateInvalidInterestRate()
    {
        $loan = Loan::factory()->create();

        $this->put("/loans/{$loan->id}", [
            'interest_rate' => "InvalidData",
        ])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'The interest rate must be a number.'
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
