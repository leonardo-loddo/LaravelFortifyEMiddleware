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