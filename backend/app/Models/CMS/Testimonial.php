<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMS\Customer;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = "cms_testimonials";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'customer_id', 
        'image', 
        'name',
        'position',
        'quote', 
        'is_published', 
        'sort'
    ];

    public function Customer(){
        return $this->belongsTo(Customer::class, "customer_id");
    }

}