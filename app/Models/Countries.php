<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $connection = 'advisor_db';
    protected $table = 'country';
}
