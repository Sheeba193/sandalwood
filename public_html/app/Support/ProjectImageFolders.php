<?php

namespace App\Support;

use FilesystemIterator;

class ProjectImageFolders
{
    private const FOLDER_NAMES = [
        'oak-and-ivy' => 'oak&ivy',
    ];

    private const ORDERED_FILES = [
        'sandalwood-clyde-gardens' => [
            'clyde1.jpg',
            'clyde2.jpg',
            'clyde3.jpg',
            'clyde4.jpg',
            'clyde5.jpg',
            'clyde6.jpg',
            'clyde7.jpg',
        ],
        'sandalwood-kyuna' => [
            'WhatsApp Image 2026-10-03 at 09.53.10 (2).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.07 (1).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.07.jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.08 (1).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.08 (2).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.08.jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.09 (1).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.09 (2).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.09 (3).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.09.jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.10 (1).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.10.jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.11 (1).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.11 (2).jpeg',
            'WhatsApp Image 2026-10-03 at 09.53.11.jpeg',
        ],
        'sandalwood-loresho' => [
            'loresho.jpg',
            'IMG-20251113-WA0018.jpg',
            'loresho4.jpg',
            'loresho5.jpg',
            'IMG-20251113-WA0015.jpg',
            'IMG-20251113-WA0017.jpg',
            'IMG-20251113-WA0021.jpg',
            'IMG-20251113-WA0019.jpg',
            'IMG-20251113-WA0024.jpg',
            'IMG-20251113-WA0025.jpg',
        ],
        'sandalwood-kitisuru' => [
            '4.JPG',
            '12.JPG',
            '5.JPG',
            '6.JPG',
            '8.JPG',
            '28.JPG',
            '11.JPG',
            '3.JPG',
            '2.JPG',
            '1.JPG',
        ],
        'sandalwood-othaya' => [
            '3I9A8078.JPG',
            '3I9A8066.JPG',
            '3I9A8056-2.JPG',
            '3I9A8117-2.JPG',
            '3I9A8128.JPG',
            '3I9A8108.JPG',
            '3I9A8148.JPG',
            '3I9A8157-2.JPG',
            '3I9A8204.JPG',
        ],
        'sandalwood-waterfront' => [
            '3I9A8393.JPG',
            '3I9A8683.JPG',
            '3I9A8425.JPG',
            '3I9A8351.JPG',
            '3I9A8548.JPG',
            '3I9A8407.JPG',
            '3I9A8628.JPG',
            '3I9A8582.JPG',
            '3I9A8677.JPG',
            '3I9A8217.JPG',
            '3I9A8242.JPG',
            '3I9A8371.JPG',
        ],
        'sandalwood-brookside' => [
            '3I9A7539.JPG.jpeg',
            '3I9A7660.JPG.jpeg',
            '3I9A7580.JPG.jpeg',
            '3I9A7574.JPG.jpeg',
            '3I9A7558.JPG.jpeg',
            '3I9A7582.JPG.jpeg',
            '3I9A7577.JPG.jpeg',
            '3I9A7594.JPG.jpeg',
            '3I9A7565.JPG.jpeg',
            '3I9A7555.JPG.jpeg',
            '3I9A7622.JPG.jpeg',
        ],
        'the-colosseum-residences' => [
            '3I9A7849.JPG',
            '3I9A7706.JPG',
            '3I9A7797.JPG',
            '1.png',
            '3I9A7912.JPG',
            '3I9A8033.JPG',
            '3I9A7738.JPG',
            '3I9A7747.JPG',
            '3I9A7750.JPG',
            '3I9A7779.JPG',
            '3I9A7884.JPG',
            '3I9A7893.JPG',
            '3I9A8003.JPG',
        ],
        'silver-terraces' => [
            '3I9A0049.JPG',
            '3I9A0102.JPG',
            '3I9A0030.JPG',
            '3I9A0027.JPG',
            '3I9A0024.JPG',
            '3I9A0069.JPG',
            '3I9A0089.JPG',
            '3I9A0128.JPG',
        ],
        'ivory-terraces' => [
            '3I9A9890.JPG',
            '3I9A9866.JPG',
            '3I9A0207.JPG',
            '3I9A0277.JPG',
            '3I9A0258.JPG',
            '3I9A0189.JPG',
            '3I9A9883.JPG',
            '3I9A9930.JPG',
            'Ivory(2).jpeg',
        ],
        'the-convex' => [
            '2.png',
            '3I9A0315.JPG',
            '3I9A0304.JPG',
            '3I9A0335.JPG',
            '3I9A0324.JPG',
            '3I9A0340.JPG',
            '3I9A0369.JPG',
            '3I9A0403.JPG',
            '3I9A0407.JPG',
        ],
        'chilly-breezes' => [
            '3I9A9604.JPG',
            '3I9A9652.JPG',
            '3I9A9792.JPG',
            '3I9A9764.JPG',
            '3I9A9624.JPG',
            '3I9A9691.JPG',
            '3I9A9723.JPG',
            '3I9A9754.JPG',
        ],
        'the-haven' => [
            '3I9A7266.JPG',
            '3I9A7331.JPG',
            '3I9A7215.JPG',
            '3I9A7217-2.JPG',
            '3I9A7199.JPG',
            '3I9A7206.JPG',
            '3I9A7308.JPG',
            '3I9A7317-2.JPG',
            '3I9A7326.JPG',
            '3I9A7242.JPG',
            '3I9A7345.JPG',
        ],
        'oak-and-ivy' => [
            '3I9A6581.jpg',
            '3I9A6652.JPG',
            '3I9A6986.jpg',
            '3I9A6033.JPG',
            '3I9A6622.JPG',
            '3I9A6704.jpg',
            '3I9A6058.JPG',
            '3I9A6381.JPG',
            '3I9A6731.jpg',
            '3I9A6814.jpg',
            '3I9A6821.jpg',
            '3I9A6896.jpg',
            '3I9A7034.jpg',
            '3I9A7045.JPG',
            '3I9A7079.JPG',
            '3I9A7128.JPG',
            '3I9A7162-2.JPG',
        ],
        'sandalwood-riverside' => [
            '3I9A0475.JPG',
            '3I9A0436.JPG',
            '3I9A0478.JPG',
            '3I9A0485.JPG',
            '3I9A0491.JPG',
            '3I9A0422.JPG',
            '3I9A0429.JPG',
            '3I9A0448.JPG',
            '3I9A0463.JPG',
            '3I9A0486.JPG',
        ],
    ];

    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

    public static function hasImages(string $slug): bool
    {
        return self::images($slug) !== [];
    }

    /** @return list<string> */
    public static function images(string $slug): array
    {
        $folder = self::FOLDER_NAMES[$slug] ?? $slug;
        $directory = public_path('images/projects/' . $folder);

        if (! is_dir($directory)) {
            return [];
        }

        $files = [];
        foreach (new FilesystemIterator($directory, FilesystemIterator::SKIP_DOTS) as $file) {
            if ($file->isFile() && in_array(strtolower($file->getExtension()), self::IMAGE_EXTENSIONS, true)) {
                $files[] = $file->getFilename();
            }
        }

        if (isset(self::ORDERED_FILES[$slug])) {
            $files = array_values(array_intersect(self::ORDERED_FILES[$slug], $files));
        } else {
            sort($files, SORT_NATURAL | SORT_FLAG_CASE);
        }

        return array_map(
            fn (string $filename): string => '/images/projects/' . rawurlencode($folder) . '/' . rawurlencode($filename),
            $files,
        );
    }
}
