<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class ProjectController extends Controller
{
    /**
     * Display a listing of all projects.
     */
    public function index()
    {
        $projects = Cache::remember('all_projects_list', 3600, function () {
            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($project) {

                    $coverImage = $project->getFirstMediaUrl('cover');
                    $idealImage = $project->getFirstMediaUrl('ideal');

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

                        // Cover image
                        'image' => $idealImage
                            ?: '/images/default-project.jpg',

                        'cover_image' => $coverImage
                            ?: '/images/default-project.jpg',


                        'ideal_description' => $project->ideal_description,

                        'ideal_image' => $idealImage
                            ?: '/images/default-project.jpg',

                        'description' => $project->description
                            ?: 'A distinguished residential development recognized for its excellence in design and project delivery.',

                        'created_at' => $project->created_at,
                        'updated_at' => $project->updated_at,
                    ];
                });
        });

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Projects/Create');
    }

    /**
     * Show a single project
     */
    public function show($slug)
    {
        $project = Cache::remember("project_{$slug}", 3600, function () use ($slug) {

            $project = Project::with(['media', 'amenities'])
                ->where('slug', $slug)
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Cover Image
            |--------------------------------------------------------------------------
            */

            $coverImage = $project->getFirstMediaUrl('cover');

            /*
            |--------------------------------------------------------------------------
            | Ideal Setting Image
            |--------------------------------------------------------------------------
            */

            $idealImage = $project->getFirstMediaUrl('ideal');

            /*
            |--------------------------------------------------------------------------
            | Tranquil Retreat Image
            |--------------------------------------------------------------------------
            */

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


            return [
                /*
                |--------------------------------------------------------------------------
                | Basic Information
                |--------------------------------------------------------------------------
                */

                'id' => $project->id,

                'title' => $project->title,

                'slug' => $project->slug,

                'subtitle' => $project->subtitle,

                'tagline' => $project->tagline,

                'location' => $project->location,

                'location_url' => $project->location_url,

                'specifications' => $project->specifications,

                'status' => $project->status,

                'is_featured' => $project->is_featured,


                /*
                |--------------------------------------------------------------------------
                | Main Overview
                |--------------------------------------------------------------------------
                */

                'description' => $project->description,


                /*
                |--------------------------------------------------------------------------
                | Cover
                |--------------------------------------------------------------------------
                */

                'cover_image' => $coverImage
                    ?: '/images/default-project.jpg',


                /*
                |--------------------------------------------------------------------------
                | Ideal Setting
                |--------------------------------------------------------------------------
                */

                'ideal_title' => $project->ideal_title
                    ?: 'THE IDEAL SETTING',

                'ideal_description' => $project->ideal_description,

                'ideal_image' => $idealImage
                    ?: '/images/default-project.jpg',


                /*
                |--------------------------------------------------------------------------
                | Tranquil Retreat
                |--------------------------------------------------------------------------
                */

                'tranquil_title' => $project->tranquil_title
                    ?: 'A TRANQUIL RETREAT',

                'tranquil_description' => $project->tranquil_description,

                'tranquil_image' => $tranquilImage
                    ?: '/images/default-project.jpg',


                /*
                |--------------------------------------------------------------------------
                | Gallery
                |--------------------------------------------------------------------------
                */

                'gallery' => $gallery,
                'amenities' => $project->amenities
                    ->map(function ($amenity) {
                        return [
                            'id' => $amenity->id,
                            'name' => $amenity->name,
                            'image' => $amenity->image,
                        ];
                    })
                    ->values()
                    ->toArray(),


                /*
                |--------------------------------------------------------------------------
                | Metadata
                |--------------------------------------------------------------------------
                */

                'created_at' => $project->created_at,
                'updated_at' => $project->updated_at,
            ];
        });


        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
}
