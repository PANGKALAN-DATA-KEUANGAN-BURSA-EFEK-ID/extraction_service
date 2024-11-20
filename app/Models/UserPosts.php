<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPosts extends Model
{
    use HasFactory;

    // CONFIG
    protected  $primaryKey = 'UserPostID';
    
    // Explicitly define the table name
    protected $table = 'UserPosts';

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
        'UserPostID',
        'UserID',
        'PostText',
        'PostType',
        'Status',
        'CreateDate',
        'CreateWho',
        'ChangeDate',
        'ChangeWho'
    ];
}
