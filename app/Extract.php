<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extract extends Model
{
    use SoftDeletes;

    /**
     * Instancing table of database
     *
     * @var string
     */
    protected $table = 'extracts';

    /**
     * The primary key of table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'account_id',
        'transaction_id',
        'recipient_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 
    ];

    /**
     * Instancing dates of the table
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * People relationship
     */
    public function recipient()
    {
        return $this->belongsTo('App\Person', 'id', 'recipient_id');
    }
}
