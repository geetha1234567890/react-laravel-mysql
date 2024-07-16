<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Models\CoachingTemplateActivityType;

class TemplateActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'videos',
            'pdf',
            'link',
            'virtual meet',
            'test'
        ];
    
        foreach ($types as $type) {
            // Check if the record already exists
            $existingType = CoachingTemplateActivityType::where('type_name', $type)->first();
    
            if (!$existingType) {
                CoachingTemplateActivityType::create([
                    'type_name' => $type,
                    'is_active' => true,
                ]);
    
                Log::info("Created Activity Type: $type");
            } else {
                Log::info("Activity Type already exists: $type");
            }
        }

    }
}
