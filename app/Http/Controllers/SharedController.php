<?php

namespace App\Http\Controllers;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\Share;
use App\Models\User;
use Illuminate\Contracts\View\View;

class SharedController extends Controller
{
    protected function getUser(): ?User
    {
        return auth('web')->user() ?? auth('api')->user() ?? User::first();
    }

    public function index(): View
    {
        $user = $this->getUser();
        $email = $user?->email;

        $items = collect();
        if ($email) {
            $sharedFolderIds = Share::where('shared_with_email', $email)->whereNotNull('folder_id')->pluck('folder_id');
            $sharedFileIds = Share::where('shared_with_email', $email)->whereNotNull('file_id')->pluck('file_id');

            $folders = Folder::whereIn('id', $sharedFolderIds)->where('is_trashed', false)->get();
            $files = FileItem::whereIn('id', $sharedFileIds)->where('is_trashed', false)->get();
            $items = $folders->concat($files);
        }

        return view('pages.list', [
            'page' => 'shared',
            'title' => __('stoman.pages.shared_title'),
            'emptyTitle' => __('stoman.pages.shared_empty'),
            'emptyHint' => __('stoman.pages.shared_hint'),
            'emptyAction' => null,
            'topbarTitle' => __('stoman.pages.shared_title'),
            'breadcrumbs' => [],
            'items' => $items,
            'showEmptyTrash' => false,
        ]);
    }
}
