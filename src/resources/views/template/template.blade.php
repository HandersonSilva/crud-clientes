<!DOCTYPE html>
<html lang="en" style="background: #f7f8f9;">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Cadastro de Clientes</title>
        <link
            rel="stylesheet"
            href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}"
        />
        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    </head>

    <body style="background: #f7f8f9;">
        <div class="container-md conteudo-titulo">
            <h2>Cadastro de Clientes</h2>
            <h3>
                <!-- show ip do servidor -->
                <span class="badge badge-secondary">
                    HOST SVC: {{ getenv('SVC_CRUD_CLIENTES_SERVICE_HOST')}}
            </h3>
        </div>

        @yield('conteudo')
    </body>

    <script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"
    ></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/crud.js') }}"></script>
</html>
