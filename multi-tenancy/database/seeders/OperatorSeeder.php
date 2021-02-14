<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operator::factory()
            ->count(5)
            ->has(
                Tenant::factory()
                    ->state(function(array $attribute, Operator $operator) {
                        return [
                            'tenantable_id' => $operator->id,
                            'tenantable_type' => Operator::class,
                        ];
                    })
            )
            ->create();
    }
}
