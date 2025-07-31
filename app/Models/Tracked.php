<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracked extends Model
{
    public $timestamps = false;
    protected $table = 'tracked';

    protected $fillable = ['domain', 'expiry', 'email', 'notifyDays', 'user_id'];
}
