<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRatios extends Model
{
    use HasFactory;

    // CONFIG
    protected  $primaryKey = 'FinacialRatioID';
    
    // Explicitly define the table name
    protected $table = 'Companies';

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
        'CompanyID',
        'CompanyName',
        'CompanyCode',
        'FinancialRatioName',
        'FinancialRatioValue',
        'Status',
        'CreateDate',
        'CreateWho',
        'ChangeDate',
        'ChangeWho'
    ];

    protected $casts = [
        "FinancialRatioValue" => "array"
    ];
}
