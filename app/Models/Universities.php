<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Universities extends Model
{
    protected $connection = 'advisor_db';
    protected $table = 'universities';
}
