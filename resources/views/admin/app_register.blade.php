<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ИдёмВКино</title>
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">    

    <!-- Styles -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
<header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Административный режим</span>
</header>

<main class="conf-steps">
    
    <section class="conf-step" id="Halls_Control">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Регистрация нового администратора</h2>
        </header>
        <div class="conf-step__wrapper">
                        
            <div class="popup__wrapper">
                <form action="{{route('user.register')}}" method="post" accept-charset="utf-8">
                    @csrf
                    
                    <label class="conf-step__label conf-step__label-fullsize" for="email">
                        Ваше имя
                        <input class="conf-step__input" type="text" id="email" placeholder="введите имя" name="name" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="email">
                        Ваш логин (эл.почта)
                        <input class="conf-step__input" type="text" id="email" placeholder="введите электронную почту" name="email" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="password">
                        Ваш пароль
                        <input class="conf-step__input" type="text" id="password" placeholder="введите пароль" name="password" required>
                    </label>

                    <div class="conf-step__buttons text-center">
                        <button type="submit" name="sendMe" value="1" class="conf-step__button conf-step__button-accent">Регистрация</button>
                                 
                    </div>
                </form>            
            </div>            
        </div>
        
                     
    </section>   
</main>

</body>
</html>
