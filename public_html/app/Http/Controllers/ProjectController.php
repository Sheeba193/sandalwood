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
    private const WATERFRONT_DESCRIPTION = 'Sandalwood Waterfront in Karen comprises exclusive villas featuring beautifully designed homes set within a unique landscape with a man-made lake, creating a distinctive residential environment that blends modern architecture with natural elements, spacious surroundings, and a strong sense of privacy and comfort.';
    private const WATERFRONT_IDEAL_DESCRIPTION = "Sandalwood Waterfront in Karen enjoys a well-connected location with convenient access to key amenities while maintaining a private residential feel. The development is within easy reach of top shopping destinations such as The Hub Karen, Karen Crossroads, and Galleria Mall, with a variety of retail, dining, and entertainment options. Residents also benefit from proximity to reputable schools and quality healthcare facilities like Nairobi Hospital Karen Branch and Karen Hospital. With good road connections, the development allows for smooth access to Nairobi's central business areas and surrounding suburbs.";
    private const BROOKSIDE_DESCRIPTION = 'Sandalwood Brookside offers a calm and inviting living experience, with thoughtfully designed spaces that create a sense of comfort and balance within the energy of city life. Nestled in the heart of Brookside, it blends modern urban living with a peaceful atmosphere that makes coming home feel refreshing and grounding.';
    private const BROOKSIDE_IDEAL_DESCRIPTION = 'Strategically located in the secure neighbourhood of Brookside Gardens, Westlands, Sandalwood Brookside offers convenient access to shopping malls, schools, hospitals, and key business hubs within Westlands and the wider Nairobi area. Its close proximity to Spring Valley and other upscale suburbs further enhances its appeal, placing residents within reach of premium lifestyle amenities while maintaining a calm residential setting.';
    private const BROOKSIDE_TRANQUIL_DESCRIPTION = 'Surrounded by lush greenery and beautifully landscaped gardens, Sandalwood Brookside offers a calm, private escape within the city. Winding garden paths and mature trees create a peaceful setting where nature becomes part of everyday living.';
    private const COLOSSEUM_DESCRIPTION = 'Overlooking the lush greenery of Muthaiga and moments away from Karura Forest, this exclusive residential development comprising elegantly designed apartments embodies a bespoke sense of urban luxury. High-end finishes, thoughtful design, and contemporary architecture come together to create an atmosphere of understated opulence, offering residents a private retreat within the city where sophistication, comfort, and refined living are seamlessly woven into every detail.';
    private const COLOSSEUM_IDEAL_DESCRIPTION = "The Colosseum enjoys exceptional connectivity within one of Nairobi's most established urban neighbourhoods. It offers quick access to Westlands, a major commercial and lifestyle hub, as well as the CBD. Residents are also within close reach of key institutions such as Aga Khan Hospital, reputable schools, and a variety of shopping and dining destinations scattered across Parklands and nearby areas. With well-linked roads and multiple transport options, the location ensures effortless movement.";
    private const SILVER_DESCRIPTION = 'At Silver Terraces, contemporary living meets a relaxed residential atmosphere, creating a space that feels peaceful while still connected to the lively energy of Westlands. Located off Rhapta Road, the development offers a warm and comfortable environment that makes everyday city living feel more enjoyable.';
    private const SILVER_IDEAL_DESCRIPTION = 'Located just off Rhapta Road in the tranquil Westlands neighbourhood, Silver Terraces offers excellent road connectivity and convenient access to key shopping malls, schools, restaurants, hospitals, and business hubs within the city. Its prime location blends the ease of urban accessibility with the comfort and privacy of a well-positioned residential setting.';
    private const IVORY_DESCRIPTION = 'Ivory Terraces offers a sophisticated and uplifting living experience, where spacious modern interiors and a peaceful atmosphere create a true sense of comfort within the vibrant setting of Westlands. Located off Rhapta Road on Terrace Close, the development blends privacy, warmth, and contemporary upscale living in a setting that feels both inviting and well-connected to the energy of the city.';
    private const IVORY_IDEAL_DESCRIPTION = 'Located in the heart of Westlands off Rhapta Road, Ivory Terraces offers excellent accessibility to major roads, business hubs, shopping malls, restaurants, schools, hospitals, and entertainment spots within Nairobi. Its central location places residents close to the convenience and energy of the city while still enjoying the comfort of a private residential setting.';
    private const CONVEX_DESCRIPTION = 'Nestled in the heart of Westlands, The Convex creates an environment where the pace of the city feels distant and productivity flourishes effortlessly. More than just a workplace, it is thoughtfully designed to inspire clarity, creativity, and purposeful work. Its ambiance and understated elegance foster a sense of focus within a space that feels both professional and refreshingly inspiring.';
    private const CONVEX_IDEAL_DESCRIPTION = 'Strategically located on Riverside Lane in Westlands, The Convex is a completed, ready-to-use office development offering seamless connectivity to Lavington, Kilimani, and Nairobi CBD within just 15 minutes. With multiple access points and close proximity to banks, restaurants, hotels, prime residential neighbourhoods, the Australian High Commission, and the Netherlands Embassy, it places business and convenience at the center of everyday work life.';
    private const CHILLY_DESCRIPTION = 'Chilly Breezes offers a refreshing and inviting living experience, where well-lit modern spaces and a relaxed atmosphere create a comforting escape within Westlands. Located along Piliplili Way, the development brings together warmth, privacy, and convenience in a setting that feels peaceful, welcoming, and well-connected.';
    private const CHILLY_IDEAL_DESCRIPTION = 'Located along Piliplili Way off Rhapta Road in the vibrant city of Westlands, Chilly Breezes places residents within easy reach of schools, hospitals, shopping malls, and popular restaurants, making everyday living both convenient and well-connected. With modern apartment design, impressive amenities, and quick access to key lifestyle amenities, the development offers a comfortable urban setting suited for residents who value both accessibility and contemporary living.';
    private const HAVEN_DESCRIPTION = 'Set in the peaceful neighbourhood of Loresho, this exclusive villa development offers beautifully designed homes surrounded by lush gardens, creating a calm and refined living environment where comfort, privacy, and nature come together effortlessly.';
    private const HAVEN_IDEAL_DESCRIPTION = 'Located in the serene and well-established neighbourhood of Loresho, this villa development enjoys excellent accessibility to key parts of Nairobi. It is well connected via Waiyaki Way and Lower Kabete Road, allowing for smooth travel to Westlands, the CBD, and surrounding suburbs. Residents are also within convenient reach of essential amenities such as reputable schools, shopping centres, healthcare facilities including Lions SightFirst Eye Hospital, and several recreational spots.';
    private const OAK_IVY_DESCRIPTION = 'Oak & Ivy redefines modern living in Loresho, where refined architecture meets a serene, nature-rich environment designed for balance and connection. The development is home to two distinct villas, each thoughtfully crafted to blend privacy with a strong sense of community. Lush gardens and quiet green pockets weave gently through the property, adding a refreshing rhythm to everyday life. Here, living feels intentional, with comfort, elegance, and a sense of belonging coming together effortlessly.';
    private const OAK_IVY_IDEAL_DESCRIPTION = "Set within one of Nairobi's most sought-after neighbourhoods, Oak & Ivy places you in the heart of Loresho's green, secure, and well-established community. Residents enjoy being just minutes from Westlands, with easy access to leading international schools such as ISK, Peponi, and Braeburn, as well as premier shopping destinations. Top medical institutions like Aga Khan and MP Shah Hospitals are within convenient reach, while nearby Karura Forest and scenic walking trails offer a refreshing connection to nature.";
    private const RIVERSIDE_DESCRIPTION = "Sandalwood Riverside brings together refined design, expansive living spaces, and a vibrant urban setting to create a lifestyle that feels both sophisticated and effortless. Surrounded by beautifully landscaped gardens and inviting outdoor spaces, each residence offers a sense of calm within the rhythm of the city. Elegant 2, 3, and 4-bedroom apartments provide the perfect balance of comfort and style, creating an environment where every moment feels elevated. It's a place where modern living finds its natural rhythm, neighbours become community, and everyday life unfolds with ease, elegance, and purpose.";
    private const RIVERSIDE_IDEAL_DESCRIPTION = "Nestled within the Riverside area, Sandalwood Riverside places residents at the centre of convenience and connectivity. With easy access to Westlands, Lavington, Kilimani, and Nairobi's key business hubs, everyday commutes become effortless. Premier schools, healthcare facilities, shopping destinations, restaurants, and recreational amenities are all just moments away, ensuring work, leisure, and family life remain seamlessly connected.";

    /**
     * Display a listing of all projects.
     */
    public function index()
    {
        $projects = Cache::remember('all_projects_list_v10', 3600, function () {
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
                'sandalwood-waterfront' => '/images/projects/sandalwood-waterfront/3I9A8425.JPG',
                'sandalwood-brookside' => '/images/projects/sandalwood-brookside/3I9A7558.JPG.jpeg',
                'the-colosseum-residences' => '/images/projects/the-colosseum-residences/3I9A7797.JPG',
                'silver-terraces' => '/images/projects/silver-terraces/3I9A0030.JPG',
                'ivory-terraces' => '/images/projects/ivory-terraces/3I9A0207.JPG',
                'the-convex' => '/images/projects/the-convex/3I9A0304.JPG',
                'chilly-breezes' => '/images/projects/chilly-breezes/3I9A9604.JPG',
                'the-haven' => '/images/projects/the-haven/3I9A7215.JPG',
                'oak-and-ivy' => '/images/projects/oak%26ivy/3I9A6581.jpg',
                'sandalwood-riverside' => '/images/projects/sandalwood-riverside/3I9A0478.JPG',
                default => $referenceProject['images'][0],
            };
            $idealImage = match ($slug) {
                'sandalwood-loresho' => '/images/projects/sandalwood-loresho/IMG-20251113-WA0018.jpg',
                'sandalwood-kitisuru' => '/images/projects/sandalwood-kitisuru/2.JPG',
                'sandalwood-othaya' => '/images/projects/sandalwood-othaya/3I9A8056-2.JPG',
                'sandalwood-waterfront' => '/images/projects/sandalwood-waterfront/3I9A8351.JPG',
                'sandalwood-brookside' => '/images/projects/sandalwood-brookside/3I9A7580.JPG.jpeg',
                'the-colosseum-residences' => '/images/projects/the-colosseum-residences/1.png',
                'silver-terraces' => '/images/projects/silver-terraces/3I9A0027.JPG',
                'ivory-terraces' => '/images/projects/ivory-terraces/3I9A0277.JPG',
                'the-convex' => '/images/projects/the-convex/3I9A0335.JPG',
                'chilly-breezes' => '/images/projects/chilly-breezes/3I9A9764.JPG',
                'the-haven' => '/images/projects/the-haven/3I9A7217-2.JPG',
                'oak-and-ivy' => '/images/projects/oak%26ivy/3I9A6652.JPG',
                'sandalwood-riverside' => '/images/projects/sandalwood-riverside/3I9A0491.JPG',
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
                        'sandalwood-waterfront' => 'Karen, Nairobi, Kenya',
                        'sandalwood-brookside' => 'Brookside Gardens, Westlands, Nairobi',
                        'the-colosseum-residences' => 'Westlands, Nairobi, Kenya',
                        'silver-terraces' => 'Rhapta Road, Westlands, Nairobi',
                        'ivory-terraces' => 'Terrace Close, off Rhapta Road, Westlands, Nairobi',
                        'the-convex' => 'Riverside Lane, Westlands, Nairobi',
                        'chilly-breezes' => 'Piliplili Way, Westlands, Nairobi',
                        'the-haven' => 'Loresho, Nairobi, Kenya',
                        'oak-and-ivy' => 'Loresho, Nairobi, Kenya',
                        'sandalwood-riverside' => 'Riverside, Nairobi, Kenya',
                        default => '',
                    },
                    'location_url' => match ($slug) {
                        'sandalwood-loresho' => Project::LORESHO_MAPS_URL,
                        'sandalwood-kitisuru' => Project::KITISURU_MAPS_URL,
                        'sandalwood-othaya' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Othaya%2C+Othaya+Road%2C+Lavington%2C+Nairobi',
                        'sandalwood-waterfront' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Waterfront%2C+Karen%2C+Nairobi%2C+Kenya',
                        'sandalwood-brookside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Brookside+Gardens%2C+Westlands%2C+Nairobi%2C+Kenya',
                        'the-colosseum-residences' => 'https://www.google.com/maps/search/?api=1&query=The+Colosseum+Residences%2C+Westlands%2C+Nairobi%2C+Kenya',
                        'silver-terraces' => 'https://www.google.com/maps/search/?api=1&query=Silver+Terraces%2C+Rhapta+Road%2C+Westlands%2C+Nairobi',
                        'ivory-terraces' => 'https://www.google.com/maps/search/?api=1&query=Ivory+Terraces%2C+Terrace+Close%2C+Westlands%2C+Nairobi',
                        'the-convex' => 'https://www.google.com/maps/search/?api=1&query=The+Convex%2C+Riverside+Lane%2C+Westlands%2C+Nairobi',
                        'chilly-breezes' => 'https://www.google.com/maps/search/?api=1&query=Chilly+Breezes%2C+Piliplili+Way%2C+Westlands%2C+Nairobi',
                        'the-haven' => 'https://www.google.com/maps/search/?api=1&query=The+Haven%2C+Loresho%2C+Nairobi',
                        'oak-and-ivy' => 'https://www.google.com/maps/search/?api=1&query=Oak+and+Ivy%2C+Loresho%2C+Nairobi',
                        'sandalwood-riverside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Riverside%2C+Riverside%2C+Nairobi',
                        default => null,
                    },
                    'specifications' => match ($slug) {
                        'sandalwood-loresho' => '3 & 4 BEDROOM APARTMENTS',
                        'sandalwood-kitisuru' => '5 BEDROOM VILLAS',
                        'sandalwood-othaya' => '3 BEDROOM APARTMENTS',
                        'sandalwood-waterfront' => '5 BEDROOM APARTMENTS',
                        'sandalwood-brookside' => '3 BEDROOM APARTMENTS',
                        'the-colosseum-residences' => '2, 3 & 4 BEDROOM APARTMENTS',
                        'silver-terraces' => '2 & 3 BEDROOM APARTMENTS',
                        'ivory-terraces' => '2 & 3 BEDROOM APARTMENTS',
                        'the-convex' => '11 FLOORS',
                        'chilly-breezes' => '1, 2 & 3 BEDROOM APARTMENTS',
                        'the-haven' => '4 & 5 BEDROOM APARTMENTS',
                        'oak-and-ivy' => '4 & 5 BEDROOM APARTMENTS',
                        'sandalwood-riverside' => '2, 3 & 4 BEDROOM APARTMENTS',
                        default => null,
                    },
                    'status' => $referenceProject['status'],
                    'is_featured' => false,
                    'description' => match ($slug) {
                        'sandalwood-loresho' => 'An exclusive collection of residential apartments set within the tranquil and serene surroundings of Loresho, Nairobi. Designed to offer a perfect balance of serenity and modern convenience, the development features thoughtfully planned living spaces complemented by a selection of recreational and functional amenities.',
                        'sandalwood-kitisuru' => self::KITISURU_DESCRIPTION,
                        'sandalwood-othaya' => self::OTHAYA_DESCRIPTION,
                        'sandalwood-waterfront' => self::WATERFRONT_DESCRIPTION,
                        'sandalwood-brookside' => self::BROOKSIDE_DESCRIPTION,
                        'the-colosseum-residences' => self::COLOSSEUM_DESCRIPTION,
                        'silver-terraces' => self::SILVER_DESCRIPTION,
                        'ivory-terraces' => self::IVORY_DESCRIPTION,
                        'the-convex' => self::CONVEX_DESCRIPTION,
                        'chilly-breezes' => self::CHILLY_DESCRIPTION,
                        'the-haven' => self::HAVEN_DESCRIPTION,
                        'oak-and-ivy' => self::OAK_IVY_DESCRIPTION,
                        'sandalwood-riverside' => self::RIVERSIDE_DESCRIPTION,
                        default => 'Project information will be updated soon.',
                    },
                    'image' => $coverImage,
                    'cover_image' => $coverImage,
                    'ideal_title' => 'THE IDEAL SETTING',
                    'ideal_description' => match ($slug) {
                        'sandalwood-loresho' => "Sandalwood Loresho is just a 2-minute drive from Lions SightFirst Eye Hospital. The development ensures access to quality healthcare, while nearby retail centers, international schools, and lifestyle hubs in Westlands and the wider Nairobi area are all within a short drive. Seamless connectivity via Waiyaki Way and Lower Kabete Road allows for easy access to Nairobi's key destinations, all while preserving the calm, green charm that defines Loresho.",
                        'sandalwood-kitisuru' => self::KITISURU_IDEAL_DESCRIPTION,
                        'sandalwood-othaya' => self::OTHAYA_IDEAL_DESCRIPTION,
                        'sandalwood-waterfront' => self::WATERFRONT_IDEAL_DESCRIPTION,
                        'sandalwood-brookside' => self::BROOKSIDE_IDEAL_DESCRIPTION,
                        'the-colosseum-residences' => self::COLOSSEUM_IDEAL_DESCRIPTION,
                        'silver-terraces' => self::SILVER_IDEAL_DESCRIPTION,
                        'ivory-terraces' => self::IVORY_IDEAL_DESCRIPTION,
                        'the-convex' => self::CONVEX_IDEAL_DESCRIPTION,
                        'chilly-breezes' => self::CHILLY_IDEAL_DESCRIPTION,
                        'the-haven' => self::HAVEN_IDEAL_DESCRIPTION,
                        'oak-and-ivy' => self::OAK_IVY_IDEAL_DESCRIPTION,
                        'sandalwood-riverside' => self::RIVERSIDE_IDEAL_DESCRIPTION,
                        default => null,
                    },
                    'ideal_image' => $idealImage,
                    'tranquil_title' => 'A TRANQUIL RETREAT',
                    'tranquil_description' => match ($slug) {
                        'sandalwood-kitisuru' => self::KITISURU_TRANQUIL_DESCRIPTION,
                        'sandalwood-brookside' => self::BROOKSIDE_TRANQUIL_DESCRIPTION,
                        default => null,
                    },
                    'tranquil_image' => match ($slug) {
                        'sandalwood-kitisuru' => '/images/projects/sandalwood-kitisuru/3.JPG',
                        'sandalwood-brookside' => '/images/projects/sandalwood-brookside/3I9A7574.JPG.jpeg',
                        default => $referenceProject['images'][0],
                    },
                    'gallery' => $gallery,
                    'amenities' => [],
                    'created_at' => now()->toISOString(),
                    'updated_at' => now()->toISOString(),
                ],
            ]);
        }

        $project = Cache::remember("project_v9_{$slug}", 3600, function () use ($slug) {

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
            $waterfrontHeroImage = $project->slug === 'sandalwood-waterfront'
                ? $this->projectFolderImage($folderImages, '3I9A8425.JPG')
                : null;
            $waterfrontIdealImage = $project->slug === 'sandalwood-waterfront'
                ? $this->projectFolderImage($folderImages, '3I9A8351.JPG')
                : null;
            $brooksideHeroImage = $project->slug === 'sandalwood-brookside'
                ? $this->projectFolderImage($folderImages, '3I9A7558.JPG.jpeg')
                : null;
            $brooksideIdealImage = $project->slug === 'sandalwood-brookside'
                ? $this->projectFolderImage($folderImages, '3I9A7580.JPG.jpeg')
                : null;
            $brooksideTranquilImage = $project->slug === 'sandalwood-brookside'
                ? $this->projectFolderImage($folderImages, '3I9A7574.JPG.jpeg')
                : null;
            $colosseumHeroImage = $project->slug === 'the-colosseum-residences'
                ? $this->projectFolderImage($folderImages, '3I9A7797.JPG')
                : null;
            $colosseumIdealImage = $project->slug === 'the-colosseum-residences'
                ? $this->projectFolderImage($folderImages, '1.png')
                : null;
            $terraceImages = [
                'silver-terraces' => ['hero' => '3I9A0030.JPG', 'ideal' => '3I9A0027.JPG'],
                'ivory-terraces' => ['hero' => '3I9A0207.JPG', 'ideal' => '3I9A0277.JPG'],
                'the-convex' => ['hero' => '3I9A0304.JPG', 'ideal' => '3I9A0335.JPG'],
                'chilly-breezes' => ['hero' => '3I9A9604.JPG', 'ideal' => '3I9A9764.JPG'],
                'the-haven' => ['hero' => '3I9A7215.JPG', 'ideal' => '3I9A7217-2.JPG'],
                'oak-and-ivy' => ['hero' => '3I9A6581.jpg', 'ideal' => '3I9A6652.JPG'],
                'sandalwood-riverside' => ['hero' => '3I9A0478.JPG', 'ideal' => '3I9A0491.JPG'],
            ];
            $projectHeroImage = isset($terraceImages[$project->slug])
                ? $this->projectFolderImage($folderImages, $terraceImages[$project->slug]['hero'])
                : null;
            $projectIdealImage = isset($terraceImages[$project->slug])
                ? $this->projectFolderImage($folderImages, $terraceImages[$project->slug]['ideal'])
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
            } elseif ($project->slug === 'sandalwood-waterfront' && str_word_count((string) $description) < 20) {
                $description = self::WATERFRONT_DESCRIPTION;
            } elseif ($project->slug === 'sandalwood-brookside' && str_word_count((string) $description) < 20) {
                $description = self::BROOKSIDE_DESCRIPTION;
            } elseif ($project->slug === 'the-colosseum-residences' && str_word_count((string) $description) < 20) {
                $description = self::COLOSSEUM_DESCRIPTION;
            } elseif ($project->slug === 'silver-terraces' && str_word_count((string) $description) < 20) {
                $description = self::SILVER_DESCRIPTION;
            } elseif ($project->slug === 'ivory-terraces' && str_word_count((string) $description) < 20) {
                $description = self::IVORY_DESCRIPTION;
            } elseif ($project->slug === 'the-convex' && str_word_count((string) $description) < 20) {
                $description = self::CONVEX_DESCRIPTION;
            } elseif ($project->slug === 'chilly-breezes' && str_word_count((string) $description) < 20) {
                $description = self::CHILLY_DESCRIPTION;
            } elseif ($project->slug === 'the-haven' && str_word_count((string) $description) < 20) {
                $description = self::HAVEN_DESCRIPTION;
            } elseif ($project->slug === 'oak-and-ivy' && str_word_count((string) $description) < 20) {
                $description = self::OAK_IVY_DESCRIPTION;
            } elseif ($project->slug === 'sandalwood-riverside' && str_word_count((string) $description) < 20) {
                $description = self::RIVERSIDE_DESCRIPTION;
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

                'location' => $project->slug === 'sandalwood-othaya'
                    ? 'Othaya Road, Lavington, Nairobi'
                    : ($project->slug === 'sandalwood-waterfront'
                        ? 'Karen, Nairobi, Kenya'
                        : ($project->slug === 'sandalwood-brookside'
                            ? 'Brookside Gardens, Westlands, Nairobi'
                            : (match ($project->slug) {
                                'silver-terraces' => 'Rhapta Road, Westlands, Nairobi',
                                'ivory-terraces' => 'Terrace Close, off Rhapta Road, Westlands, Nairobi',
                                'the-convex' => 'Riverside Lane, Westlands, Nairobi',
                                'chilly-breezes' => 'Piliplili Way, Westlands, Nairobi',
                                'the-haven' => 'Loresho, Nairobi, Kenya',
                                'oak-and-ivy' => 'Loresho, Nairobi, Kenya',
                                'sandalwood-riverside' => 'Riverside, Nairobi, Kenya',
                                default => $project->location,
                            }))),

                'location_url' => $project->location_url
                    ?: match ($project->slug) {
                        'sandalwood-loresho' => Project::LORESHO_MAPS_URL,
                        'sandalwood-kitisuru' => Project::KITISURU_MAPS_URL,
                        'sandalwood-othaya' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Othaya%2C+Othaya+Road%2C+Lavington%2C+Nairobi',
                        'sandalwood-waterfront' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Waterfront%2C+Karen%2C+Nairobi%2C+Kenya',
                        'sandalwood-brookside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Brookside+Gardens%2C+Westlands%2C+Nairobi%2C+Kenya',
                        'the-colosseum-residences' => 'https://www.google.com/maps/search/?api=1&query=The+Colosseum+Residences%2C+Westlands%2C+Nairobi%2C+Kenya',
                        'silver-terraces' => 'https://www.google.com/maps/search/?api=1&query=Silver+Terraces%2C+Rhapta+Road%2C+Westlands%2C+Nairobi',
                        'ivory-terraces' => 'https://www.google.com/maps/search/?api=1&query=Ivory+Terraces%2C+Terrace+Close%2C+Westlands%2C+Nairobi',
                        'the-convex' => 'https://www.google.com/maps/search/?api=1&query=The+Convex%2C+Riverside+Lane%2C+Westlands%2C+Nairobi',
                        'chilly-breezes' => 'https://www.google.com/maps/search/?api=1&query=Chilly+Breezes%2C+Piliplili+Way%2C+Westlands%2C+Nairobi',
                        'the-haven' => 'https://www.google.com/maps/search/?api=1&query=The+Haven%2C+Loresho%2C+Nairobi',
                        'oak-and-ivy' => 'https://www.google.com/maps/search/?api=1&query=Oak+and+Ivy%2C+Loresho%2C+Nairobi',
                        'sandalwood-riverside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Riverside%2C+Riverside%2C+Nairobi',
                        default => null,
                    },

                'specifications' => $project->specifications
                    ?: match ($project->slug) {
                        'sandalwood-loresho' => '3 & 4 BEDROOM APARTMENTS',
                        'sandalwood-kitisuru' => '5 BEDROOM VILLAS',
                        'sandalwood-othaya' => '3 BEDROOM APARTMENTS',
                        'sandalwood-waterfront' => '5 BEDROOM APARTMENTS',
                        'sandalwood-brookside' => '3 BEDROOM APARTMENTS',
                        'the-colosseum-residences' => '2, 3 & 4 BEDROOM APARTMENTS',
                        'silver-terraces' => '2 & 3 BEDROOM APARTMENTS',
                        'ivory-terraces' => '2 & 3 BEDROOM APARTMENTS',
                        'the-convex' => '11 FLOORS',
                        'chilly-breezes' => '1, 2 & 3 BEDROOM APARTMENTS',
                        'the-haven' => '4 & 5 BEDROOM APARTMENTS',
                        'oak-and-ivy' => '4 & 5 BEDROOM APARTMENTS',
                        'sandalwood-riverside' => '2, 3 & 4 BEDROOM APARTMENTS',
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

                'cover_image' => $colosseumHeroImage
                    ?: $projectHeroImage
                    ?: $loreshoHeroImage
                    ?: $kitisuruHeroImage
                    ?: $othayaHeroImage
                    ?: $waterfrontHeroImage
                    ?: $brooksideHeroImage
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
                        'sandalwood-waterfront' => self::WATERFRONT_IDEAL_DESCRIPTION,
                        'sandalwood-brookside' => self::BROOKSIDE_IDEAL_DESCRIPTION,
                        'the-colosseum-residences' => self::COLOSSEUM_IDEAL_DESCRIPTION,
                        'silver-terraces' => self::SILVER_IDEAL_DESCRIPTION,
                        'ivory-terraces' => self::IVORY_IDEAL_DESCRIPTION,
                        'the-convex' => self::CONVEX_IDEAL_DESCRIPTION,
                        'chilly-breezes' => self::CHILLY_IDEAL_DESCRIPTION,
                        'the-haven' => self::HAVEN_IDEAL_DESCRIPTION,
                        'oak-and-ivy' => self::OAK_IVY_IDEAL_DESCRIPTION,
                        'sandalwood-riverside' => self::RIVERSIDE_IDEAL_DESCRIPTION,
                        default => null,
                    },

                'ideal_image' => $colosseumIdealImage
                    ?: $projectIdealImage
                    ?: $loreshoIdealImage
                    ?: $kitisuruIdealImage
                    ?: $othayaIdealImage
                    ?: $waterfrontIdealImage
                    ?: $brooksideIdealImage
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
                    ?: match ($project->slug) {
                        'sandalwood-kitisuru' => self::KITISURU_TRANQUIL_DESCRIPTION,
                        'sandalwood-brookside' => self::BROOKSIDE_TRANQUIL_DESCRIPTION,
                        default => null,
                    },

                'tranquil_image' => $kitisuruTranquilImage
                    ?: $brooksideTranquilImage
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

        if ($slug === 'sandalwood-waterfront') {
            return match ($filename) {
                '3I9A8425.JPG' => 'Sandalwood Waterfront bridge over the lake',
                '3I9A8351.JPG', '3I9A8393.JPG' => 'Sandalwood Waterfront landscaped gardens and lake',
                '3I9A8683.JPG' => 'Sandalwood Waterfront gardens and estate road',
                '3I9A8548.JPG', '3I9A8407.JPG' => 'Sandalwood Waterfront villa and gardens',
                '3I9A8628.JPG' => 'Sandalwood Waterfront swimming pool',
                default => 'Sandalwood Waterfront gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'sandalwood-brookside') {
            return match ($filename) {
                '3I9A7539.JPG.jpeg' => 'Sandalwood Brookside main entrance',
                '3I9A7660.JPG.jpeg' => 'Sandalwood Brookside driveway',
                '3I9A7558.JPG.jpeg', '3I9A7580.JPG.jpeg', '3I9A7582.JPG.jpeg' => 'Sandalwood Brookside landscaped garden path',
                '3I9A7574.JPG.jpeg' => 'Sandalwood Brookside garden and residences',
                '3I9A7622.JPG.jpeg' => 'Sandalwood Brookside swimming pool',
                default => 'Sandalwood Brookside gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'the-colosseum-residences') {
            return match ($filename) {
                '3I9A7797.JPG' => 'The Colosseum residence opening to a garden terrace',
                '1.png' => 'The Colosseum Residences exterior',
                '3I9A7849.JPG' => 'The Colosseum balcony overlooking Karura Forest',
                '3I9A7706.JPG' => 'The Colosseum landscaped courtyard',
                '3I9A8033.JPG' => 'The Colosseum residents gym',
                default => 'The Colosseum Residences gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'silver-terraces') {
            return match ($filename) {
                '3I9A0030.JPG' => 'Silver Terraces landscaped entrance',
                '3I9A0027.JPG' => 'Silver Terraces residential driveway',
                '3I9A0049.JPG' => 'Silver Terraces living room',
                '3I9A0102.JPG' => 'Silver Terraces dining room',
                default => 'Silver Terraces gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'ivory-terraces') {
            return match ($filename) {
                '3I9A0207.JPG', 'Ivory(2).jpeg' => 'Ivory Terraces rooftop swimming pool',
                '3I9A0277.JPG' => 'Ivory Terraces landscaped entrance',
                '3I9A9890.JPG' => 'Ivory Terraces living room',
                '3I9A9866.JPG' => 'Ivory Terraces bedroom',
                default => 'Ivory Terraces gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'the-convex') {
            return match ($filename) {
                '3I9A0304.JPG' => 'The Convex reception lobby',
                '3I9A0335.JPG' => 'The Convex office building',
                '3I9A0315.JPG' => 'The Convex main entrance',
                '2.png' => 'The Convex exterior and driveway',
                default => 'The Convex gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'chilly-breezes') {
            return match ($filename) {
                '3I9A9604.JPG' => 'Chilly Breezes rooftop terrace',
                '3I9A9652.JPG' => 'Chilly Breezes rooftop pool deck',
                '3I9A9792.JPG' => 'Chilly Breezes residential entrance',
                '3I9A9764.JPG' => 'Chilly Breezes landscaped residential courtyard',
                default => 'Chilly Breezes gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'the-haven') {
            return match ($filename) {
                '3I9A7215.JPG' => 'The Haven villa and landscaped garden',
                '3I9A7217-2.JPG' => 'The Haven villa exterior',
                '3I9A7266.JPG' => 'The Haven landscaped entrance path',
                '3I9A7331.JPG' => 'The Haven swimming pool and garden',
                default => 'The Haven gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'oak-and-ivy') {
            return match ($filename) {
                '3I9A6581.jpg' => 'Oak & Ivy living room with garden views',
                '3I9A6652.JPG' => 'Oak & Ivy grand staircase and entrance',
                '3I9A6986.jpg' => 'Oak & Ivy Village 2 living room',
                '3I9A6033.JPG' => 'Oak & Ivy Village 2 bedroom',
                '3I9A6622.JPG' => 'Oak & Ivy Village 3 living room',
                '3I9A6704.jpg' => 'Oak & Ivy Village 3 kitchen',
                '3I9A6381.JPG' => 'Oak & Ivy villa exterior',
                '3I9A7128.JPG' => 'Oak & Ivy swimming pool and villas',
                default => 'Oak & Ivy villa gallery image ' . ($index + 1),
            };
        }

        if ($slug === 'sandalwood-riverside') {
            return match ($filename) {
                '3I9A0478.JPG' => 'Sandalwood Riverside garden paths and apartments',
                '3I9A0491.JPG' => 'Sandalwood Riverside entrance gate',
                '3I9A0436.JPG', '3I9A0448.JPG' => 'Sandalwood Riverside landscaped garden path',
                '3I9A0422.JPG', '3I9A0429.JPG' => 'Sandalwood Riverside swimming pool',
                default => 'Sandalwood Riverside gallery image ' . ($index + 1),
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
