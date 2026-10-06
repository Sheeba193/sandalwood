<?php

namespace App\Support;

/**
 * Fallback map links for project pages that do not have a saved admin URL.
 * Saved Project.location_url values take precedence over these links.
 */
class ProjectLocationLinks
{
    private const URLS = [
        'sandalwood-loresho' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4919.970799173085!2d36.74429797567676!3d-1.2552488111263767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f19007b338919%3A0xb98835a6bb981f00!2sSandalwood%20Loresho!5e0!3m2!1sen!2ske!4v1773423345983!5m2!1sen!2ske',
        'sandalwood-kitisuru' => 'https://www.google.com/maps/search/?api=1&query=Sandalwood%20Kitisuru%2C%20Nairobi%2C%20Kenya&query_place_id=ChIJr4BV7FoZLxgRYY_F2SP0610',
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
    ];

    public static function forSlug(string $slug): ?string
    {
        return self::URLS[$slug] ?? null;
    }
}
