<?php

namespace Database\Seeders;

use App\Models\Contractor;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ContractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contractor::factory()
            ->count(5)
            ->has(
                Tenant::factory()
                    ->state(function(array $attribute, Contractor $contractor) {
                        return [
                            'tenantable_id' => $contractor->id,
                            'tenantable_type' => Contractor::class,
                        ];
                    })
            )
            ->create();
    }
}
