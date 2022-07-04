<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\CategoryProject;

class Project extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'projects';

    protected $fillable = [
        "category_id",
        "name",
        "images",
        "description",
        "is_published"
    ];

    public function Category(){
        return $this->belongsTo(CategoryProject::class, "category_id");
    }

}
