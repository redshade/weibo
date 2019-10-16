<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($user) {
           $user->activation_token = Str::random(10);
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 获取头像
     * @param string $size
     * @return string
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 获取动态
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses() {
        return $this->hasMany(Status::class);
    }


    /**
     * 动态按创建时间降序
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed() {
        return $this->statuses()->orderBy('created_at', 'desc');
    }


    /**
     * 获取粉丝列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers() {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * 获取关注列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings() {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * 关注
     * @param $user_ids
     */
    public function follow($user_ids) {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注
     * @param $user_ids
     */
    public function unfollow($user_ids) {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id) {
        return $this->followings()->contains($user_id);
    }
}
