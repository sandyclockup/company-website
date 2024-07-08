<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMS\Customer;
use App\Models\CMS\Category;
use App\Models\CMS\PortfolioImage;
use DB;
class Portfolio extends Model
{
    use SoftDeletes;

    protected $table = "cms_portfolios";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'customer_id', 
        'category_id', 
        'title',
        'description',
        'project_date',
        'project_url',
        'is_published',
        'sort'
    ];

    public function Customer(){
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function Category(){
        return $this->belongsTo(Category::class, "category_id");
    }
    
    public function PortfolioImage() {
        return $this->hasMany(PortfolioImage::class);
    }

    public static function PortfolioByCustomer(){
        return DB::select(DB::raw("
            SELECT 
                cms_customers.name,
                COUNT(*) as total
            FROM cms_portfolios
            INNER JOIN cms_customers ON cms_customers.id = cms_portfolios.customer_id
            WHERE cms_portfolios.is_published = 1 
            GROUP BY cms_customers.name
        "));
    }

    public static function PortfolioByCategory(){
        return DB::select(DB::raw("
            SELECT 
                cms_categories.name,
                COUNT(*) as total
            FROM cms_portfolios
            INNER JOIN cms_categories ON cms_categories.id = cms_portfolios.category_id
            WHERE cms_portfolios.is_published = 1 AND cms_categories.type = 2
            GROUP BY cms_categories.name
        "));
    }

}