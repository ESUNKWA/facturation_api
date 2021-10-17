<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaires extends Model
{
    use HasFactory;
    protected $table = 't_partenaire';
    protected $primaryKey = 'r_i';
    protected $filables = ['r_code','r_nom','r_ville','r_quartier','r_situation_geo','r_status'];
}
