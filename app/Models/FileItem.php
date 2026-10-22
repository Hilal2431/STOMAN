<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileItem extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'user_id',
        'folder_id',
        'name',
        'path',
        'mime_type',
        'size',
        'is_starred',
        'is_archived',
        'is_trashed',
        'trashed_at',
    ];

    protected $casts = [
        'size' => 'integer',
        'is_starred' => 'boolean',
        'is_archived' => 'boolean',
        'is_trashed' => 'boolean',
        'trashed_at' => 'datetime',
    ];

    protected $appends = [
        'owner_label',
        'modified_label',
        'size_label',
        'url',
        'download_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class, 'file_id');
    }

    public function getOwnerLabelAttribute(): string
    {
        return $this->user?->name ?? 'Me';
    }

    public function getModifiedLabelAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : '';
    }

    public function getSizeLabelAttribute(): string
    {
        $bytes = (int) $this->size;
        if ($bytes < 1024) {
            return $bytes.' B';
        }
        if ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1).' KB';
        }
        if ($bytes < 1024 * 1024 * 1024) {
            return round($bytes / (1024 * 1024), 1).' MB';
        }

        return round($bytes / (1024 * 1024 * 1024), 1).' GB';
    }

    public function getUrlAttribute(): string
    {
        return route('api.files.preview', ['file' => $this->id]);
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('api.files.download', ['file' => $this->id]);
    }
}
