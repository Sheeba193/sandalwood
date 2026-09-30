<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\AdminProjectResource;
use App\Models\Amenities;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class AdminProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query();
        $stats = [
            'total' => $projects->count(),
            'completed' => $projects->completed()->count(),
            'ongoing' => $projects->ongoing()->count(),
            'featured' => $projects->where('is_featured', 1)->count(),
        ];
        $projects = Project::paginate(10);
        return Inertia::render('Admin/Projects/Index', [
            'projects' => AdminProjectResource::collection($projects),
            'stats' => $stats,
            'filters' => $request->only(['search', 'status', 'date_from', 'date_to']),

        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Projects/Create', [
            'amenities' => Amenities::orderBy('name')->get(),
        ]);
    }

    public function store(ProjectRequest $request)
    {
        $project = DB::transaction(function () use ($request) {
            $project = Project::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'tagline' => $request->tagline,
                'location' => $request->location,
                'specifications' => $request->specifications,
                'location_url' => $request->location_url,
                'status' => $request->status,
                'is_featured' => $request->boolean('is_featured'),
                'description' => $request->description,

                'ideal_title' => $request->ideal_title,
                'ideal_description' => $request->ideal_description,

                'tranquil_title' => $request->tranquil_title,
                'tranquil_description' => $request->tranquil_description,
            ]);

            $project->amenities()->sync(
                $request->input('amenity_ids', [])
            );

            if ($request->hasFile('cover_image')) {

                $media = $project
                    ->addMediaFromRequest('cover_image')
                    ->toMediaCollection('cover');

                $project->update([
                    'cover_image' => $media->getPathRelativeToRoot(),
                ]);
            }

            if ($request->hasFile('ideal_image')) {

                $media = $project
                    ->addMediaFromRequest('ideal_image')
                    ->toMediaCollection('ideal');

                $project->update([
                    'ideal_image' => $media->getPathRelativeToRoot(),
                ]);
            }

            if ($request->hasFile('tranquil_image')) {

                $media = $project
                    ->addMediaFromRequest('tranquil_image')
                    ->toMediaCollection('tranquil');

                $project->update([
                    'tranquil_image' => $media->getPathRelativeToRoot(),
                ]);
            }
            if ($request->hasFile('gallery')) {

                foreach ($request->file('gallery') as $image) {

                    $project
                        ->addMedia($image)
                        ->toMediaCollection('gallery');
                }
            }


            return $project;
        });

        Cache::forget('all_projects_list_v2');

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {

    }

    public function edit(Project $project)
    {
        $project->load('media');

        return Inertia::render('Admin/Projects/Edit', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'subtitle' => $project->subtitle,
                'tagline' => $project->tagline,
                'location' => $project->location,
                'specifications' => $project->specifications,
                'location_url' => $project->location_url,
                'status' => $project->status,
                'is_featured' => $project->is_featured,
                'description' => $project->description,
                'setting_title' => $project->ideal_title,
                'setting_description' => $project->ideal_description,
                'retreat_title' => $project->tranquil_title,
                'retreat_description' => $project->tranquil_description,
                'featured_image_url' => $project->getFirstMediaUrl('cover'),
                'setting_image_url' => $project->getFirstMediaUrl('ideal'),
                'retreat_image_url' => $project->getFirstMediaUrl('tranquil'),
                'gallery' => $project->getMedia('gallery')->map(fn ($media) => [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                ])->values(),
            ],
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $previousSlug = $project->slug;
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'specifications' => ['nullable', 'string', 'max:500'],
            'location_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:ongoing,completed,planned,sold_out'],
            'is_featured' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'setting_title' => ['nullable', 'string', 'max:255'],
            'setting_description' => ['nullable', 'string'],
            'retreat_title' => ['nullable', 'string', 'max:255'],
            'retreat_description' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'setting_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'retreat_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'gallery' => ['nullable', 'array', 'max:30'],
            'gallery.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $project->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'tagline' => $validated['tagline'] ?? null,
            'location' => $validated['location'],
            'specifications' => $validated['specifications'] ?? null,
            'location_url' => $validated['location_url'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'description' => $validated['description'] ?? null,
            'ideal_title' => $validated['setting_title'] ?? null,
            'ideal_description' => $validated['setting_description'] ?? null,
            'tranquil_title' => $validated['retreat_title'] ?? null,
            'tranquil_description' => $validated['retreat_description'] ?? null,
        ]);

        foreach ([
            'featured_image' => 'cover',
            'setting_image' => 'ideal',
            'retreat_image' => 'tranquil',
        ] as $input => $collection) {
            if ($request->hasFile($input)) {
                $project->addMediaFromRequest($input)->toMediaCollection($collection);
            }
        }

        foreach ($request->file('gallery', []) as $image) {
            $project->addMedia($image)->toMediaCollection('gallery');
        }

        Cache::forget('all_projects_list_v2');
        Cache::forget("project_{$previousSlug}");
        Cache::forget("project_{$project->slug}");

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        Cache::forget('all_projects_list_v2');
        Cache::forget("project_{$project->slug}");
        // Deletes the project and all associated Spatie media
        $project->clearMediaCollection('cover');
        $project->clearMediaCollection('ideal');
        $project->clearMediaCollection('tranquil');
        $project->clearMediaCollection('gallery');

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project and all associated images deleted successfully.');
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'project_id' => 'required|exists:projects,id',
        ]);

        $project = Project::findOrFail($request->project_id);
        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $media = $project->addMedia($image)->toMediaCollection('project_images');
            $uploadedImages[] = $media->getUrl('large');
        }

        return back()->with('flash', [
            'images' => $uploadedImages,
            'success' => 'Images uploaded successfully!'
        ]);
    }

    public function deleteImage(Request $request, Project $project)
    {
        $request->validate([
            'image_url' => 'required|string',
        ]);

        $imageUrl = $request->image_url;

        $deleted = false;

        $mediaItems = $project->getMedia('project_images');

        foreach ($mediaItems as $media) {
            if ($media->getUrl() === $imageUrl) {
                $media->delete();
                $deleted = true;
                break;
            }
        }

        if ($deleted) {
            $updatedGallery = $project->getMedia('project_images')->map(function ($media) {
                return $media->getUrl();
            })->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'gallery' => $updatedGallery
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
}
