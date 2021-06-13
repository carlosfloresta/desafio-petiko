<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index(){

        $pedido = Pedido::all();

        return view('pedidos',compact('pedido'));
    }
}
