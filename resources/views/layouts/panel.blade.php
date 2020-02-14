<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <img src="{{ asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HR</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte3/dist/img/user-icon.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('leaves') }}" class="{{ Request::is('leaves') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Leaves
                        </p>
                    </a>
                </li>
                @php
                $userid = Auth::user()->id;
                $user = App\User::find($userid);
                @endphp
                @if($user->is_manager == '1' )
                <li
                    class="{{ Request::is('pending','list','leaves/report') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview' }}">
                    <a href="#"
                        class="{{ Request::is('pending','list','leaves/report') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            Manage Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('pending') }}"
                                class="{{ Request::is('pending') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('list') }}"
                                class="{{ Request::is('list') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        @if($user->department->name == 'HR' || $user->id == 1)
                        <li class="nav-item">
                            <a href="{{ url('leaves/report') }}"
                                class="{{ Request::is('leaves/report') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(($user->department->name == 'HR' && $user->is_manager == 1) || $user->id == 1)
                <li
                    class="{{ Request::is('users','departments','balances') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview' }}">
                    <a href="#"
                        class="{{ Request::is('users','departments','balances') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            System
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('users') }}"
                                class="{{ Request::is('users') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('departments') }}"
                                class="{{ Request::is('departments') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('balances') }}"
                                class="{{ Request::is('balances') ? 'nav-link active' : 'nav-link' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Balance</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>