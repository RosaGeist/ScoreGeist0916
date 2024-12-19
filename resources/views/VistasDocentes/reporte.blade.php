<html>
    <body>
        <h1>{{ $proyecto->nombre }}</h1>
        <p>{{ $proyecto->descripcion }}</p>

        @foreach ($proyecto->sprints as $sprint)
            <h2>{{ $sprint->nombre }}</h2>
            <p>{{ $sprint->estado }}</p>

            @foreach ($sprint->historias as $historia)
                <h3>{{ $historia->titulo }}</h3>
                <p>{{ $historia->estado }}</p>

                @foreach ($historia->subtareas as $subtarea)
                    <p>{{ $subtarea->titulo }} - {{ $subtarea->estado }}</p>
                @endforeach
            @endforeach
        @endforeach
    </body>
</html>
