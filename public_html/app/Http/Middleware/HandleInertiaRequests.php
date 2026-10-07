<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Project;
use App\Support\ProjectImageFolders;
use App\Http\Controllers\ProjectController;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'projectNavigation' => fn () => $this->projectNavigation(),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'contact' => [
                'phone' => '+254 725 637456',
                'phone_link' => '+254725637456',
                'emails' => [
                    'info' => 'info@sandalwoodproperties.co.ke',
                    'sales' => 'sales@sandalwoodproperties.co.ke',
                ],
                'hours' => 'Mon–Fri, 8:00 AM–6:00 PM · Sat, 9:00 AM–4:00 PM',
                'address' => [
                    'full' => 'SANDALWOOD Loresho, off kaptagat rd, past Loresho Lions Eye, loresho, Nairobi, Kenya',
                    'building' => 'SANDALWOOD Loresho',
                    'street' => 'off kaptagat rd',
                    'landmark' => 'past Loresho Lions Eye',
                    'area' => 'loresho',
                    'city' => 'Nairobi',
                    'country' => 'Kenya',
                ],
                'social' => [
                    'facebook' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                    'linkedin' => '#',
                ],
            ],
        ];
    }

    private function projectNavigation(): array
    {
        $projects = Project::query()
            ->select(['title', 'slug', 'status', 'is_featured', 'created_at'])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->get()
            ->filter(fn (Project $project) => ProjectImageFolders::hasImages($project->slug))
            ->map(fn (Project $project) => [
                'title' => $project->title,
                'slug' => $project->slug,
                'status' => strtolower((string) $project->status),
            ])
            ->values();

        if ($projects->isNotEmpty()) {
            return $projects->all();
        }

        return collect(app(ProjectController::class)->referenceProjects())
            ->map(fn (array $project) => [
                'title' => $project['title'],
                'slug' => $project['slug'],
                'status' => strtolower((string) $project['status']),
            ])
            ->values()
            ->all();
    }
}
