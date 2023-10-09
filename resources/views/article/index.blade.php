<x-layout>
    <section>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 gap-3">
                @forelse ($articles as $article)
                <x-card :item="$article"/>
                @empty
                <span class="text-center">Nessun Articolo</span>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>