<ul>
    <li class={{ request()->is('dashboard*') ? 'active' : "" }}>
        <a href="{{ route('dashboard') }}"><i data-feather="home"></i><span>
                Dashboard</span> </a>
    </li>
    <hr>
    
    @if (auth()->user()->role == "SuperAdmin")
    <li>
        <b>MASTER DATA</b>
    </li>
    <li class={{ request()->is('user*') ? 'active' : "" }}>
        <a href="{{ route('users.index') }}"><i data-feather="users"></i><span>
                Manajemen Pengguna</span> </a>
    </li>
    <li class={{ request()->is('inventories*') ? 'active' : "" }}>
        <a href="{{ route('inventories.index') }}"><i data-feather="tag"></i><span>
                Inventory</span> </a>
    </li>
    <hr>
    @endif
    <li>
        <b>TRANSACTION</b>
    </li>
    @if (auth()->user()->role != "Purchase")
    <li class={{ request()->is('sales*') ? 'active' : "" }}>
        <a href="{{ route('sales.index') }}"><i data-feather="file"></i><span>
                Sales</span> </a>
    </li>
    @endif
    @if (auth()->user()->role != "Sales")
    <li class={{ request()->is('purchase*') ? 'active' : "" }}>
        <a href="{{ route('purchase.index') }}"><i data-feather="folder"></i><span>
                Purchase</span> </a>
    </li>
    @endif
</ul>