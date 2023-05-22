<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $db_hostname
 * @property $db_database
 * @property $db_username
 * @property $db_password
 * @property $name
 * @property $id
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'db_hostname',
        'db_database',
        'db_username',
        'db_password',
    ];
}
