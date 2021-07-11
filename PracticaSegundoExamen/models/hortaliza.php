<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hortaliza extends Model
{

    use SoftDeletes;

    protected $primaryKey = 'idhortaliza';
    protected $table = 'hortaliza';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    const DELETED_AT = 'fechaBaja';

    protected $fillable = [
        'precio','nombre','foto', 'tipo',
    ];

}


?>