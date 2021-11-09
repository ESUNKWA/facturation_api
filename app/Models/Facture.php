<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $table = 't_ventes';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_num', 'r_client', 'r_mnt','r_status','r_iscmd','r_partenaire'];
}
