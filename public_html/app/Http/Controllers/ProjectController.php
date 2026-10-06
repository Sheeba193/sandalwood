<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\ProjectImageFolders;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class ProjectController extends Controller
{
    private const KITISURU_DESCRIPTION = "Sandalwood Kitisuru offers a rare expression of refined living, with just eleven exclusive villas, each sitting on one acre setting in one of Nairobi's most coveted residential enclaves.\n\nElegant architecture, expansive spaces, and beautifully landscaped gardens come together to create an environment that feels private, serene, and effortlessly sophisticated.\n\nDesigned for those who value exceptional quality, comfort, and understated luxury, it is a place where every detail enhances everyday living, allowing life to unfold with comfort, balance, and distinction.";
    private const KITISURU_IDEAL_DESCRIPTION = "Perfectly positioned to offer a rare balance of elite seclusion and effortless urban connectivity, Sandalwood Kitisuru ensures that Nairobi's premier commercial and social hubs are always within easy reach.\n\nTucked away in a quiet enclave, the estate benefits from seamless access to major transit.\n\nThis strategic location effortlessly links residents to world-class amenities including the International School of Kenya (ISK), Village Market, and premier medical facilities, allowing you to enjoy your privacy without ever feeling removed from the heartbeat of the city.";
    private const KITISURU_TRANQUIL_DESCRIPTION = 'Surrounded by lush greenery and beautifully landscaped gardens, Sandalwood Kitisuru evokes a feeling of calm, privacy, and quiet escape. A place where the pace slows, the air feels lighter, and nature becomes part of everyday luxury.';
    private const OTHAYA_DESCRIPTION = "Sandalwood Othaya offers a refreshing living experience where elegant spaces, high-end modern finishes, and a lush garden setting create an atmosphere that feels peaceful and beautifully balanced within the heart of Lavington. Located along Othaya Road, the development blends privacy and warmth with a serene outdoor environment that brings a quiet sense of escape to everyday city living.";
    private const OTHAYA_IDEAL_DESCRIPTION = "Sandalwood Othaya enjoys excellent connectivity through Othaya Road and its close links to major routes connecting Lavington, Kileleshwa, Kilimani, and Westlands, making movement across Nairobi smooth and convenient. Its location within one of the city's most desirable residential areas, combined with easy access to business hubs, shopping centers, schools, restaurants, and lifestyle amenities, makes it an ideal development for comfortable and well-balanced urban living.";

    /**
     * Display a listing of all projects.
     */
    public function index()
    {
        $projects = Cache::remember('all_projects_list_v7', 3600, function () {
            return Project::with('media')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                // Keep projects without their own image folders off the public site until assets are added.
                ->filter(fn ($project) => ProjectImageFolders::hasImages($project->slug))
                ->map(function ($project) {

                    $coverImage = $project->getFirstMediaUrl('cover');
                    $idealImage = $project->getFirstMediaUrl('ideal');
                    $projectImage = $project->getFirstMediaUrl('project_images');
                    $cardImage = $idealImage ?: $coverImage ?: $projectImage ?: '/images/sandalwood_kyuna.jpg';
                    $folderImages = $this->projectFolderImages($project->slug);
                    $images = collect($folderImages)
                        ->merge(collect(['gallery', 'project_images', 'cover', 'ideal', 'tranquil'])
                            ->flatMap(fn ($collection) => $project->getMedia($collection)->map(fn ($media) => $media->getUrl())))
                        ->filter()
                        ->unique()
                        ->values();

                    if ($images->isEmpty()) {
                        $images->push($cardImage);
                    }

                    $cardImage = $images->first() ?: $cardImage;

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
                        'image' => $cardImage,
                        'images' => $images,

                        'cover_image' => $coverImage
                            ?: $projectImage
                            ?: $cardImage,


                        'ideal_description' => $project->ideal_description,

                        'ideal_image' => $idealImage
                            ?: $coverImage
                            ?: $projectImage
                            ?: $cardImage,

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
        if (Project::where('slug', $slug)->exists()) {
            abort_unless(ProjectImageFolders::hasImages($slug), 404);
        }
        if (!Project::where('slug', $slug)->exists()) {
            $referenceProject = collect($this->referenceProjects())->firstWhere('slug', $slug);
            abort_if(!$referenceProject, 404);

            $gallery = collect($referenceProject['images'])
                ->map(fn ($url, $index) => ['id' => $index + 1, 'url' => $url, 'name' => $this->galleryImageName($slug, $url, $index)])
                ->all();
            $coverImage = match ($slug) {
                'sandalwood-loresho' => '/images/projects/sandalwood-loresho/IMG-20251113-WA0024.jpg',
                'sandalwood-kitisuru' => '/images/projects/sandalwood-kitisuru/1.JPG',
                'sandalwood-othaya' => '/images/projects/sandalwood-othaya/3I9A8204.JPG',
                default => $referenceProject['images'][0],
            };
            $idealImage = match ($slug) {
                'sandalwood-loresho' => '/images/projects/sandalwood-loresho/IMG-20251113-WA0018.jpg',
                'sandalwood-kitisuru' => '/images/projects/sandalwood-kitisuru/2.JPG',
                'sandalwood-othaya' => '/images/projects/sandalwood-othaya/3I9A8056-2.JPG',
                default => $referenceProject['images'][0],
            };

            return Inertia::render('Projects/Show', [
                'project' => [
                    'id' => $referenceProject['id'],
                    'title' => $referenceProject['title'],
                    'slug' => $referenceProject['slug'],
                    'subtitle' => null,
                    'tagline' => null,
                    'location' => match ($slug) {
                        'sandalwood-kitisuru' => 'Kitisuru, Nairobi, Kenya',
                        'sandalwood-othaya' => 'Othaya Road, Lavington, Nairobi',
                        default => '',
                    },
                    'location_url' => match ($slug) {
                        'sandalwood-loresho' => Project::LORESHO_MAPS_URL,
                        'sandalwood-kitisuru' => Project::KITISURU_MAPS_URL,
                        'sandalwood-othaya' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Othaya%2C+Othaya+Road%2C+Lavington%2C+Nairobi',
                        default => null,
                    },
                    'specifications' => match ($slug) {
                        'sandalwood-loresho' => '3 & 4 BEDROOM APARTMENTS',
                        'sandalwood-kitisuru' => '5 BEDROOM VILLAS',
                        'sandalwood-othaya' => '3 BEDROOM APARTMENTS',
                        default => null,
                    },
                    'status' => $referenceProject['status'],
                    'is_featured' => false,
                    'description' => match ($slug) {
                        'sandalwood-loresho' => 'An exclusive collection of residential apartments set within the tranquil and serene surroundings of Loresho, Nairobi. Designed to offer a perfect balance of serenity and modern convenience, the development features thoughtfully planned living spaces complemented by a selection of recreational and functional amenities.',
                        'sandalwood-kitisuru' => self::KITISURU_DESCRIPTION,
                        'sandalwood-othaya' => self::OTHAYA_DESCRIPTION,
                        default => 'Project information will be updated soon.',
                    },
                    'image' => $coverImage,
                    'cover_image' => $coverImage,
                    'ideal_title' => 'THE IDEAL SETTING',
                    'ideal_description' => match ($slug) {
                        'sandalwood-loresho' => "Sandalwood Loresho is just a 2-minute drive from Lions SightFirst Eye Hospital. The development ensures access to quality healthcare, while nearby retail centers, international schools, and lifestyle hubs in Westlands and the wider Nairobi area are all within a short drive. Seamless connectivity via Waiyaki Way and Lower Kabete Road allows for easy access to Nairobi's key destinations, all while preserving the calm, green charm that defines Loresho.",
                        'sandalwood-kitisuru' => self::KITISURU_IDEAL_DESCRIPTION,
                        'sandalwood-othaya' => self::OTHAYA_IDEAL_DESCRIPTION,
                        default => null,
                    },
                    'ideal_image' => $idealImage,
                    'tranquil_title' => 'A TRANQUIL RETREAT',
                    'tranquil_description' => $slug === 'sandalwood-kitisuru' ? self::KITISURU_TRANQUIL_DESCRIPTION : null,
                    'tranquil_image' => $slug === 'sandalwood-kitisuru'
                        ? '/images/projects/sandalwood-kitisuru/3.JPG'
                        : $referenceProject['images'][0],
                    'gallery' => $gallery,
                    'amenities' => [],
                    'created_at' => now()->toISOString(),
                    'updated_at' => now()->toISOString(),
                ],
            ]);
        }

        $project = Cache::remember("project_v5_{$slug}", 3600, function () use ($slug) {

            $project = Project::with(['media', 'amenities'])
                ->where('slug', $slug)
                ->firstOrFail();

            $folderImages = $this->projectFolderImages($project->slug);
            $loreshoHeroImage = $project->slug === 'sandalwood-loresho'
                ? $this->projectFolderImage($folderImages, 'IMG-20251113-WA0024.jpg')
                : null;
            $loreshoIdealImage = $project->slug === 'sandalwood-loresho'
                ? $this->projectFolderImage($folderImages, 'IMG-20251113-WA0018.jpg')
                : null;
            $kitisuruHeroImage = $project->slug === 'sandalwood-kitisuru'
                ? $this->projectFolderImage($folderImages, '1.JPG')
                : null;
            $kitisuruIdealImage = $project->slug === 'sandalwood-kitisuru'
                ? $this->projectFolderImage($folderImages, '2.JPG')
                : null;
            $kitisuruTranquilImage = $project->slug === 'sandalwood-kitisuru'
                ? $this->projectFolderImage($folderImages, '3.JPG')
                : null;
            $othayaHeroImage = $project->slug === 'sandalwood-othaya'
                ? $this->projectFolderImage($folderImages, '3I9A8204.JPG')
                : null;
            $othayaIdealImage = $project->slug === 'sandalwood-othaya'
                ? $this->projectFolderImage($folderImages, '3I9A8056-2.JPG')
                : null;

            /*
            |--------------------------------------------------------------------------
            | Cover Image
            |--------------------------------------------------------------------------
            */

            $coverImage = $project->getFirstMediaUrl('cover');
            $projectImage = $project->getFirstMediaUrl('project_images');

            /*
            |--------------------------------------------------------------------------
            | Ideal Setting Image
            |--------------------------------------------------------------------------
            */

            $idealImage = $project->getFirstMediaUrl('ideal');

            $colosseumImage = $project->slug === 'the-colosseum-residences'
                ? '/images/projects/the-colosseum-residences/1.png'
                : null;

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

            $gallery = collect(['gallery', 'project_images', 'cover', 'ideal', 'tranquil'])
                ->flatMap(fn ($collection) => $project->getMedia($collection)->map(fn ($media) => [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'name' => $media->file_name,
                ]))
                ->values()
                ->toArray();

            $loreshoDescription = 'An exclusive collection of residential apartments set within the tranquil and serene surroundings of Loresho, Nairobi. Designed to offer a perfect balance of serenity and modern convenience, the development features thoughtfully planned living spaces complemented by a selection of recreational and functional amenities.';
            $loreshoIdealDescription = "Sandalwood Loresho is just a 2-minute drive from Lions SightFirst Eye Hospital. The development ensures access to quality healthcare, while nearby retail centers, international schools, and lifestyle hubs in Westlands and the wider Nairobi area are all within a short drive. Seamless connectivity via Waiyaki Way and Lower Kabete Road allows for easy access to Nairobi's key destinations, all while preserving the calm, green charm that defines Loresho.";
            $description = $project->description;
            if ($project->slug === 'sandalwood-loresho' && str_word_count((string) $description) < 20) {
                $description = $loreshoDescription;
            } elseif ($project->slug === 'sandalwood-kitisuru' && str_word_count((string) $description) < 20) {
                $description = self::KITISURU_DESCRIPTION;
            } elseif ($project->slug === 'sandalwood-othaya' && str_word_count((string) $description) < 20) {
                $description = self::OTHAYA_DESCRIPTION;
            }
            if ($folderImages) {
                $gallery = collect($folderImages)
                    ->merge(collect($gallery)->pluck('url'))
                    ->unique()
                    ->values()
                    ->map(fn ($url, $index) => ['id' => $index + 1, 'url' => $url, 'name' => $this->galleryImageName($project->slug, $url, $index)])
                    ->all();
            }


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

                'location' => $project->slug === 'sandalwood-othaya' ? 'Othaya Road, Lavington, Nairobi' : $project->location,

                'location_url' => $project->location_url
                    ?: match ($project->slug) {
                        'sandalwood-loresho' => Project::LORESHO_MAPS_URL,
                        'sandalwood-kitisuru' => Project::KITISURU_MAPS_URL,
                        'sandalwood-othaya' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Othaya%2C+Othaya+Road%2C+Lavington%2C+Nairobi',
                        default => null,
                    },

                'specifications' => $project->specifications
                    ?: match ($project->slug) {
                        'sandalwood-loresho' => '3 & 4 BEDROOM APARTMENTS',
                        'sandalwood-kitisuru' => '5 BEDROOM VILLAS',
                        'sandalwood-othaya' => '3 BEDROOM APARTMENTS',
                        default => null,
                    },

                'status' => $project->status,

                'is_featured' => $project->is_featured,


                /*
                |--------------------------------------------------------------------------
                | Main Overview
                |--------------------------------------------------------------------------
                */

                'description' => $description,


                /*
                |--------------------------------------------------------------------------
                | Cover
                |--------------------------------------------------------------------------
                */

                'cover_image' => $colosseumImage
                    ?: $loreshoHeroImage
                    ?: $kitisuruHeroImage
                    ?: $othayaHeroImage
                    ?: $coverImage
                    ?: $projectImage
                    ?: ($folderImages[0] ?? null)
                    ?: '/images/sandalwood_kyuna.jpg',


                /*
                |--------------------------------------------------------------------------
                | Ideal Setting
                |--------------------------------------------------------------------------
                */

                'ideal_title' => $project->ideal_title
                    ?: 'THE IDEAL SETTING',

                'ideal_description' => $project->ideal_description
                    ?: match ($project->slug) {
                        'sandalwood-loresho' => $loreshoIdealDescription,
                        'sandalwood-kitisuru' => self::KITISURU_IDEAL_DESCRIPTION,
                        'sandalwood-othaya' => self::OTHAYA_IDEAL_DESCRIPTION,
                        default => null,
                    },

                'ideal_image' => $colosseumImage
                    ?: $loreshoIdealImage
                    ?: $kitisuruIdealImage
                    ?: $othayaIdealImage
                    ?: $idealImage
                    ?: $coverImage
                    ?: $projectImage
                    ?: ($folderImages[1] ?? $folderImages[0] ?? null)
                    ?: '/images/sandalwood_kyuna.jpg',


                /*
                |--------------------------------------------------------------------------
                | Tranquil Retreat
                |--------------------------------------------------------------------------
                */

                'tranquil_title' => $project->tranquil_title
                    ?: 'A TRANQUIL RETREAT',

                'tranquil_description' => $project->tranquil_description
                    ?: ($project->slug === 'sandalwood-kitisuru' ? self::KITISURU_TRANQUIL_DESCRIPTION : null),

                'tranquil_image' => $kitisuruTranquilImage
                    ?: ($folderImages[2] ?? ($tranquilImage ?: '/images/sandalwood_kyuna.jpg')),


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

    public function referenceProjects(): array
    {
        $projects = [
            ['id' => 16, 'title' => 'Sandalwood Kyuna', 'slug' => 'sandalwood-kyuna', 'status' => 'ongoing', 'images' => ['/images/projects/sandalwood-kyuna/WhatsApp%20Image%202026-10-03%20at%2009.53.10%20(2).jpeg']],
            ['id' => 1, 'title' => 'Sandalwood Loresho', 'slug' => 'sandalwood-loresho', 'status' => 'ongoing', 'images' => ['/images/projects/sandalwood-loresho/loresho.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0018.jpg', '/images/projects/sandalwood-loresho/loresho4.jpg', '/images/projects/sandalwood-loresho/loresho5.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0015.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0017.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0021.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0019.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0024.jpg', '/images/projects/sandalwood-loresho/IMG-20251113-WA0025.jpg']],
            ['id' => 2, 'title' => 'Oak and Ivy', 'slug' => 'oak-and-ivy', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0016.jpg']],
            ['id' => 3, 'title' => 'The Colosseum Residences', 'slug' => 'the-colosseum-residences', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0015.jpg']],
            ['id' => 4, 'title' => 'The Haven', 'slug' => 'the-haven', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0018.jpg']],
            ['id' => 5, 'title' => 'Sandalwood Waterfront', 'slug' => 'sandalwood-waterfront', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0025.jpg']],
            ['id' => 6, 'title' => 'Sandalwood Kitisuru', 'slug' => 'sandalwood-kitisuru', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0027.jpg']],
            ['id' => 7, 'title' => 'Sandalwood Clyde Gardens', 'slug' => 'sandalwood-clyde-gardens', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0012.jpg']],
            ['id' => 8, 'title' => 'Sandalwood Lenana Road', 'slug' => 'sandalwood-lenana-road', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0024.jpg']],
            ['id' => 9, 'title' => 'Sandalwood Riverside', 'slug' => 'sandalwood-riverside', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0019.jpg']],
            ['id' => 10, 'title' => 'Sandalwood Brookside', 'slug' => 'sandalwood-brookside', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0026.jpg']],
            ['id' => 11, 'title' => 'Sandalwood Othaya', 'slug' => 'sandalwood-othaya', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0017.jpg']],
            ['id' => 12, 'title' => 'The Convex', 'slug' => 'the-convex', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0022.jpg']],
            ['id' => 13, 'title' => 'Chilly Breezes', 'slug' => 'chilly-breezes', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0020.jpg']],
            ['id' => 14, 'title' => 'Silver Terraces', 'slug' => 'silver-terraces', 'status' => 'completed', 'images' => ['/images/IMG-20251113-WA0014.jpg']],
            ['id' => 15, 'title' => 'Ivory Terraces', 'slug' => 'ivory-terraces', 'status' => 'completed', 'images' => ['/images/projects/ivory-terraces/3I9A0277.JPG', '/images/projects/ivory-terraces/3I9A0189.JPG', '/images/projects/ivory-terraces/3I9A0207.JPG', '/images/projects/ivory-terraces/3I9A0258.JPG', '/images/projects/ivory-terraces/3I9A9866.JPG', '/images/projects/ivory-terraces/3I9A9883.JPG', '/images/projects/ivory-terraces/3I9A9930.JPG', '/images/projects/ivory-terraces/3I9A9890.JPG', '/images/projects/ivory-terraces/Ivory(2).jpeg']],
        ];
        $projects = array_values(array_filter(
            $projects,
            fn ($project) => ProjectImageFolders::hasImages($project['slug']),
        ));


        foreach ($projects as &$project) {
            $folderImages = $this->projectFolderImages($project['slug']);
            if ($folderImages) {
                $project['images'] = $folderImages;
            }
        }

        return $projects;
    }

    private function galleryImageName(string $slug, string $url, int $index): string
    {
        $filename = basename(rawurldecode(parse_url($url, PHP_URL_PATH) ?: $url));

        if ($slug === 'sandalwood-loresho') {
            return match ($filename) {
                'loresho.jpg' => 'Sandalwood Loresho entrance',
                'IMG-20251113-WA0018.jpg', 'IMG-20251113-WA0015.jpg' => 'Sandalwood Loresho pool and landscaped gardens',
                'IMG-20251113-WA0024.jpg' => 'Sandalwood Loresho apartment living room',
                default => 'Sandalwood Loresho gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'sandalwood-kitisuru') {
            return match ($filename) {
                '1.JPG' => 'Sandalwood Kitisuru garden entrance',
                '2.JPG' => 'Sandalwood Kitisuru swimming pool and garden',
                '3.JPG', '12.JPG', '5.JPG' => 'Sandalwood Kitisuru landscaped estate road',
                '4.JPG' => 'Sandalwood Kitisuru main entrance gate',
                default => 'Sandalwood Kitisuru garden and villa',
            };
        }

        if ($slug === 'sandalwood-othaya') {
            return match ($filename) {
                '3I9A8078.JPG' => 'Sandalwood Othaya apartments',
                '3I9A8066.JPG' => 'Sandalwood Othaya tree-lined driveway',
                '3I9A8056-2.JPG' => 'Sandalwood Othaya entrance gate',
                '3I9A8117-2.JPG', '3I9A8128.JPG' => 'Sandalwood Othaya swimming pool and garden',
                '3I9A8204.JPG' => 'Sandalwood Othaya landscaped garden',
                default => 'Sandalwood Othaya gallery image ' . ($index + 1),
            };
        }

        return "Project gallery image " . ($index + 1);
    }

    private function projectFolderImage(array $images, string $filename): ?string
    {
        return collect($images)->first(
            fn ($url) => basename(rawurldecode(parse_url($url, PHP_URL_PATH) ?: $url)) === $filename,
        );
    }

    private function projectFolderImages(string $slug): array
    {
        return ProjectImageFolders::images($slug);
    }
}
