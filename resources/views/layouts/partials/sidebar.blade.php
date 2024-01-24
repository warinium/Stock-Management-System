<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <i class="fa-solid fa-cubes"></i>
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>

    </a>
    <!-- Sidebar -->
    <div class="sidebar">




        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .class
   with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link {{activeSegment('products')}}">
                        <i class="fas fa-th-large"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>

                </li>
                <li class="nav-item">
                    <a href="{{route('cart.index')}}" class="nav-link {{activeSegment('cart')}}">
                        <i class="fas fa-cart-plus"></i>
                        <p>
                            Cart
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('purchaseCart.index')}}" class="nav-link {{activeSegment('purchaseCart')}}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>
                            Purchase Cart
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{route('customers.index')}}" class="nav-link {{activeSegment('customers')}}">
                        <i class="fas fa-users"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{route('providers.index')}}" class="nav-link {{activeSegment('providers')}}">
                        <i class="fa-solid fa-user-tie"></i>
                        <p>
                            Providers
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href={{route('purchases.index')}} class="nav-link {{activeSegment('purchases')}}">
                        <i class="fas fa-file-invoice"></i>
                        <p>
                            Purchases
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('orders.index')}}" class="nav-link {{activeSegment('orders')}}">
                        <i class="fas fa-file-invoice"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('settings.index')}}" class="nav-link {{activeSegment('settings')}}">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onClick="document.getElementById('logout-form').submit()">
                        <i class="fas fa-right-from-bracket"></i>


                        <p>
                            Logout

                        </p>
                        <form action="{{route('logout')}}" id="logout-form" method="POST">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>