<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="{{route('homepage')}}">BlogTech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                {{-- link che si attivano dinamicamente in base alla rotta corrente --}}
                <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() == 'homepage') active @endif" aria-current="page" href="{{route('homepage')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() == 'article.index') active @endif" href="{{route('article.index')}}">Articoli</a></li>
                <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() == 'article.create') active @endif" href="{{route('article.create')}}">Crea Articolo</a></li>
                @auth    
                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() == 'login') active @endif" href="{{route('login')}}">Accedi</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() == 'register') active @endif" href="{{route('register')}}">Registrati</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>