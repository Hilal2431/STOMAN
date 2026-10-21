<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'color',
        'is_starred',
        'is_archived',
        'is_trashed',
        'trashed_at',
    ];

    protected $casts = [
        'is_starred' => 'boolean',
        'is_archived' => 'boolean',
        'is_trashed' => 'boolean',
        'trashed_at' => 'datetime',
    ];

    protected $appends = [
        'meta_label',
        'url',
        'owner_label',
        'modified_label',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id')->where('is_trashed', false);
    }

    public function files(): HasMany
    {
        return $this->hasMany(FileItem::class, 'folder_id')->where('is_trashed', false);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class, 'folder_id');
    }

    public function getMetaLabelAttribute(): string
    {
        $count = $this->children()->count() + $this->files()->count();
        return $count === 1 ? '1 item' : "{$count} items";
    }

    public function getUrlAttribute(): string
    {
        return route('storage.folder', ['folder' => $this->id]);
    }

    public function getOwnerLabelAttribute(): string
    {
        return $this->user?->name ?? 'Me';
    }

    public function getModifiedLabelAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : '';
    }
}
