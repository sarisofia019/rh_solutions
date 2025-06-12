<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id_documentos';
    public $timestamps = false;

    protected $fillable = [
        'nom_documento',
        'ruta_archivo',
        'fecha_vencimiento',
        'tamaño_archivo',
        'descripcion',
        'serial_unico',
        'estado',
        'tipo_mime',
        'id_usuario',
        'id_tip_document'
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tip_document');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
