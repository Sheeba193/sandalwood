<?php

namespace App\Http\Controllers;

use App\Models\Amenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AmenitiesController extends Controller
{
    /**
     * Display all amenities.
     */
    public function index()
    {
        $amenities = Amenities::latest()->get();

        return Inertia::render('Admin/Amenities/Index', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Store a new amenity.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp,svg',
                'max:2048',
            ],
        ]);

        $imagePath = $request->file('image')
            ->store('amenities', 'public');

        Amenities::create([
            'name' => $validated['name'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity created successfully.');
    }

    /**
     * Update an existing amenity.
     */
    public function update(Request $request, Amenities $amenity)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp,svg',
                'max:2048',
            ],
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Replace image if a new one was uploaded
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            if ($amenity->image) {
                Storage::disk('public')->delete($amenity->image);
            }

            $data['image'] = $request->file('image')
                ->store('amenities', 'public');
        }

        $amenity->update($data);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity updated successfully.');
    }

    /**
     * Delete an amenity.
     */
    public function destroy(Amenities $amenity)
    {
        if ($amenity->image) {
            Storage::disk('public')->delete($amenity->image);
        }

        $amenity->delete();

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity deleted successfully.');
    }
}
