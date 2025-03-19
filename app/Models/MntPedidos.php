<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MntPedidos extends Model
{
    //
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'mnt_pedidos';
    protected $fillable = [
        'fecha_pedido',
        'estado',
        'total',
        'client_id'
        ];
    public function cliente(){
        return $this->belongsTo(MntCliente::class,'client_id','id');
    }
    public function detallePedido(){
        return $this->hasMany(MntDetallePedidos::class,'pedido_id','id');
    }
}
