<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Role extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $cache_name = "Roles_model_columns";

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
}
