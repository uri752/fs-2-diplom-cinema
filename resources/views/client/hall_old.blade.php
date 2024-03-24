<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  <!-- данные с сервера -->
  <input class="data-seance" type="hidden" value="{{ json_encode($seance) }}"/>
  <input class="data-seats" type="hidden" value="{{ json_encode($seats) }}"/>  
  <input class="data-hall" type="hidden" value="{{ json_encode($hall) }}"/>
  <input class="data-movie" type="hidden" value="{{ json_encode($movie) }}"/>  
  
  @php
    if (empty($movie)) { 
        $movie_name = '';
        $movie_start = '';
    } else {
        $movie_name = $movie->title;
        $movie_start = $movie->start;
    }
    
    if (empty($hall)) {
        $hall_name = '';
        $usual_cost = 0;
        $vip_cost = 0;
        $rows = 0;
        $cols = 0;
    } else {
        $hall_name = $hall->name;
        $usual_cost = $hall->price;
        $vip_cost = $hall->price_vip;
        $rows = $hall->rows;
        $cols = $hall->cols;
    }
    $counter = 0;
  @endphp 

  <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">
          <h2 class="buying__info-title">{{ $movie_name }}</h2>
          <p class="buying__info-start">Начало сеанса: {{ $movie_start }}</p>
          <p class="buying__info-hall">{{ $hall_name }}</p>          
        </div>
        <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div>
      </div>

      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">
        @for ($r = 1; $r < $rows + 1; $r++)
            <div class="buying-scheme__row">
                @for ($s = 1; $s < $cols + 1; $s++)
                    @php
                        //$render_seats = DB::table($tickets_table)->where('row', $r)->where('number', $s)->get();
                        //$type = $render_seats[0]->type;                                    
                        //$sold = $render_seats[0]->isSold;                                   

                        $type = 0;                                    
                        $isSold = 0;                                   
                    @endphp
                                            
                    @if (($type === 'st') && ($isSold === 0))
                        <span class="buying-scheme__chair buying-scheme__chair_standart" data-row="{{ $r }}" data-seat="{{ $s }}" data-seatnumber="{{ $counter }}" data-type=1 data-selected='' style="padding: 10px; cursor: pointer"></span>
                    @endif
                    @if (($type === 'vip') && ($isSold === 0))
                        <span class="buying-scheme__chair buying-scheme__chair_vip" data-row="{{ $r }}" data-seat="{{ $s }}" data-seatnumber="{{ $counter }}" data-type=2 data-selected='' style="padding: 10px; cursor: pointer"></span>
                    @endif
                    @if ($isSold === 1)
                        <span class="buying-scheme__chair buying-scheme__chair_taken" data-row="{{ $r }}" data-seat="{{ $s }}" data-seatnumber="{{ $counter }}" data-type=4 style="padding: 10px; cursor: pointer"></span>
                    @endif                    
                    @php
                        $counter++;
                    @endphp                                        
                @endfor
            </div>                        
            @endfor
        </div>

        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value st_chair">{{ $usual_cost }}</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value vip_chair">{{ $vip_cost }}</span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      
      <!-- <button class="acceptin-button" onclick="location.href='payment.html'" >Забронировать</button> -->
      <button class="acceptin-button">Забронировать</button>

    </section>     
  </main>

  <script type="module" src="/js/client/hall.js"></script>
  
</body>
</html>