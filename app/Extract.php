<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extract extends Model
{
    use SoftDeletes, Uuid;

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
        'previous_balance',
        'current_balance',
        'source_account_id',
        'destination_account_id',
        'transaction_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
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
     * Source account relationship
     */
    public function sourceAccount()
    {
        return $this->hasOne('App\Account', 'id', 'source_account_id');
    }

    /**
     * Destination account relationship
     */
    public function destinationAccount()
    {
        return $this->hasOne('App\Account', 'id', 'destination_account_id');
    }

    /**
     * Transaction relationship
     */
    public function transaction()
    {
        return $this->hasOne('App\Transaction', 'id', 'transaction_id');
    }
}
