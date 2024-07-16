<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Admin\Models\CoachingTools;
use Illuminate\Support\Facades\Log;

class CoachingToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Wheel of Life',
            'Core Value',
            'Belief',
        ];

        foreach ($types as $type) {
            $existingType = CoachingTools::where('name', $type)->first();
    
            if (!$existingType) {
                CoachingTools::create([
                    'name' => $type,
                    'is_active' => true,
                ]);
            } else {
                Log::info("Activity Type already exists: $type");
            }
        }
    }
}
