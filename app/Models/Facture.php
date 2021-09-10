<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $table = 't_factures';
    protected $primaryKey = 'r_i';
    protected $fillable = ['r_num', 'r_client', 'r_mnt'];
}
