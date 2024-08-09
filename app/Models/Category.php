<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wildside\Userstamps\Userstamps;

class Category extends Model
{
    use HasFactory;
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "slug"
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
