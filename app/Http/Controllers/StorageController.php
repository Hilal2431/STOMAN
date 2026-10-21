<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Contracts\View\View;

class StorageController extends Controller
{
    protected function getUser(): ?User
    {
        return auth('web')->user() ?? auth('api')->user() ?? User::first();
    }

    public function index(): View
    {
        $user = $this->getUser();
        $userId = $user?->id;

        $folders = $userId
            ? Folder::where('user_id', $userId)
                ->whereNull('parent_id')
                ->where('is_trashed', false)
                ->where('is_archived', false)
                ->orderBy('name')
                ->get()
            : collect();

        $files = $userId
            ? FileItem::where('user_id', $userId)
                ->whereNull('folder_id')
                ->where('is_trashed', false)
                ->where('is_archived', false)
                ->orderBy('name')
                ->get()
            : collect();

        return view('pages.storage', [
            'folder' => null,
            'currentFolderId' => null,
            'topbarTitle' => __('stoman.storage.title'),
            'breadcrumbs' => [],
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    public function folder(string $folder): View
    {
        $user = $this->getUser();
        $userId = $user?->id;

        $folderModel = null;
        if (is_numeric($folder)) {
            $folderModel = Folder::with(['children', 'files', 'parent'])->find($folder);
        }

        if (! $folderModel && $userId) {
            $folderModel = Folder::where('user_id', $userId)->where('name', $folder)->first();
        }

        if (! $folderModel) {
            return $this->index();
        }

        $breadcrumbs = [
            ['label' => __('stoman.storage.breadcrumb_home'), 'url' => route('storage.index')],
        ];

        // Ancestors
        $ancestors = collect();
        $curr = $folderModel->parent;
        while ($curr) {
            $ancestors->prepend($curr);
            $curr = $curr->parent;
        }

        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = [
                'label' => $ancestor->name,
                'url' => route('storage.folder', ['folder' => $ancestor->id]),
            ];
        }

        $breadcrumbs[] = [
            'label' => $folderModel->name,
            'url' => null,
        ];

        $folders = $folderModel->children()->where('is_archived', false)->get();
        $files = $folderModel->files()->where('is_archived', false)->get();

        return view('pages.storage', [
            'folder' => $folderModel->name,
            'currentFolderId' => $folderModel->id,
            'topbarTitle' => $folderModel->name,
            'breadcrumbs' => $breadcrumbs,
            'folders' => $folders,
            'files' => $files,
        ]);
    }
}
