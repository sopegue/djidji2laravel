<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'annonce';

      /**
     * Get the user that owns the ad.
     */

    public function annonceur()
    {
        return $this->belongsTo('App\User');
    }
}
