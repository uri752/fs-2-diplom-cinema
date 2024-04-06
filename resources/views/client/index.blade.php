<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">  
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>

  <!-- данные с сервера -->
  <input class="data-halls" type="hidden" value="{{ json_encode($halls) }}"/>
  <input class="data-movies" type="hidden" value="{{ json_encode($movies) }}"/>
  <input class="data-seances" type="hidden" value="{{ json_encode($seances) }}"/>
  
  <nav class="page-nav">

  </nav>
  
  <main>
    @foreach ($movies as $movie)
      <section class="movie">
        <div class="movie__info">
          <div class="movie__poster">
            <img class="movie__poster-image" alt="Звёздные войны постер" src="i/poster1.jpg">
          </div>
          <div class="movie__description">
            <h2 class="movie__title">{{ $movie->title }}</h2>
            <p class="movie__synopsis">{{ $movie->description }}</p>
            <p class="movie__data">
              <span class="movie__data-duration">{{ $movie->duration }}</span>
              <span class="movie__data-origin">{{ $movie->country }}</span>
            </p>
          </div>
        </div>

        @foreach ($halls as $hall)
          <div class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">{{ $hall->name }}</h3>
            <ul class="movie-seances__list">
            @foreach ($movie->sessions as $seance)
              @if ($seance->hall_id == $hall->id)
                <li class="movie-seances__time-block"><a class="movie-seances__time" href="{{ route('client-hall', $hall->id) }}">{{ $seance->start}}</a></li>
              @endif
            @endforeach  
            </ul>
          </div>
        @endforeach
      </section>
    @endforeach
  </main>

  <script type="module" src="/js/client/client.js"></script>
  <script type="module" src="/js/client/calendar.js"></script>
  <script type="module" src="/js/client/sortSeances.js"></script>
</body>
</html>