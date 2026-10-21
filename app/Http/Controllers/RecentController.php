<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\User;
use Illuminate\Contracts\View\View;

class RecentController extends Controller
{
    protected function getUser(): ?User
    {
        return auth('web')->user() ?? auth('api')->user() ?? User::first();
    }

    public function index(): View
    {
        $user = $this->getUser();
        $userId = $user?->id;

        $items = $userId
            ? FileItem::where('user_id', $userId)
                ->where('is_trashed', false)
                ->latest('updated_at')
                ->limit(30)
                ->get()
            : collect();

        return view('pages.list', [
            'page' => 'recent',
            'title' => __('stoman.pages.recent_title'),
            'emptyTitle' => __('stoman.pages.recent_empty'),
            'emptyHint' => null,
            'emptyAction' => 'upload',
            'topbarTitle' => __('stoman.pages.recent_title'),
            'breadcrumbs' => [],
            'items' => $items,
            'showEmptyTrash' => false,
        ]);
    }
}
