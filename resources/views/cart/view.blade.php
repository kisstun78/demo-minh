@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>Giỏ hàng của bạn</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(!empty($cart))
            <table class="table">
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $key => $details)
                    @php
                        $total += $details['price'] * $details['qty'];
                    @endphp
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $key) }}" method="POST">
                                @csrf
                                <div class="d-flex input-number-group">
                                    <div class="input-number d-flex ms-3">
                                        <button type="button" class="btn-decrement btn btn-outline-secondary">-</button>
                                        <input name="qty" type="number" class="number-input form-control w-25"
                                               value="{{ $details['qty'] }}" min="1">
                                        <button type="button" class="btn-increment btn btn-outline-secondary">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-primary ms-3">Cập nhật</button>
                                </div>
                            </form>
                            <small><i>(Sau khi đổi số lượng, nhấn nút cập nhật)</i></small>
                        </td>
                        <td>{{ number_format($details['price'], 3, ',', '.') }} VND</td>
                        <td><span
                                class="text-danger">{{ number_format($details['price'] * $details['qty'], 3, ',', '.') }}</span>
                            VND
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-lg-end mb-2">
                Tổng cộng: <h5 class="text-danger d-inline">{{  number_format($total, 3, ',', '.') }}</h5> VND
            </div>
            <form action="{{ route('home.order') }}" class="d-inline" method="POST">
                @csrf
                <div class="text-lg-end">
                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <label for="">Tên: </label>
                        <input name="name" value="{{ old('name') }}" class="form-control w-auto ms-2" type="text">
                    </div>
                    @error('name')
                        <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <label for="">Số điện thoại: </label>
                        <input name="phone" class="form-control w-auto ms-2" type="text">
                    </div>
                    @error('phone')
                        <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                    <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Quay về trang chủ</a>
                    <button type="submit" class="btn btn-primary">Đặt món</button>
                </div>
            </form>
        @else
            <p>Giỏ hàng trống.</p>
            <a href="{{ route('home.index') }}" class="btn btn-secondary">Quay về trang chủ</a>
        @endif
    </div>
@endsection
