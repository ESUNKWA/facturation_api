<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $table = 't_produit';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_categorie', 'r_libelle', 'r_stock', 'r_prix_vente', 'r_description', 'r_status','r_partenaire'];
}
