<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementPartiel extends Model
{
    use HasFactory;
    protected $table = 't_reglement_partiele';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_facture','r_montant','r_date_eng','r_date_modif','r_partenaire'];
}
