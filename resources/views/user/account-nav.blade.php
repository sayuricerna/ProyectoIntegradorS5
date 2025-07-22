{{-- USER NAV ACCOUNT --}}
<ul class="account-nav">
  <li><a href="{{route('user.index')  }}" class="menu-link menu-link_us-s">Dashboard</a></li>
  <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Pedidos</a></li>
  <li><a href="" class="menu-link menu-link_us-s">Direcciones</a></li>
  <li><a href="{{ route('wishlist.index')}}" class="menu-link menu-link_us-s">Lista de deseos</a></li>
  <li><a href="" class="menu-link menu-link_us-s">Cuenta</a></li>
  <li>
      <form method="POST" action="{{ route('logout') }}" id="logout-form">
          @csrf
          <a href="#" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
      </form>
  </li>
</ul>