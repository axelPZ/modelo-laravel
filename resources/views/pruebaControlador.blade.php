

<h1>{{ $nombre }}</h1>

<table class="table table-success table-striped">

    <head>
        <tr>
            <td> Nombre </td>
            <td> Apellido </td>
            <td> edad </td>
            <td> Estado </td>
            <td></td>
            <td></td>
        </tr>
    </head>
    <tbody>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user['nombre'] }}</td>
            <td>{{ $user['apellido'] }}</td>
            <td>{{ $user['edad'] }}</td>
            <td>{{ $user['estado'] }}</td>
            <td><a class="btn btn-outline-warning" href="#" role="button">Editar</a></td>
            <td><a class="btn btn-outline-info" href="#" role="button">Informacion</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
