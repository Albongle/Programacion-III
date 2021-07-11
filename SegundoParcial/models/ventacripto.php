<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaCripto extends Model
{
    protected $primaryKey = 'idventacripto';
    protected $table = 'ventacripto';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'fechaVenta';
    const UPDATED_AT = 'fechaModificacion';

    protected $fillable = [
        'cantidad','idcliente', 'idcripto'
    ];

}


?>