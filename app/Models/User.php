<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $cache_name = "Users_model_columns";

        // Check if the column listing is cached
        if (!Cache::has($cache_name)) {
            // If not cached, retrieve the column listing and cache it
            $columns = array_diff(Schema::getColumnListing($this->getTable()),['id','created_at','updated_at']);
            Cache::forever($cache_name, $columns); // Cache the column listing indefinitely
        } else {
            // If cached, retrieve the column listing from the cache
            $columns = Cache::get($cache_name);
        }

        $this->fillable = $columns;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role() {
        return $this->belongsTo(Role::class,'role_id');
    }
}
