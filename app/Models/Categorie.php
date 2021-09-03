<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 't_categorie';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_libelle', 'r_description', 'r_status'];
}
