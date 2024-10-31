<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollows extends Model
{
    use HasFactory;

    // CONFIG
    
    // Explicitly define the table name
    protected $table = 'UserFollows';

    // Set custom timestamp fields
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'ChangeDate';
    
    // END OF CONFIG

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserID',
        'FollowerID',
        'Status',
        'CreateDate',
        'CreateWho',
        'ChangeDate',
        'ChangeWho'
    ];
}
