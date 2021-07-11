<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cripto extends Model
{

    use SoftDeletes;

    protected $primaryKey = 'idcripto';
    protected $table = 'cripto';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    const DELETED_AT = 'fechaBaja';

    protected $fillable = [
        'precio','nombre','foto', 'nacionalidad'
    ];

}


?>