<div class="card">
    <div class="card-header">
        <h4 class="mb-0">En Çok Favorilenen Yemek</h4>
    </div>
    <div class="card-body">
        @if($mostFavoritedDish)
            <div class="text-center">
                <img src="{{ asset('storage/' . $mostFavoritedDish->image) }}"
     alt="{{ $mostFavoritedDish->name }}"
     style="max-height: 200px;"
     class="img-fluid mb-3">
                <h5>{{ $mostFavoritedDish->name }}</h5>
                <p>Fiyat: ₺{{ $mostFavoritedDish->price }}</p>
                <p>Favori Sayısı: {{ $mostFavoritedDish->favorite_count }}</p>
            </div>
        @else
            <p>Henüz favorilenmiş bir yemek bulunmamaktadır.</p>
        @endif
    </div>
</div>
