<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 't_clients';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_type_person', 'r_nom', 'r_prenoms', 'r_phone', 'r_email', 'r_description','r_partenaire','r_utilisateur'];
}
