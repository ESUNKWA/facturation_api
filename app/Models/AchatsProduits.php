<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatsProduits extends Model
{
    use HasFactory;
    protected $table = 't_achat_produits';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_i','r_partenaire','r_produit','r_utilisateur','r_quantite','r_mnt'];
}
