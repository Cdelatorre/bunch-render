<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;               // ← añadido

class Category extends Model
{
    use HasFactory;

    /* -----------------------------------------------------------------
     | Mass-assignment
     |------------------------------------------------------------------
     */
    // ↓↓↓ AÑADIDO: habilita asignación en bloque de los campos clave
    protected $fillable = [
        'name',
        'slug',      // ← NUEVO
        'icon',
        'banner',
        'status',
        'parent_id',
    ];
    /* --------------------------------------------------------------- */

    /* -----------------------------------------------------------------
     | Slug handling
     |------------------------------------------------------------------
     */
    // ↓↓↓ NUEVO: genera un slug único ( y lo actualiza si cambia el nombre )
    protected static function booted(): void
    {
        static::creating(function ($category) {
            $category->slug = self::generateUniqueSlug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = self::generateUniqueSlug($category->name, $category->id);
            }
        });
    }

    /** @return string */
    protected static function generateUniqueSlug(string $name, $ignoreId = null): string
    {
        $slug     = Str::slug($name);
        $original = $slug;
        $i        = 1;

        while (static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }
    /* --------------------------------------------------------------- */

    /* -----------------------------------------------------------------
     | Relationships
     |------------------------------------------------------------------
     */
    public function products()
    {
        // ajuste menor: FK declarado en el orden correcto
        return $this->hasMany(CategoryProduct::class, 'category_id', 'id');
    }

    /* -----------------------------------------------------------------
     | Accessors / Badges
     |------------------------------------------------------------------
     */
    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    public function badgeData(): string
    {
        return match ((int) $this->status) {
            0       => '<span class="badge badge--danger">'.trans('Inactive').'</span>',
            default => '<span class="badge badge--success">'.trans('Active').'</span>',
        };
    }
}
