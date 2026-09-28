<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'hero' => [
                'title' => 'Find Your Dream Home',
                'subtitle' => 'Discover the perfect property that matches your lifestyle',
                'backgroundImage' => '/images/hero-bg.jpg',
                'searchPlaceholder' => 'Search by location, property type, or keyword...'
            ],

            'featuredProperties' => [
                [
                    'id' => 1,
                    'title' => 'Modern Luxury Villa',
                    'slug' => 'modern-luxury-villa',
                    'price' => 750000,
                    'price_formatted' => '$750,000',
                    'location' => 'Beverly Hills, CA',
                    'bedrooms' => 4,
                    'bathrooms' => 3,
                    'area' => 3200,
                    'area_unit' => 'sq ft',
                    'type' => 'Villa',
                    'image' => '/images/properties/property-1.jpg',
                    'is_featured' => true,
                    'tags' => ['Pool', 'Garden', 'Garage']
                ],
                [
                    'id' => 2,
                    'title' => 'Downtown Apartment',
                    'slug' => 'downtown-apartment',
                    'price' => 450000,
                    'price_formatted' => '$450,000',
                    'location' => 'New York, NY',
                    'bedrooms' => 2,
                    'bathrooms' => 2,
                    'area' => 1200,
                    'area_unit' => 'sq ft',
                    'type' => 'Apartment',
                    'image' => '/images/properties/property-2.jpg',
                    'is_featured' => true,
                    'tags' => ['City View', 'Balcony', 'Gym']
                ],
                [
                    'id' => 3,
                    'title' => 'Beachfront House',
                    'slug' => 'beachfront-house',
                    'price' => 1200000,
                    'price_formatted' => '$1,200,000',
                    'location' => 'Miami, FL',
                    'bedrooms' => 5,
                    'bathrooms' => 4,
                    'area' => 4500,
                    'area_unit' => 'sq ft',
                    'type' => 'Beach House',
                    'image' => '/images/properties/property-3.jpg',
                    'is_featured' => true,
                    'tags' => ['Beach Access', 'Pool', 'Ocean View']
                ]
            ]
        ];
        return Inertia::render('Home', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
