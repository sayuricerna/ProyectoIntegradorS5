          <ul class="account-nav">
            <li><a href="{{route('user.index')  }}" class="menu-link menu-link_us-s">Dashboard</a></li>
            <li><a href="account-orders.html" class="menu-link menu-link_us-s">Perdidos</a></li>
            <li><a href="account-address.html" class="menu-link menu-link_us-s">Direcciones</a></li>
            <li><a href="account-details.html" class="menu-link menu-link_us-s">Detalles de la cuenta</a></li>
            <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Lista de deseos</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                    {{-- <a href="{{ route('logout') }}" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a> --}}
                </form>
            </li>
          </ul>