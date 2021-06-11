<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'tbluser';
    protected $fillable = [
        'username', 'password', 'gender', 'userid','jobid'
    ];

    public $timestamp = false;
    protected $primaryKey = 'userid';
}

?>