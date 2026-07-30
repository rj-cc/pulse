<?php

namespace App\Models;

use App\Enums\PortalSectionLayout;
use Database\Factories\PortalSectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'layout',
    'view_all_label',
    'initial_items_count',
    'collapse_label',
    'is_published',
    'sort_order',
    'created_by',
])]
class PortalSection extends Model
{
    /** @use HasFactory<PortalSectionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'layout' => PortalSectionLayout::class,
            'initial_items_count' => 'integer',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function hasExpandableItems(): bool
    {
        return filled($this->view_all_label)
            && $this->initial_items_count !== null
            && $this->items->count() > $this->initial_items_count;
    }

    public function items(): HasMany
    {
        return $this->hasMany(PortalSectionItem::class)->ordered();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @param  Builder<PortalSection>  $query
     * @return Builder<PortalSection>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<PortalSection>  $query
     * @return Builder<PortalSection>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
