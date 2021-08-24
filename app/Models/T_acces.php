<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_acces extends Model
{
    use HasFactory;

    protected $table = 'sc_gestion.t_acces';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_utilisateur', 'r_mdp', 'r_status'];
}
