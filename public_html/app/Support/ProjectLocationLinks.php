<?php

namespace App\Support;

/**
 * Fallback map links for project pages that do not have a saved admin URL.
 * Saved Project.location_url values take precedence over these links.
 */
class ProjectLocationLinks
{
    private const URLS = [
        'sandalwood-loresho' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Loresho%2C+off+Kaptagat+Road%2C+past+Lions+SightFirst+Eye+Hospital%2C+Nairobi',
        'sandalwood-kitisuru' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood%20Kitisuru%2C%20Nairobi%2C%20Kenya&query_place_id=ChIJr4BV7FoZLxgRYY_F2SP0610',
        'sandalwood-othaya' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Othaya%2C+Othaya+Road%2C+Lavington%2C+Nairobi',
        'sandalwood-waterfront' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Waterfront%2C+Marist+Lane%2C+Karen%2C+Nairobi',
        'sandalwood-brookside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Brookside%2C+Brookside+Gardens+Road%2C+Westlands%2C+Nairobi',
        'the-colosseum-residences' => 'https://www.google.com/maps/search/?api=1&query=The+Colosseum+Residences%2C+adjacent+to+City+Park%2C+Parklands%2C+Nairobi',
        'silver-terraces' => 'https://www.google.com/maps/search/?api=1&query=Silver+Terraces%2C+Rhapta+Road%2C+Westlands%2C+Nairobi',
        'ivory-terraces' => 'https://www.google.com/maps/search/?api=1&query=Ivory+Terraces%2C+Terrace+Close%2C+Westlands%2C+Nairobi',
        'the-convex' => 'https://www.google.com/maps/search/?api=1&query=The+Convex%2C+Riverside+Drive%2C+Westlands%2C+Nairobi',
        'chilly-breezes' => 'https://www.google.com/maps/search/?api=1&query=Chilly+Breezes%2C+Piliplili+Way%2C+Westlands%2C+Nairobi',
        'the-haven' => 'https://www.google.com/maps/search/?api=1&query=The+Haven%2C+Loresho%2C+Nairobi',
        'oak-and-ivy' => 'https://www.google.com/maps/search/?api=1&query=Oak+and+Ivy%2C+off+Loresho+Ridge%2C+Loresho%2C+Nairobi',
        'sandalwood-riverside' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Riverside%2C+Sandalwood+Lane%2C+off+Riverside+Drive%2C+Nairobi',
        'sandalwood-clyde-gardens' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood+Clyde+Gardens%2C+Gitanga+Road%2C+Lavington%2C+Nairobi',
    ];

    public static function forSlug(string $slug): ?string
    {
        return self::URLS[$slug] ?? null;
    }
}
