@extends('template.template') @section('conteudo')
<div class="container-md conteudo">
    <h3 class="modal-title">
        @if(isset($cliente)) Editar @else Cadastrar @endif
    </h3>
    @if(Session::get('error')) 
    <div class="alert alert-danger" role="alert">
      {{Session::get('error')}}
    </div>
    @endif 
    
    @if(isset($cliente) && !empty($cliente->id)) <form action="{{
        url("cliente/$cliente->id")
    }}" method="POST"> @method('PUT') @else
    <form action="/cliente" method="POST">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="id" id="id_cliente" value="" />
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome</label>
                    <input
                        autofocus
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="{{$cliente->nome ?? ''}}"
                    />
                </div>
                <div class="form-group col-md-6">
                    <label for="sobre_nome">Sobre nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="sobre_nome"
                        name="sobre_nome"
                        value="{{$cliente->sobre_nome ?? ''}}"
                    />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="endereco">Endereço</label>
                    <input
                        type="text"
                        class="form-control"
                        id="endereco"
                        name="endereco"
                        placeholder=""
                        value="{{$cliente->endereco ?? ''}}"
                    />
                </div>
                <div class="form-group col-md-4">
                    <label for="bairro">Bairro</label>
                    <input
                        type="text"
                        class="form-control"
                        id="bairro"
                        name="bairro"
                        value="{{$cliente->bairro ?? ''}}"
                    />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cidade">Cidade</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cidade"
                        name="cidade"
                        value="{{$cliente->cidade ?? ''}}"
                    />
                </div>
                <div class="form-group col-md-2">
                    <label for="uf">UF</label>
                    <input
                        type="text"
                        maxlength="2"
                        class="form-control"
                        id="uf"
                        name="uf"
                        value="{{$cliente->uf ?? ''}}"
                    />
                </div>
                <div class="form-group col-md-4">
                    <label for="cep">CEP</label>
                    <input
                        maxlength="10"
                        type="text"
                        class="form-control"
                        id="cep"
                        name="cep"
                        value="{{$cliente->cep ?? ''}}"
                    />
                </div>
            </div>
        </div>
        <a href="{{ url('cliente') }}" class="btn btn-danger">
            Cancelar
        </a>
        <button type="submit" class="btn btn-success">
            Salvar
        </button>
    </form>
</div>
@endsection
