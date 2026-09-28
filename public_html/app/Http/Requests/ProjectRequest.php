<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'subtitle' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tagline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'specifications' => [
                'nullable',
                'string',
                'max:500',
            ],

            'location_url' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'status' => [
                'required',
                Rule::in([
                    'ongoing',
                    'completed',
                    'planned',
                    'sold_out',
                ]),
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],

            /*
            |--------------------------------------------------------------------------
            | Main Description
            |--------------------------------------------------------------------------
            */

            'description' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Ideal Setting
            |--------------------------------------------------------------------------
            */

            'ideal_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ideal_description' => [
                'nullable',
                'string',
            ],

            'ideal_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Tranquil Retreat
            |--------------------------------------------------------------------------
            */

            'tranquil_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tranquil_description' => [
                'nullable',
                'string',
            ],

            'tranquil_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Cover Image
            |--------------------------------------------------------------------------
            |
            | Exact recommended dimensions:
            | 1920 x 600
            |
            */

            'cover_image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp',
//                'dimensions:width=1920,height=600',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            'gallery' => [
                'nullable',
                'array',
                'max:30',
            ],

            'gallery.*' => [
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'cover_image.required' =>
                'A cover image is required.',

            'cover_image.dimensions' =>
                'The cover image must be exactly 1920 × 600 pixels.',

            'cover_image.max' =>
                'The cover image must not exceed 5 MB.',

            'ideal_image.max' =>
                'The ideal setting image must not exceed 5 MB.',

            'tranquil_image.max' =>
                'The tranquil retreat image must not exceed 5 MB.',

            'gallery.max' =>
                'You can upload a maximum of 30 gallery images.',

            'gallery.*.max' =>
                'Each gallery image must not exceed 5 MB.',

            'gallery.*.image' =>
                'Each gallery file must be a valid image.',
        ];
    }
}
