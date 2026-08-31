<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingProjects\Models\ListingProject;
use Modules\ListingProjects\Models\ListingProjectImage;

class ProjectController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $this->authorize('viewAny', [ListingProject::class, $business]);

        $perPage = min((int) $request->get('per_page', 10), 100);
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'sort_order');
        $direction = $request->get('direction', 'asc');
        $categoryId = $request->get('category');

        $allowedSorts = ['title', 'is_active', 'is_featured', 'sort_order', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'sort_order';
        }
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $query = $business->projects()
            ->with('category')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereJsonContains('tags', $search);
                });
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                if ($categoryId === 'uncategorized') {
                    $q->whereNull('category_id');
                } else {
                    $q->where('category_id', $categoryId);
                }
            })
            ->orderBy($sort, $direction)
            ->orderBy('title');

        $projects = $query->paginate($perPage);

        $projects->getCollection()->transform(function ($project) {
            if ($project->image) {
                $project->image = "/storage/{$project->image}";
            }
            return $project;
        });

        $categories = $business->projectCategories()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $dataTable = [
            'data' => $projects->items(),
            'current_page' => $projects->currentPage(),
            'last_page' => $projects->lastPage(),
            'per_page' => $projects->perPage(),
            'total' => $projects->total(),
            'from' => $projects->firstItem(),
            'to' => $projects->lastItem(),
        ];

        return Inertia::render('Member/Projects/Index', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'projects' => $projects,
            'categories' => $categories,
            'dataTable' => $dataTable,
            'selectedCategory' => $categoryId,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        $this->authorize('create', [ListingProject::class, $business]);

        $categories = $business->projectCategories()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Member/Projects/Create', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'categories' => $categories,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $this->authorize('create', [ListingProject::class, $business]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('listing_projects')->where('listing_id', $business->id),
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg', 'max:2048'],
            'tags' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:listing_project_categories,id'],
        ]);

        $data['listing_id'] = $business->id;

        if (!empty($data['tags'])) {
            $tagsArray = array_map('trim', explode(',', $data['tags']));
            $data['tags'] = json_encode($tagsArray);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-images', 'public');
            $data['image'] = $path;
        }

        $project = $business->projects()->create($data);

        $activity->log('project_created', [
            'actor' => $request->user(),
            'subject' => $project,
            'description' => 'Proyecto creado',
            'request' => $request,
        ]);

        return redirect()->route('member.listings.projects.index', $business->id)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function edit(Request $request, Listing $business, ListingProject $project)
    {
        $this->authorize('update', [ListingProject::class, $project]);

        $categories = $business->projectCategories()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $projectImages = $project->images()->orderBy('sort_order')->get(['id', 'path', 'filename', 'is_primary']);

        $tagsArray = $project->tags;
        if (is_string($tagsArray)) {
            $tagsArray = json_decode($tagsArray, true) ?? [];
        }
        $tags = is_array($tagsArray) ? implode(', ', $tagsArray) : '';

        return Inertia::render('Member/Projects/Edit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'image' => $project->image ? "/storage/{$project->image}" : null,
                'tags' => $tags,
                'is_active' => $project->is_active,
                'is_featured' => $project->is_featured,
                'sort_order' => $project->sort_order,
                'category_id' => $project->category_id,
            ],
            'categories' => $categories,
            'projectImages' => $projectImages->map(fn($img) => [
                'id' => $img->id,
                'url' => $img->path ? "/storage/{$img->path}" : null,
                'filename' => $img->filename,
                'is_primary' => $img->is_primary,
            ]),
        ]);
    }

    public function update(Request $request, Listing $business, ListingProject $project, ActivityService $activity)
    {
        $this->authorize('update', [ListingProject::class, $project]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('listing_projects')->where('listing_id', $business->id)->ignore($project->id),
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg', 'max:2048'],
            'tags' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:listing_project_categories,id'],
        ]);

        if (!empty($data['tags'])) {
            $tagsArray = array_map('trim', explode(',', $data['tags']));
            $data['tags'] = json_encode($tagsArray);
        } else {
            $data['tags'] = null;
        }

        if ($request->hasFile('image')) {
            if ($project->image) {
                \Storage::disk('public')->delete($project->image);
            }
            $path = $request->file('image')->store('project-images', 'public');
            $data['image'] = $path;
        } elseif ($request->input('_remove_image')) {
            if ($project->image) {
                \Storage::disk('public')->delete($project->image);
            }
            $data['image'] = null;
        }

        $project->update($data);

        $activity->log('project_updated', [
            'actor' => $request->user(),
            'subject' => $project,
            'description' => 'Proyecto actualizado',
            'request' => $request,
        ]);

        return redirect()->route('member.listings.projects.index', $business->id)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingProject $project, ActivityService $activity)
    {
        $this->authorize('delete', [ListingProject::class, $project]);

        $activity->log('project_deleted', [
            'actor' => $request->user(),
            'subject' => $project,
            'description' => 'Proyecto eliminado',
        ]);

        $project->delete();

        return redirect()->route('member.listings.projects.index', $business->id)
            ->with('success', 'Proyecto eliminado correctamente.');
    }

    public function clone(Request $request, Listing $business, ListingProject $project)
    {
        $this->authorize('create', [ListingProject::class, $business]);

        $newProject = $project->replicate();
        $newProject->title = $project->title . ' (Copia)';
        $newProject->slug = \Illuminate\Support\Str::slug($project->title) . '-' . time();
        $newProject->save();

        return redirect()->route('member.listings.projects.edit', [$business->id, $newProject->id])
            ->with('success', 'Proyecto clonado correctamente.');
    }

    public function reorder(Request $request, Listing $business)
    {
        $user = $request->user();

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
        } else {
            abort_unless($business->user_id === $user->id, 403);
        }

        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', \Illuminate\Validation\Rule::exists('listing_projects', 'id')->where('listing_id', $business->id)],
            'page' => ['nullable', 'integer', 'min:1'],
            'perPage' => ['nullable', 'integer', 'min:1'],
        ]);

        $page = $data['page'] ?? 1;
        $perPage = $data['perPage'] ?? count($data['ids']);
        $start = (($page - 1) * $perPage) + 1;

        \DB::transaction(function () use ($data, $business, $start) {
            foreach ($data['ids'] as $index => $id) {
                \Modules\ListingProjects\Models\ListingProject::where('id', $id)
                    ->where('listing_id', $business->id)
                    ->update(['sort_order' => $start + $index]);
            }
        });

        return back(303);
    }

    public function bulkDelete(Request $request, Listing $business)
    {
        $user = $request->user();

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
        } else {
            abort_unless($business->user_id === $user->id, 403);
        }

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', \Illuminate\Validation\Rule::exists('listing_projects', 'id')->where('listing_id', $business->id)],
        ]);

        $count = count($data['ids']);

        \Modules\ListingProjects\Models\ListingProject::where('listing_id', $business->id)
            ->whereIn('id', $data['ids'])
            ->delete();

        $message = $count === 1
            ? "1 proyecto eliminado correctamente."
            : "{$count} proyectos eliminados correctamente.";

        return redirect()->back()
            ->with('success', $message);
    }

    public function reorderImages(Request $request, Listing $business, ListingProject $project)
    {
        $user = $request->user();
        abort_unless($business->user_id === $user->id || $user->hasAnyRole(['superadmin', 'admin']), 403);
        abort_unless($project->listing_id === $business->id, 403);

        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:listing_project_images,id'],
        ]);

        foreach ($data['ids'] as $index => $id) {
            ListingProjectImage::where('id', $id)
                ->where('listing_project_id', $project->id)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
