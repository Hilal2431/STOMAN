<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
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
                ->get()
            : collect();

        $starredFolders = $userId
            ? Folder::where('user_id', $userId)
                ->where('is_starred', true)
                ->where('is_trashed', false)
                ->get()
            : collect();

        $collaborativeFolders = $userId
            ? Folder::where('user_id', $userId)
                ->whereHas('shares')
                ->where('is_trashed', false)
                ->get()
            : collect();

        $files = $userId
            ? FileItem::where('user_id', $userId)
                ->where('is_trashed', false)
                ->where('is_archived', false)
                ->latest()
                ->limit(12)
                ->get()
            : collect();

        return view('pages.home', [
            'topbarTitle' => __('stoman.nav.home'),
            'breadcrumbs' => [],
            'folders' => $folders,
            'starredFolders' => $starredFolders,
            'collaborativeFolders' => $collaborativeFolders,
            'files' => $files,
        ]);
    }
}
