<?php

namespace App\Models;

use Database\Factories\PortalSectionItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'portal_section_id',
    'title',
    'subtitle',
    'body',
    'image_path',
    'icon',
    'url',
    'badges',
    'tag_label',
    'tag_style',
    'meta_text',
    'accent_color',
    'avatar_text',
    'opens_modal',
    'is_featured',
    'published_at',
    'starts_at',
    'ends_at',
    'is_published',
    'sort_order',
    'created_by',
])]
class PortalSectionItem extends Model
{
    /** @use HasFactory<PortalSectionItemFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'badges' => 'array',
            'opens_modal' => 'boolean',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PortalSection::class, 'portal_section_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @param  Builder<PortalSectionItem>  $query
     * @return Builder<PortalSectionItem>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<PortalSectionItem>  $query
     * @return Builder<PortalSectionItem>
     */
    public function scopeVisibleNow(Builder $query): Builder
    {
        return $query
            ->published()
            ->where(function (Builder $builder): void {
                $builder
                    ->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $builder): void {
                $builder
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * @param  Builder<PortalSectionItem>  $query
     * @return Builder<PortalSectionItem>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        if (blank($this->image_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * @return array{id: int, title: string, subtitle: ?string, body: ?string, image_url: ?string, badges: array<int, mixed>, tag_label: ?string, tag_style: ?string, meta_text: ?string, accent_color: ?string}
     */
    public function toModalPayload(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'body' => $this->body,
            'image_url' => $this->imageUrl(),
            'badges' => $this->badges ?? [],
            'tag_label' => $this->tag_label,
            'tag_style' => $this->tag_style,
            'meta_text' => $this->meta_text,
            'accent_color' => $this->accent_color,
        ];
    }
}
