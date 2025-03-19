<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MntCliente extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = "mnt_clientes";
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'email',
        'user_id',
        'direccion_envio',
        'direccion_facturacion',
        'telefono'
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function pedido(){
        return $this->belongsTo(MntPedidos::class,'client_id','id');
    }
}
