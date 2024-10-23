<div class="cart shadow-5-strong w-100 bg-white">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-12 col-lg-10">
                <div class="d-flex align-items-center h-100 p-3 justify-content-center">
                    Bạn có ({{ count($cart) }}) sản phẩm trong giỏ hàng
                </div>
            </div>
            <div class="col-12 col-lg-2">
                <a href="{{ route("cart.view") }}" class="btn btn-warning border-0 rounded-0 w-100 h-100 d-flex align-items-center justify-content-center" data-mdb-ripple-init>Đặt món ngay</a>
            </div>
        </div>
    </div>
</div>
