@extends('template.template') @section('conteudo')

<div class="container-md conteudo">
    <div class="row div-botoes">
        <div class="col-md-2 mb-4">
            <a href="{{ url('cliente/create') }}" class="btn btn-success">
                Novo Cliente
            </a>
        </div>
        <div class="col-md-10">
            <form action="/pesquisar" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-row">
                    <div class="col-10">
                        <div class="form-group mb-2">
                            <input
                                type="text"
                                class="form-control"
                                name="texto_busca"
                                placeholder="Pesquisar..."
                                value="{{Session::get('texto_busca') ?? ''}}"
                            />
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary mb-2">
                            Pesquisar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <table class="table table-hover">
                    @if ( sizeof($clientes) > 0)
                    <caption>
                        Total de clientes: {{$clientes->total()}}
                    </caption>
                    @endif
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Bairro</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">UF</th>
                            <th scope="col">CEP</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <th scope="row">{{ $cliente->id }}</th>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->endereco }}</td>
                            <td>{{ $cliente->bairro }}</td>
                            <td>{{ $cliente->cidade }}</td>
                            <td>{{ $cliente->uf}}</td>
                            <td>{{ $cliente->cep}}</td>
                            <td>
                                <a

                                    class="btn btn-info"
                                    href="{{url("cliente/$cliente->id/edit")}}"
                                    >Editar</a
                                >
                                <button type="button"  id="{{url("cliente/$cliente->id")}}"
                                    onclick="deleteCliente(this.id)"  class="btn btn-danger">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ( sizeof($clientes) <= 0)
                <h3 style="text-align: center;">Nenhum cliente cadastrado</h3>
            @endif
        </div>
        {{ $clientes->links() }}
    </div>
</div>
@endsection
