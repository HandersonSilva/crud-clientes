<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('id','desc')->paginate(8);

        return view('index')->with(compact('clientes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastrar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['nome'])){
            $request->session()->flash('error',"Por favor preenchar o campo nome");
            $cliente = $data;
            return view('cadastrar')->with(compact('cliente'));
        }

        if (!empty($data['id'])){
            Cliente::find($data['id']);
        }else{
            Cliente::create($data);
        }

        return redirect('cliente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);

        return view('cadastrar')->with(compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $cliente = Cliente::find($id);
        $cliente->nome = $data['nome'];
        $cliente->sobre_nome = $data['sobre_nome'];
        $cliente->endereco = $data['endereco'];
        $cliente->bairro = $data['bairro'];
        $cliente->cidade = $data['cidade'];
        $cliente->uf = $data['uf'];
        $cliente->cep = $data['cep'];
        $cliente->save();

        return redirect('cliente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return true;
    }

    public function pesquisarCliente(Request $request)
    {
        $data = $request->all();
        $request->session()->flash('texto_busca',$data['texto_busca'] );

        $clientes = Cliente::where('nome', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('sobre_nome', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('endereco', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('bairro', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('cidade', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('uf', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('cep', 'like','%'.$data['texto_busca'].'%')
                    ->orwhere('id', '=',$data['texto_busca'])
                    ->orderBy('id','desc')
                    ->paginate(8);


        return view('index')->with(compact('clientes'));
    }

    public function getListaCliente()
    {
        $clientes = Cliente::all();

        return $clientes;
    }
}
