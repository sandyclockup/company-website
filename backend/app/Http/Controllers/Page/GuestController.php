<?php

namespace App\Http\Controllers\Page;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\CMS\Slider;
use App\Models\CMS\Feature;
use App\Models\CMS\Customer;
use App\Models\CMS\NewsLatter;
use App\Models\CMS\Contact;
use App\Models\CMS\Team;
use App\Models\CMS\Skill;
use App\Models\CMS\Testimonial;
use App\Models\CMS\Portfolio;
use App\Models\CMS\PortfolioImage;
use App\Models\CMS\Pricing;
use App\Models\CMS\Faq;
use App\Models\CMS\Service;
use App\Models\CMS\Category;

class GuestController extends BaseController
{
    public function GetSlider()
    {
        $data = Slider::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetContent()
    {
        $response = array();
        $data = Setting::All();
        foreach($data as $index => $row){
            $response[$row->key_name] = $row->key_value;
        }
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $response
        ], 200);
    }

    public function GetFeature()
    {
        $data = Feature::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetService()
    {
        $data = Service::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetCustomer()
    {
        $data = Customer::where("is_published", 1)->orderBy("id", "desc")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function CreateNewsLetter(Request $request)
    {
        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'email' can not be empty!",
                "data"=> null
            ], 400);
        }

        $model = new NewsLatter;
        $model->ip_address = $request->ip();
        $model->email = $request->get("email");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been created",
            "data"=> $model
        ], 200);

    }

    public function CreateContact(Request $request)
    {
        if(!$request->get("name")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'email' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("subject")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'subject' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("message")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'message' can not be empty!",
                "data"=> null
            ], 400);
        }

        $model = new Contact;
        $model->name = $request->get("name");
        $model->email = $request->get("email");
        $model->subject = $request->get("subject");
        $model->message = $request->get("message");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Your contact has been sent!",
            "data"=> $model
        ], 200);

    }

    public function GetTeam()
    {
        $data = Team::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetSkill()
    {
        $data = Skill::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetTestimonial()
    {
        $data = Testimonial::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetPortfolio()
    {
       
        $rows = Portfolio::where("cms_portfolios.is_published", 1)
            ->select(["cms_portfolios.*", "cms_categories.name as category_name"])
            ->join("cms_categories", "cms_categories.id", "cms_portfolios.category_id")
            ->orderBy("cms_portfolios.sort")
            ->get();

        $categories = array();

        foreach($rows as $row){
            $image = PortfolioImage::where("portfolio_id", $row->id)->where("is_primary", 1)->first();
            if(is_null($image)){
                $row->image = null;
            }else{
                $row->image = $image->image;
            }
            $categories[] = $row->category_id;
        }   

        $category =  Category::whereIn("id", $categories)->get();

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $rows,
            "categories"=> $category
        ], 200);
    }

    public function GetDetailPortfolio($id)
    {
        $select = [
            "cms_portfolios.*",
            "cms_customers.name as customer_name",
            "cms_categories.name as category_name",
        ];
        $portfolio = Portfolio::select($select)
            ->where("cms_portfolios.id", $id)
            ->join("cms_categories", "cms_categories.id", "cms_portfolios.category_id")
            ->join("cms_customers", "cms_customers.id", "cms_portfolios.customer_id")
            ->first();

        if(is_null($portfolio)){
            return response()->json([
                "status"=> true,
                "message"=> "These portfolio with id ".$id." was not found in our record !",
                "data"=> null
            ], 400);
        }

        $images = PortfolioImage::where("portfolio_id", $id)->where("is_primary", 0)->orderBy("id", "desc")->get();

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> [
                "portfolio"=> $portfolio,
                "images"=> $images
            ]
        ], 200);
    }

    public function GetPricing()
    {
        $data = Pricing::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function GetFaq()
    {
        $data = Faq::where("is_published", 1)->orderBy("sort")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

}
