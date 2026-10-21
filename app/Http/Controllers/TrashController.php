<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Contracts\View\View;

class TrashController extends Controller
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
            $folders = Folder::where('user_id', $userId)->where('is_trashed', true)->get();
            $files = FileItem::where('user_id', $userId)->where('is_trashed', true)->get();
            $items = $folders->concat($files);
        }

        return view('pages.list', [
            'page' => 'trash',
            'title' => __('stoman.pages.trash_title'),
            'emptyTitle' => __('stoman.pages.trash_empty'),
            'emptyHint' => __('stoman.pages.trash_hint'),
            'emptyAction' => null,
            'topbarTitle' => __('stoman.pages.trash_title'),
            'breadcrumbs' => [],
            'items' => $items,
            'showEmptyTrash' => $items->isNotEmpty(),
        ]);
    }
}
