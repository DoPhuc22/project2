<div class="text-center">
    Hello, <br>
    <span class="fs-5"></span>
</div>
<hr>
<div>
    <ul class="list-unstyled">
        <li class="pb-2">
            <a href="{{route('profile')}}" class="text-decoration-none nav-link">
                <i class="bi bi-person me-3 text-warning"></i> <span class="{{ request()->routeIs('profile') ? 'fw-bolder text-danger' : '' }}">Tài khoản</span>
            </a>
        </li>
        <li class="py-2">
            <a href="{{route('orderHistory')}}" class="text-decoration-none nav-link">
                <i class="bi bi-file-text me-3 text-success"></i> <span class="{{ request()->routeIs('orderHistory') ? 'fw-bolder text-danger' : '' }}">Lịch sử đặt vé</span>
            </a>
        </li>
        <li class="py-2">
            <a href="{{route('wishlist')}}" class="text-decoration-none nav-link">
                <i class="bi bi-heart me-3 text-danger"></i> <span class="{{ request()->routeIs('wishlist') ? 'fw-bolder text-danger' : '' }}">Phim yêu thích</span>
            </a>
        </li>
        <li class="py-2">
            <a href="{{route('customer.change_password')}}" class="text-decoration-none nav-link">
                <i class="bi bi-shield-lock me-3 text-primary"></i> <span class="{{ request()->routeIs('customer.change_password') ? 'fw-bolder text-danger' : '' }}">Thay đổi mật khẩu</span>
            </a>
        </li>
        <li class="py-2">
            <a href="{{ route('customer.logout') }}" class="text-decoration-none text-white">
                <i class="bi bi-box-arrow-left me-3 text-danger"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>
