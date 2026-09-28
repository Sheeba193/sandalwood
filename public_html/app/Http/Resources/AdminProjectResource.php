<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $galleryUrls = $this->getMedia('project_images')->map(function ($media) {
            return $media->getUrl();
        })->toArray();

        if (empty($galleryUrls)) {
            $galleryUrls = [$this->getFirstMediaUrl('project_images', 'large') ?: '/images/default-project.jpg'];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'location_description' =>  'Strategically located on Riverside Lane in Westlands, The Convex is a completed, ready-to-use office development offering seamless connectivity to Lavington, Kilimani, and Nairobi CBD within just 15 minutes. With multiple access points and close proximity to banks, restaurants, hotels, prime residential neighborhoods, the Australian High Commission, and the Netherlands Embassy, it places business and convenience at the center of everyday work life.',
            'location' => $this->location,
            'status' => $this->status,
            'slug' => $this->slug,
            'is_featured' => $this->is_featured,
            'image' => $this->getFirstMediaUrl('project_images', 'large'),
            'gallery' => $galleryUrls,
            'description' => $this->description ?? 'A distinguished residential development recognized for its excellence in design and project delivery.',
            'features' => $this->features ?? [
                    'Modern Architecture',
                    'Premium Finishes',
                    'Secure Environment',
                    'Ample Parking',
                    'Green Spaces',
                    '24/7 Security'
                ],
            'created_at' => $this->created_at
            ];
    }
}
