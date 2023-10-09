                <div class="card" style="width: 18rem;">
                    <img src="{{Storage::url($item->image)}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->title}}</h5>
                        <p class="card-text">{{$item->body}}</p>
                        <a href="{{route('article.show', ['article' => $item['id']])}}" class="btn btn-primary">Leggi {{$item->title}}</a>
                    </div>
                </div>