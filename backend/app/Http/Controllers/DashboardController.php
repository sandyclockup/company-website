<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\CMS\Contact;
use App\Models\CMS\Customer;
use App\Models\CMS\Portfolio;
use App\Models\Auth\User;
use App\Models\CMS\Article;
use App\Models\CMS\ArticleReference;
use App\Models\CMS\Testimonial;
use App\Models\CMS\Visitor;
use App\Models\CMS\ArticleCounter;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function GetByTotal()
    {
        $data = array();
        $data["total_contact"] = Contact::whereNotNull("id")->count();
        $data["total_customer"] = Customer::whereNotNull("id")->count();
        $data["total_portfolio"] = Portfolio::whereNotNull("id")->count();
        $data["total_user"] = User::whereNotNull("id")->count();
        $data["total_article"] = Article::whereNotNull("id")->count();
        $data["total_testimonial"] = Testimonial::whereNotNull("id")->count();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function VisitorByYear()
    {
        $title = "Visitor By Year ".date("Y");
        $year = date("Y");
        $months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DEC"];

        $backgroundColor = array();
        $data = array();

        for($i = 0; $i < count($months); $i++){
            $month = $i + 1;
            $backgroundColor[] = $this->generateColors();
            $data[] = (int) Visitor::whereRaw("YEAR(created_at) = ".$year." AND MONTH(created_at) = ".$month)->count();
        }

        $result = array();
        $result["title"] = $title;
        $result["labels"] = $months;
        $result["datasets"] = [
            [
                "label"=> "Visitor",
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ],
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);

    }

    public function ArticleReader()
    {
        $title = "Reader By Year ".date("Y");
        $year = date("Y");
        $months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DEC"];

        $backgroundColor = array();
        $data = array();

        for($i = 0; $i < count($months); $i++){
            $month = $i + 1;
            $backgroundColor[] = $this->generateColors();
            $data[] = (int) ArticleCounter::whereRaw("YEAR(created_at) = ".$year." AND MONTH(created_at) = ".$month)->count();
        }

        $result = array();
        $result["title"] = $title;
        $result["labels"] = $months;
        $result["datasets"] = [
            [
                "label"=> "Reader",
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ],
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }


    public function PortfolioByCustomer()
    {
        $title = "Portfolio By Customer";
        $total_all = Portfolio::where("is_published", 1)->count();
        $result = array();
        $queries = Portfolio::PortfolioByCustomer();
        $labels = array();
        $backgroundColor = array();
        $data = array();
        foreach($queries as $row){
            $labels[] = $row->name;
            $backgroundColor[] = $this->generateColors();
            $total_index =  (float) ($row->total / $total_all) * 100;
            $data[] = number_format($total_index, 2);
        }
        $result["title"] = $title;
        $result["labels"] = $labels;
        $result["datasets"] = [
            [
                "label"=> $title,
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ]
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }

    public function PortfolioByCategory()
    {
        $title = "Portfolio By Category";
        $total_all = Portfolio::where("is_published", 1)->count();
        $result = array();
        $queries = Portfolio::PortfolioByCategory();
        $labels = array();
        $backgroundColor = array();
        $data = array();
        foreach($queries as $row){
            $labels[] = $row->name;
            $backgroundColor[] = $this->generateColors();
            $total_index =  (float) ($row->total / $total_all) * 100;
            $data[] = number_format($total_index, 2);
        }
        $result["title"] = $title;
        $result["labels"] = $labels;
        $result["datasets"] = [
            [
                "label"=> $title,
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ]
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }

    public function ArticleByTag()
    {
        $title = "Article By Tag";
        $total_all = ArticleReference::where("cms_articles_references.type", 2)
            ->where("cms_articles.is_published", 1)
            ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
            ->join("cms_articles", "cms_articles.id", "cms_articles_references.article_id")
            ->count();

        $result = array();
        $queries = Article::getArticleByTag();
        $labels = array();
        $backgroundColor = array();
        $data = array();
        foreach($queries as $row){
            $labels[] = $row->name;
            $backgroundColor[] = $this->generateColors();
            $total_index =  (float) ($row->total / $total_all) * 100;
            $data[] = number_format($total_index, 2);
        }
        $result["title"] = $title;
        $result["labels"] = $labels;
        $result["datasets"] = [
            [
                "label"=> $title,
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ]
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }

    public function ArticleByCategory()
    {

        $title = "Article By Category";
        $total_all = ArticleReference::where("cms_articles_references.type", 1)
            ->where("cms_articles.is_published", 1)
            ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
            ->join("cms_articles", "cms_articles.id", "cms_articles_references.article_id")
            ->count();

        $result = array();
        $queries = Article::getArticleByCategory();
        $labels = array();
        $backgroundColor = array();
        $data = array();
        foreach($queries as $row){
            $labels[] = $row->name;
            $backgroundColor[] = $this->generateColors();
            $total_index =  (float) ($row->total / $total_all) * 100;
            $data[] = number_format($total_index, 2);
        }
        $result["title"] = $title;
        $result["labels"] = $labels;
        $result["datasets"] = [
            [
                "label"=> $title,
                "backgroundColor"=> $backgroundColor,
                "data"=> $data
            ]
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }



    private function generateColors()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

}
