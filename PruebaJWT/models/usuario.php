<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{

    use SoftDeletes;

    protected $primaryKey = 'idusuarios';
    protected $table = 'usuarios';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    const DELETED_AT = 'fechaBaja';

    protected $fillable = [
        'mail', 'pass', 'nombre', 'tipo',
    ];

}


?>