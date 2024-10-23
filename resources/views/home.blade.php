@extends('layout')
@section("content")
    <div class="home">
        <div class="container">
            <h2 class="text-center mb-4 pt-5">Menu</h2>
            <div class="row g-3">
                @if (isset($products) && count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-12 col-lg-4 d-flex align-items-stretch">
                            <div class="card animation fade-in">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                     alt="{{ $product->image }}">
                                <div class="card-body d-flex flex-column input-number-group">
                                    <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                    <p class="card-text text-secondary">
                                        {!! \Illuminate\Support\Str::limit($product->description, 100) !!}
                                    </p>
                                    <div class="mt-auto">
                                        <div class="price d-flex align-items-center">
                                            <span>Giá: </span>&nbsp;<b>{{ number_format($product->price, 3, ',', '.') }}</b>&nbsp;VND
                                        </div>
                                        <form action="{{ route("cart.add") }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pId" value="{{ $product->id }}">
                                            <input type="hidden" name="pImage" value="{{ asset('storage/' . $product->image) }}">
                                            <input type="hidden" name="pName" value="{{ $product->name }}">
                                            <input type="hidden" name="pPrice" value="{{ $product->price }}">
                                            <div class="d-flex align-items-center">
                                                <div>Số lượng: </div>
                                                <div class="input-number ms-3">
                                                    <button type="button" class="btn-decrement btn btn-outline-secondary">-</button>
                                                    <input name="qty" type="number" class="number-input form-control" value="1" min="1">
                                                    <button type="button" class="btn-increment btn btn-outline-secondary">+</button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary px-2 mt-3 w-100">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    @if(!empty($cart))
        @include('cart')
    @endif

@endsection
