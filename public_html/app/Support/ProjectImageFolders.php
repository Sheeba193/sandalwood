<?php

namespace App\Support;

use FilesystemIterator;

class ProjectImageFolders
{
    private const FOLDER_NAMES = [
        'oak-and-ivy' => 'oak&ivy',
    ];

    private const ORDERED_FILES = [
        'sandalwood-loresho' => [
            'loresho.jpg',
            'loresho4.jpg',
            'loresho5.jpg',
            'IMG-20251113-WA0015.jpg',
            'IMG-20251113-WA0017.jpg',
            'IMG-20251113-WA0018.jpg',
            'IMG-20251113-WA0021.jpg',
            'IMG-20251113-WA0019.jpg',
            'IMG-20251113-WA0024.jpg',
            'IMG-20251113-WA0025.jpg',
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
