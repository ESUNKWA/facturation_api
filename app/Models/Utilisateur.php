<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'r_i';
    protected $fillable = ["r_nom","r_prenoms","r_email","r_phone","r_description","r_img","r_login"];
}
