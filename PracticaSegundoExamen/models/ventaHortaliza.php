<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaHortaliza extends Model
{



    protected $primaryKey = 'idventahortaliza';
    protected $table = 'ventahortaliza';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    protected $fillable = [
        'idHortaliza','idEmpleado','cantidad', 'foto',
    ];

}


?>