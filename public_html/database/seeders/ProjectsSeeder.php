<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\File;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Sandalwood Kyuna',
                'subtitle' => 'Luxury Living Spaces',
                'location' => 'Nairobi, Kenya',
                'status' => 'ongoing',
                'is_featured' => true,
            ],
            [
                'title' => 'Silver Terraces',
                'subtitle' => 'Luxury Living Spaces',
                'location' => 'Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Chilly Breezes',
                'subtitle' => 'Modern Comfort Homes',
                'location' => 'Kiambu, Kenya',
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'The Convex',
                'subtitle' => 'Contemporary Design',
                'location' => 'Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Sandalwood Othaya',
                'subtitle' => 'Serene Countryside Living',
                'location' => 'Othaya, Nyeri, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Sandalwood Brookside',
                'subtitle' => 'Urban Elegance',
                'location' => 'Brookside, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'Sandalwood Riverside',
                'subtitle' => 'Riverside Luxury Apartments',
                'location' => 'Riverside, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Sandalwood Lenana Road',
                'subtitle' => 'Prime Location Living',
                'location' => 'Lenana Road, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'Sandalwood Clyde Gardens',
                'subtitle' => 'Garden-Filled Community',
                'location' => 'Karen, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'Sandalwood Kitisuru',
                'subtitle' => 'Peaceful Suburban Homes',
                'location' => 'Kitisuru, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Sandalwood Waterfront',
                'subtitle' => 'Waterfront Living Experience',
                'location' => 'Waterfront, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'The Haven',
                'subtitle' => 'Your Perfect Retreat',
                'location' => 'Runda, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'The Colosseum Residences',
                'subtitle' => 'Grand Architectural Living',
                'location' => 'Westlands, Nairobi, Kenya',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Oak and Ivy',
                'subtitle' => 'Nature-Inspired Homes',
                'location' => 'Limuru, Kiambu, Kenya',
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'Sandalwood Loresho',
                'subtitle' => 'Exclusive Residential Enclave',
                'location' => 'Loresho, Nairobi, Kenya',
                'status' => 'ongoing',
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $projectData) {
            // Create the project
            $project = Project::create([
                'title' => $projectData['title'],
                'subtitle' => $projectData['subtitle'],
                'location' => $projectData['location'],
                'status' => $projectData['status'],
                'description' => fake()->sentence(10),
//                'description_location' => fake()->sentence(40),
                'slug' => Str::slug($projectData['title']),
                'is_featured' => $projectData['is_featured'],
            ]);

            // Attach a placeholder image using Spatie Media Library
            $this->attachPlaceholderImage($project, $projectData['title']);
        }
    }

    /**
     * Attach a placeholder image to a project using Spatie Media Library
     */
    private function attachPlaceholderImage(Project $project, string $title): void
    {
        // Path to your placeholder images
        $placeholderPath = storage_path('projects/' . strtolower(str_replace(' ', '_', $title)) . '.jpg');

        // If a custom image exists for this project, use it
        if (file_exists($placeholderPath)) {
            $project->addMedia($placeholderPath)
                ->preservingOriginal()
                ->toMediaCollection('project_images');
        } else {
            // Otherwise, use a generic placeholder
            $defaultPlaceholder = storage_path('app/projects/default_project.jpg');

            if (file_exists($defaultPlaceholder)) {
                $project->addMedia($defaultPlaceholder)
                    ->preservingOriginal()
                    ->toMediaCollection('project_images');
            }
        }
    }
}
