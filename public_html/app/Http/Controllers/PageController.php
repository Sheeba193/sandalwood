<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Home page
     */
    public function home()
    {
        $projects = Cache::remember('home_projects', 3600, function () {

            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($project) {

                    /*
                    |--------------------------------------------------------------------------
                    | Project Images
                    |--------------------------------------------------------------------------
                    */

                    $idealImage = $project->getFirstMediaUrl('ideal');

                    $coverImage = $project->getFirstMediaUrl('cover');

                    $tranquilImage = $project->getFirstMediaUrl('tranquil');

                    /*
                    |--------------------------------------------------------------------------
                    | Gallery
                    |--------------------------------------------------------------------------
                    */

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

                        'cover_image' => $coverImage
                            ?: '/images/default-project.jpg',

                        'ideal_image' => $idealImage
                            ?: '/images/default-project.jpg',

                        'tranquil_image' => $tranquilImage
                            ?: '/images/default-project.jpg',

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
        | Use the IDEAL image for the main homepage slider.
        |
        | Featured projects come first, followed by ongoing projects.
        |
        */

        $slides = $projects
            ->filter(function ($project) {
                return $project['is_featured']
                    || $project['status'] === 'ongoing';
            })
            ->take(8)
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Fill Slider With Completed Projects
        |--------------------------------------------------------------------------
        */

        if ($slides->count() < 8) {

            $additionalSlides = $completedProjects
                ->take(8 - $slides->count());

            $slides = $slides
                ->concat($additionalSlides)
                ->values();
        }


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

                        'subtitle' =>
                            $project['subtitle']
                            ?? $project['location'],

                        'location' => $project['location'],

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
        $projects = Cache::remember('about_projects', 3600, function () {

            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
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
