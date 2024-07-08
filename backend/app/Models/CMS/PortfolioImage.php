<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Portfolio;

class PortfolioImage extends Model
{
    protected $table = "cms_portfolios_images";

    protected $fillable = [
        'portfolio_id', 
        'image', 
        'is_primary'
    ];

    public function Portfolio(){
        return $this->belongsTo(Portfolio::class, "portfolio_id");
    }

}