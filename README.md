Creare un nuovo progetto

installare Laravel Fortify

login

register

logout

proteggere una rotta qualsiasi con il middleware auth



lancio composer require laravel/fortify

lancio php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"

php artisan migrate per migrare le tabelle create da fortify

vado su  fortify.php e alla voce features commento tutto tranne registration

    'features' => [
        Features::registration(),
        // Features::resetPasswords(),
        // // Features::emailVerification(),
        // Features::updateProfileInformation(),
        // Features::updatePasswords(),
        // Features::twoFactorAuthentication([
        //     'confirm' => true,
        //     'confirmPassword' => true,
        //     // 'window' => 0,
        // ]),
    ],

vado su config / app.php e alla voce providers incollo 
App\Providers\FortifyServiceProvider::class,

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */
        App\Providers\FortifyServiceProvider::class,  //qua
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

devo entrare nel fortifyserviceprovider e aaggiungere i due metodi statici per le rotte login e register, li aggiungo all'interno del della funzione boot()

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {        //in questo punto
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

ora dobbiamo andare a creare la cartella auth in views e al suo interno la vista register

nella vista register fortify si aspetta un form con al suo interno il method POST, la action {{route('register')}} e 4 campi:
- name
- email
- password
- password_confirmation
    <x-layout>
        <form action="{{route('register')}}" method="POST">
            @csrf
            @method('POST')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="text" name="name">
            <input type="email" name="email">
            <input type="password" name="password">
            <input type="password" name="password_confirmation">
            <button type="submit">Registrati</button>
        </form>
    </x-layout>

nella vista login invece si aspetta i campi:
- email
- password
<x-layout>
    <form action="{{route('login')}}" method="POST">
        @csrf
        @method('POST')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="email" name="email">
        <input type="password" name="password">
        <button type="submit">Registrati</button>
    </form>
</x-layout>

vado nel route service provider e do alla const HOME il valore '/'
    public const HOME = '/'; //in questo modo rendo la mia homepage il redirect predefinito di fortify


ora dovró creare un form senza campi che al submit fará partire la rotta logout giá creata da fortify(lo creo nella navbar)
    <li class="nav-item">
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </button>
        </form>
    </li>

racchiudo tutto nel @auth in modo da far vedere questo pulsante solo ad utenti loggati(autorizzati)
    @auth    
        <li class="nav-item">
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </button>
            </form>
        </li>
    @endauth

aggiungo i link per la register e la login da far vedere nel caso l'utente non fosse ancora loggato
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

Per impedire a utenti non autenticati di creare articoli posso implementare un middleware

per farlo mi basta utilizzare un middleware giá definito da laravel ovvero auth e lo posso inserire direttamente nella rotta nel web.php
    Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create')->middleware('auth');
