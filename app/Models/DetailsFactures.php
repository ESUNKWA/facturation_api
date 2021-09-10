<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsFactures extends Model
{
    use HasFactory;
    protected $table = 't_details_factures';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_facture', 'r_produit', 'r_quantite', 'r_total', 'r_description'];
}
