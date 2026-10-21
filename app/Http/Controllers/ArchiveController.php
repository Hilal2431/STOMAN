<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Contracts\View\View;

class ArchiveController extends Controller
{
    protected function getUser(): ?User
    {
        return auth('web')->user() ?? auth('api')->user() ?? User::first();
    }

    public function index(): View
    {
        $user = $this->getUser();
        $userId = $user?->id;

        $items = collect();
        if ($userId) {
            $folders = Folder::where('user_id', $userId)->where('is_archived', true)->where('is_trashed', false)->get();
            $files = FileItem::where('user_id', $userId)->where('is_archived', true)->where('is_trashed', false)->get();
            $items = $folders->concat($files);
        }

        return view('pages.list', [
            'page' => 'archive',
            'title' => __('stoman.pages.archive_title'),
            'emptyTitle' => __('stoman.pages.archive_empty'),
            'emptyHint' => __('stoman.pages.archive_hint'),
            'emptyAction' => null,
            'topbarTitle' => __('stoman.pages.archive_title'),
            'breadcrumbs' => [],
            'items' => $items,
            'showEmptyTrash' => false,
        ]);
    }
}
