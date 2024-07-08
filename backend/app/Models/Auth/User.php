<?php

namespace App\Models\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Auth\Person;
use App\Models\Auth\Notification;
use App\Models\CMS\Article;
use App\Models\CMS\ArticleComment;
use App\Models\CMS\ArticleCounter;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    protected $table = "auth_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'phone',
        'email',
        'is_admin',
        'is_banned',
        'verified',
        'verification_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'verification_token'
    ];

    public function Person() {
        return $this->hasOne(Person::class);
    }

    public function Notification() {
        return $this->hasMany(Notification::class);
    }

    public function Article() {
        return $this->hasMany(Article::class);
    }

    public function ArticleComment() {
        return $this->hasMany(ArticleComment::class);
    }

    public function ArticleCounter() {
        return $this->hasMany(ArticleCounter::class);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function getName(){
        $user = $this;
        $person = $user->Person;
        if(!is_null($person->full_name)){
            return $person->full_name;
        }else if(!is_null($person->nick_name)){
            return $person->nick_name;
        }else{
            return $user->username;
        }
    }

    public function getImage(){
        $user = $this;
        $person = $user->Person;
        $gender = (int) $person->gender;
        if(!is_null($person->image)){
            return $person->image;
        }else{
            if($gender == 1){
                return "app/img/male.png";
            }else if($gender == 2){
                return "app/img/female.png";
            }else{
                return "app/img/user.png";
            }
        }
    }


}
