<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Project;

class CategoryProject extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'category_projects';

    protected $fillable = [
        "name",
        "description"
    ];

    public function Project() {
        return $this->hasMany(Project::class);
    }

}
