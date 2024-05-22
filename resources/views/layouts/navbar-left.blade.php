<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('assets/img/logo.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Software</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin/categorys') }}">
                <div class="parent-icon"><i class="bx bx-list-ol"></i>
                </div>
                <div class="menu-title">Categorias</div>
            </a>
            <a href="{{ route('admin/toppings') }}">
                <div class="parent-icon"><i class="bx bx-list-ol"></i>
                </div>
                <div class="menu-title">Toppings</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>