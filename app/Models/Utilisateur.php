<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Utilisateur extends Model implements JWTSubject
{
    use HasFactory;

    protected $table = 't_utilisateurs';
    protected $primaryKey = 'r_i';
    protected $fillable = ["r_nom","r_prenoms","r_email","r_phone","r_description","r_img","r_login","r_mdp","r_profil",'r_partenaire','r_status','r_utilisateur','r_tous_droits'];


    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}
