<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Contracts\View\View;

class StarredController extends Controller
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
            $folders = Folder::where('user_id', $userId)->where('is_starred', true)->where('is_trashed', false)->get();
            $files = FileItem::where('user_id', $userId)->where('is_starred', true)->where('is_trashed', false)->get();
            $items = $folders->concat($files);
        }

        return view('pages.list', [
            'page' => 'starred',
            'title' => __('stoman.pages.starred_title'),
            'emptyTitle' => __('stoman.pages.starred_empty'),
            'emptyHint' => __('stoman.pages.starred_hint'),
            'emptyAction' => null,
            'topbarTitle' => __('stoman.pages.starred_title'),
            'breadcrumbs' => [],
            'items' => $items,
            'showEmptyTrash' => false,
        ]);
    }
}
