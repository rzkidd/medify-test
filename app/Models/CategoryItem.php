<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    public function masterItems()
    {
        return $this->belongsToMany(
            MasterItem::class,
            'category_item_master_item',
            'category_item_id',
            'master_item_id'
        );
    }
}
