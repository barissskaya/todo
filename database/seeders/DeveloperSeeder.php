<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Developer::insert(
                [
                    [
                        'name' => 'DEV-1', 
                        'level' => 1
                    ],
                    [
                        'name' => 'DEV-2', 
                        'level' => 2
                    ],
                    [
                        'name' => 'DEV-3', 
                        'level' => 3
                    ],
                    [
                        'name' => 'DEV-4', 
                        'level' => 4
                    ],
                    [
                        'name' => 'DEV-5', 
                        'level' => 5
                    ] 
                ]
        );
    }
}
