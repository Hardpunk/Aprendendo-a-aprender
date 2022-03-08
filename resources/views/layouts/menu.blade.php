<li class="nav-item">
    <a href="{{ route('admin.home') }}" class="nav-link {{ Request::is('painel') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.banners.index') }}" class="nav-link {{ Request::is('painel/banners*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-images"></i>
        <p>Banners</p>
    </a>
</li>

<li class="nav-item {{ Request::is('painel/users*') ? 'active menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Alunos
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('painel/users') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Todos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.registered') }}" class="nav-link {{ Request::is('painel/users/registered') ? 'active' : '' }}">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Matriculados</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.unregistered') }}" class="nav-link {{ Request::is('painel/users/unregistered') ? 'active' : '' }}">
                <i class="fas fa-user-slash nav-icon"></i>
                <p>Não Matriculados</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('admin.payments.index') }}" class="nav-link {{ Request::is('painel/payments*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-coins"></i>
        <p>Vendas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ Request::is('painel/coupons*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p>Cupons</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ Request::is('painel/contacts*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-inbox"></i>
        <p>Contato</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.newsletters.index') }}" class="nav-link {{ Request::is('painel/newsletters*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Newsletters</p>
    </a>
</li>
