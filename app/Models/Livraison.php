<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;
    protected $table = 't_livraison';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_i','r_vente','r_ville','r_quartier','r_frais','r_status','r_situa_geo'];
}
