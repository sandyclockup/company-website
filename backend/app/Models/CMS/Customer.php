<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMS\Portfolio;
use App\Models\CMS\Testimonial;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = "cms_customers";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'image', 
        'name', 
        'email',
        'phone',
        'address',
        'is_published'
    ];

    public function Portfolio() {
        return $this->hasMany(Portfolio::class);
    }

    public function Testimonial() {
        return $this->hasMany(Testimonial::class);
    }

}