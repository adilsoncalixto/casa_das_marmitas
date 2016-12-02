<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\PedidoItem;

class Produto extends Model
{
	protected $table = 'produtos';

    protected $fillable = [
    	'user_id',
    	'nome',
    	'ingredientes',
    	'custo',
    	'tamanho'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itensPedido()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
