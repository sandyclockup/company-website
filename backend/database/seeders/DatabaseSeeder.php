<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\Notification;
use App\Models\Auth\Person;
use App\Models\Auth\User;
use App\Models\CMS\Contact;
use App\Models\Core\Setting;
use App\Models\CMS\Category;
use App\Models\CMS\Article;
use App\Models\CMS\ArticleReference;

class DatabaseSeeder extends Seeder
{

    const DEFAULT_ADMIN_USERNAME = "admin";
    const DEFAULT_ADMIN_EMAIL = "admin@laravel.com";
    const DEFAULT_ADMIN_PASSWORD = "secret1234567890";

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->warn('Begin instalation, please wait for a minute...');

        $check_admin = User::where("is_admin", 1)->first();
        if(is_null($check_admin)){
            $this->createUser(1);
        }

        for($i = 1; $i <=99; $i++){
            $this->createUser(0);
        }

        $this->createContact();
        $this->createSetting();
        $this->sync_article();

        $this->command->warn('Your application has been instaled :)');

    }

    private function sync_article()
    {
        $articles = Article::All();
        foreach($articles as $article)
        {
            $categories = Category::where("type", 1)->orderBy("name")->inRandomOrder()->take(3)->get();
            $tags = Category::where("type", 3)->orderBy("name")->inRandomOrder()->take(3)->get();

            foreach($categories as $row)
            {
                ArticleReference::create([
                    "article_id"=> $article->id,
                    "category_id"=> $row->id,
                    "type"=> 1
                ]);
            }

            foreach($tags as $row)
            {
                ArticleReference::create([
                    "article_id"=> $article->id,
                    "category_id"=> $row->id,
                    "type"=> 2
                ]);
            }
        }
    }

    private function createArticle()
    {
        $max = 50;
        for($i = 1; $i <= $max; $i++)
        {
            $user = User::where("is_admin", 1)->first();
            $faker = Faker::create();
            $title = $faker->sentence(rand(5,15));
            $article = new Article;
            $article->user_id = $user->id;
            $article->title = $title;
            $article->slug = $this->toSlug($title);
            $article->content = "<p>".$faker->text(500000)."</p>";
            $article->is_published = 1;
            $article->save();

            $categories = Category::where("type", 1)->orderBy("name")->inRandomOrder()->take(3)->get();
            $tags = Category::where("type", 3)->orderBy("name")->inRandomOrder()->take(3)->get();

            foreach($categories as $row)
            {
                ArticleReference::create([
                    "article_id"=> $article->id,
                    "category_id"=> $row->id,
                    "type"=> 1
                ]);
            }

            foreach($tags as $row)
            {
                ArticleReference::create([
                    "article_id"=> $article->id,
                    "category_id"=> $row->id,
                    "type"=> 2
                ]);
            }

        }
    }

    private function createSetting()
    {
        $items = array(
            array(
                "key_name"=> "config_site_title",
                "key_value"=> "Company"
            ),
            array(
                "key_name"=> "config_site_author",
                "key_value"=> "Sandy Andryanto"
            ),
            array(
                "key_name"=> "config_company_name",
                "key_value"=> "Sandy Andryanto"
            ),
            array(
                "key_name"=> "config_company_phone",
                "key_value"=> "+1 5589 55488 55"
            ),
            array(
                "key_name"=> "config_company_skype",
                "key_value"=> "Sandy Andryanto"
            ),
            array(
                "key_name"=> "config_company_email",
                "key_value"=> "info@example.com"
            ),
            array(
                "key_name"=> "config_company_facebook",
                "key_value"=> "https://www.facebook.com/sandy.andryanto27"
            ),
            array(
                "key_name"=> "config_company_twitter",
                "key_value"=> "https://twitter.com/SandyAndryanto"
            ),
            array(
                "key_name"=> "config_company_instagram",
                "key_value"=> "https://www.instagram.com/sandy.andryanto/"
            ),
            array(
                "key_name"=> "config_company_linked_in",
                "key_value"=> "https://www.linkedin.com/in/sand404"
            ),
            array(
                "key_name"=> "config_company_street",
                "key_value"=> "A108 Adam Street "
            ),
            array(
                "key_name"=> "config_company_regency",
                "key_value"=> "New York, NY 535022"
            ),
            array(
                "key_name"=> "config_company_country",
                "key_value"=> "United States"
            ),
            array(
                "key_name"=> "config_company_map",
                "key_value"=> "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
            ),
            array(
                "key_name"=> "config_newsletter_description",
                "key_value"=> "Tamen quem nulla quae legam multos aute sint culpa legam noster magna"
            ),
            array(
                "key_name"=> "config_feature_description",
                "key_value"=> "Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas."
            ),
            array(
                "key_name"=> "config_about_description",
                "key_value"=> "Lorem Ipsum"
            ),
            array(
                "key_name"=> "config_skill_description",
                "key_value"=> "Lorem Ipsum"
            ),
            array(
                "key_name"=> "config_team_description",
                "key_value"=> "Lorem Ipsum"
            ),
            array(
                "key_name"=> "config_meta_tag",
                "key_value"=> '
                    <meta content="" name="description">
                    <meta content="" name="keywords">
                '
            ),
            array(
                "key_name"=> "config_term_of_service",
                "key_value"=> "Lorem Ipsum"
            ),
            array(
                "key_name"=> "config_privacy_policy",
                "key_value"=> "Lorem Ipsum"
            ),
        );

        foreach($items as $row){
            $check = Setting::getConfig($row["key_name"]);
            if(is_null($check)){
                Setting::create($row);
            }
        }

    }

    private function createContact()
    {
        for($i = 1; $i <=50; $i++)
        {
            $faker = Faker::create();
            Contact::create([
                "name"=> $faker->name,
                "email"=> $faker->email,
                "subject"=> $faker->sentence(3),
                'message'=> $faker->paragraph(10, true)
            ]);
        }
    }

    private function createUser($is_admin){

        $faker = Faker::create();

        $username = $is_admin ? self::DEFAULT_ADMIN_USERNAME : $faker->userName;
        $email = $is_admin ? self::DEFAULT_ADMIN_EMAIL : $faker->safeEmail;
        $password = Hash::make(self::DEFAULT_ADMIN_PASSWORD);

        $user = User::create([
            'username'=> $username,
            'email'=> $email,
            'phone'=> $faker->phoneNumber,
            'password'=> $password,
            'is_admin'=> $is_admin,
            'is_banned'=> 0,
            'verified'=> 1,
            'verification_token'=> md5($faker->uuid)
        ]);

        $gender = rand(1,2);
        $nick_name = $gender == 1 ? $faker->firstNameMale : $faker->firstNameFemale;

        Person::create([
            'user_id'=> $user->id,
            'nick_name'=> $nick_name,
            'full_name'=> $nick_name." ".$faker->lastName,
            'gender'=> $gender,
            'birth_date'=> date("Y-m-d"),
            'address'=> $faker->streetAddress,
            'about_me'=> $faker->text
        ]);

        if((int) $is_admin == 1){
            for($i = 1; $i <=10; $i++){
                $faker = Faker::create();
                Notification::create([
                    'user_id'=> $user->id,
                    'subject'=> $faker->sentence(3),
                    'content'=> $faker->paragraph(10, true)
                ]);
            }
        }


    }

    private function toSlug($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
