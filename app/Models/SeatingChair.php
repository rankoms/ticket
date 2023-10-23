<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatingChair extends Model
{
    use HasFactory;

    public function columns()
    {
        return $this->hasMany(SeatingChair::class, 'sort_row', 'sort_row')->orderBy('sort_column');
    }
}
