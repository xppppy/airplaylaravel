<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Database\Eloquent\Model;
class VideoModel extends Authenticatable implements JWTSubject
{
    protected $table = 'video';

    protected $fillable = [
        'title','thum','sum','number','playerUrl','type_id',
    ];
    protected $hidden = [
       'updated_at','created_at'
    ];
    public function type(){
        return $this->belongsTo('App\Models\VideoTypeModel','type_id');
    }
    //
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        // TODO: Implement getJWTCustomClaims() method.
    }
}
