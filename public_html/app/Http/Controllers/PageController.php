<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\ProjectImageFolders;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Home page
     */
    public function home()
    {
        $projects = Cache::remember('home_projects_with_images_v4', 3600, function () {

            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->filter(fn ($project) => ProjectImageFolders::hasImages($project->slug))
                ->map(function ($project) {

                    /*
                    |--------------------------------------------------------------------------
                    | Project Images
                    |--------------------------------------------------------------------------
                    */

                    $idealImage = $project->getFirstMediaUrl('ideal');

                    $coverImage = $project->getFirstMediaUrl('cover');

                    $tranquilImage = $project->getFirstMediaUrl('tranquil');
                    $folderImages = ProjectImageFolders::images($project->slug);
                    $folderImage = $folderImages[0] ?? '/images/default-project.jpg';

                    // The supplied exterior photo is the preferred homepage image for Colosseum.
                    $colosseumImage = $project->slug === 'the-colosseum-residences'
                        ? '/images/projects/the-colosseum-residences/1.png'
                        : null;

                    /*
                    |--------------------------------------------------------------------------
                    | Gallery
                    |--------------------------------------------------------------------------
                    */

                    $gallery = collect($folderImages)
                        ->map(fn ($url, $index) => [
                            'id' => 'folder-' . $index,
                            'url' => $url,
                            'name' => basename(parse_url($url, PHP_URL_PATH) ?: $url),
                        ])
                        ->merge($project->getMedia('gallery')
                        ->map(function ($media) {
                            return [
                                'id' => $media->id,
                                'url' => $media->getUrl(),
                                'name' => $media->file_name,
                            ];
                        }))
                        ->values()
                        ->toArray();

                    /*
                    |--------------------------------------------------------------------------
                    | Return Project
                    |--------------------------------------------------------------------------
                    */

                    return [
                        'id' => $project->id,

                        'title' => $project->title,
                        'subtitle' => $project->subtitle,
                        'tagline' => $project->tagline,

                        'location' => $project->location,
                        'location_url' => $project->location_url,
                        'specifications' => $project->specifications,

                        'status' => $project->status,
                        'slug' => $project->slug,
                        'is_featured' => $project->is_featured,

                        'description' => $project->description,

                        /*
                        |--------------------------------------------------------------------------
                        | Images
                        |--------------------------------------------------------------------------
                        */

                        'cover_image' => $colosseumImage
                            ?: $coverImage
                            ?: $folderImage,

                        'ideal_image' => $colosseumImage
                            ?: $idealImage
                            ?: $coverImage
                            ?: $folderImage,

                        'tranquil_image' => $tranquilImage
                            ?: ($folderImages[1] ?? $folderImage),

                        /*
                        |--------------------------------------------------------------------------
                        | Gallery
                        |--------------------------------------------------------------------------
                        */

                        'gallery' => $gallery,

                        'created_at' => $project->created_at,
                        'updated_at' => $project->updated_at,
                    ];
                });
        });

        // The public project detail routes already use this real project catalog
        // when the database has not been seeded. Keep the homepage consistent.
        if ($projects->isEmpty()) {
            $projects = collect(app(ProjectController::class)->referenceProjects())
                ->map(fn ($project) => [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'subtitle' => null,
                    'tagline' => null,
                    'location' => null,
                    'specifications' => null,
                    'status' => $project['status'],
                    'slug' => $project['slug'],
                    'is_featured' => false,
                    'description' => null,
                    'cover_image' => $project['images'][0],
                    'ideal_image' => $project['images'][0],
                    'tranquil_image' => $project['images'][1] ?? $project['images'][0],
                    'gallery' => collect($project['images'])
                        ->map(fn ($url, $index) => [
                            'id' => 'folder-' . $index,
                            'url' => $url,
                            'name' => basename(parse_url($url, PHP_URL_PATH) ?: $url),
                        ])
                        ->all(),
                    'created_at' => null,
                    'updated_at' => null,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Recent Launches
        |--------------------------------------------------------------------------
        |
        | Ongoing projects are treated as recent/current launches.
        |
        */

        $recentLaunches = $projects
            ->filter(function ($project) {
                return in_array(
                    $project['status'],
                    ['ongoing', 'planned']
                );
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Completed Projects
        |--------------------------------------------------------------------------
        */

        $completedProjects = $projects
            ->filter(function ($project) {
                return $project['status'] === 'completed';
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Homepage Slider
        |--------------------------------------------------------------------------
        |
        | Use every project with an available image in the homepage slider.
        |
        | Projects are ordered with featured projects first, then newest projects.
        |
        */

        $slides = $projects->values();


        /*
        |--------------------------------------------------------------------------
        | Homepage Data
        |--------------------------------------------------------------------------
        */

        $data = [

            /*
            |--------------------------------------------------------------------------
            | Main Slider
            |--------------------------------------------------------------------------
            */

            'slides' => $slides
                ->map(function ($project) {

                    return [
                        'id' => $project['id'],

                        /*
                        | IMPORTANT:
                        | Homepage slider uses IDEAL image
                        */
                        'image' => $project['ideal_image'],

                        'ideal_image' => $project['ideal_image'],

                        'cover_image' => $project['cover_image'],

                        'title' => $project['title'],

                        'tagline' => $project['tagline'],

                        'subtitle' =>
                            $project['subtitle']
                            ?? $project['location'],

                        'location' => $project['location'],

                        'specifications' => $project['specifications'],

                        'slug' => $project['slug'],

                        'status' => $project['status'],

                        'is_featured' => $project['is_featured'],
                    ];
                })
                ->values(),


            /*
            |--------------------------------------------------------------------------
            | Recent Launches
            |--------------------------------------------------------------------------
            |
            | Includes ideal image + ALL gallery images.
            |
            */

            'recent_launches' => $recentLaunches
                ->map(function ($project) {

                    return [
                        'id' => $project['id'],

                        'title' => $project['title'],

                        'subtitle' => $project['subtitle'],

                        'tagline' => $project['tagline'],

                        'location' => $project['location'],

                        'slug' => $project['slug'],

                        'status' => $project['status'],

                        /*
                        | Primary image
                        */
                        'image' => $project['ideal_image'],

                        'ideal_image' => $project['ideal_image'],

                        /*
                        | Other project images
                        */
                        'cover_image' => $project['cover_image'],

                        'tranquil_image' =>
                            $project['tranquil_image'],

                        /*
                        | ALL gallery images
                        */
                        'gallery' => $project['gallery'],
                    ];
                })
                ->values(),

            'under_construction' => $projects
                ->filter(fn ($project) => $project['status'] === 'ongoing')
                ->map(fn ($project) => [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'slug' => $project['slug'],
                    'status' => $project['status'],
                    'image' => $project['ideal_image'],
                    'description' => $project['description'],
                ])
                ->values(),


            /*
            |--------------------------------------------------------------------------
            | Completed Projects
            |--------------------------------------------------------------------------
            |
            | Includes ideal image + ALL gallery images.
            |
            */

            'completed_projects' => $completedProjects
                ->map(function ($project) {

                    return [
                        'id' => $project['id'],

                        'title' => $project['title'],

                        'subtitle' => $project['subtitle'],

                        'tagline' => $project['tagline'],

                        'location' => $project['location'],

                        'slug' => $project['slug'],

                        'status' => $project['status'],

                        /*
                        | Primary image
                        */
                        'image' => $project['ideal_image'],

                        'ideal_image' => $project['ideal_image'],

                        /*
                        | Other project images
                        */
                        'cover_image' => $project['cover_image'],

                        'tranquil_image' =>
                            $project['tranquil_image'],

                        /*
                        | ALL gallery images
                        */
                        'gallery' => $project['gallery'],
                    ];
                })
                ->values(),


            /*
            |--------------------------------------------------------------------------
            | Featured Projects
            |--------------------------------------------------------------------------
            */

            'featured_projects' => $projects
                ->filter(function ($project) {
                    return $project['is_featured'];
                })
                ->values(),


            /*
            |--------------------------------------------------------------------------
            | All Projects
            |--------------------------------------------------------------------------
            */

            'all_projects' => $projects,
        ];


        return Inertia::render('Home', $data);
    }


    /**
     * About page
     */
    public function about()
    {
        $projects = Cache::remember('about_projects_with_images', 3600, function () {

            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->filter(fn ($project) => ProjectImageFolders::hasImages($project->slug))
                ->map(function ($project) {

                    $idealImage =
                        $project->getFirstMediaUrl('ideal');

                    $coverImage =
                        $project->getFirstMediaUrl('cover');

                    $gallery = $project->getMedia('gallery')
                        ->map(function ($media) {
                            return [
                                'id' => $media->id,
                                'url' => $media->getUrl(),
                                'name' => $media->file_name,
                            ];
                        })
                        ->values()
                        ->toArray();

                    return [
                        'id' => $project->id,

                        'title' => $project->title,
                        'subtitle' => $project->subtitle,
                        'tagline' => $project->tagline,

                        'location' => $project->location,
                        'location_url' => $project->location_url,
                        'specifications' => $project->specifications,

                        'status' => $project->status,
                        'slug' => $project->slug,

                        'category' => 'Residential',

                        'is_featured' =>
                            $project->is_featured,

                        /*
                        |--------------------------------------------------------------------------
                        | Images
                        |--------------------------------------------------------------------------
                        */

                        'image' => $idealImage
                            ?: '/images/default-project.jpg',

                        'ideal_image' => $idealImage
                            ?: '/images/default-project.jpg',

                        'cover_image' => $coverImage
                            ?: '/images/default-project.jpg',

                        /*
                        |--------------------------------------------------------------------------
                        | Gallery
                        |--------------------------------------------------------------------------
                        */

                        'gallery' => $gallery,

                        'description' =>
                            $project->description
                                ?: 'A distinguished residential development recognized for its excellence in design and project delivery.',

                        'created_at' =>
                            $project->created_at,

                        'updated_at' =>
                            $project->updated_at,
                    ];
                });
        });


        return Inertia::render('About', [
            'projects' => $projects,
        ]);
    }


    /**
     * Contact page
     */
    public function contact()
    {
        return Inertia::render('Contact');
    }


    /**
     * Privacy Policy
     */
    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy');
    }


    /**
     * Terms of Service
     */
    public function termsOfService()
    {
        return Inertia::render('TermsOfService');
    }


    /**
     * Sitemap
     */
    public function sitemap()
    {
        return Inertia::render('Sitemap');
    }
}
