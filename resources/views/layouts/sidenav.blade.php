<aside class="app-sidebar">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ route('dashboard') }}">
            <img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="MayFair Logo" style="width: 150px; height: 100px;">
            <img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img mobile-logo" alt="MayFair logo">
        </a>
    </div>
    <ul class="side-menu app-sidebar3">
        @canany(['Admin Access','Main Dashboard'])
        <li class="side-item side-item-category">Main</li>
        <li class="slide">
            <a class="side-menu__item"  href="{{ route('dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path></svg>
            <span class="side-menu__label">Dashboard</span></a>
        </li>
        @endcanany
        @canany(['Admin Access','Expense Management'])
        <li class="side-item side-item-category">Components</li>
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z"></path></svg>
            <span class="side-menu__label">Expense Management</span><i class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li><a href="{{ route('expense') }}" class="slide-item"> Add Expense Details</a></li>
                {{-- <li><a href="{{ route('expense.category') }}" class="slide-item"> Add Expense Category</a></li> --}}
                <li><a href="{{ route('expenseType') }}" class="slide-item"> Add Expense Type</a></li>
                <li><a href="{{ route('expense.staff') }}" class="slide-item"> Sale Staff Expense By Staff</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['Admin Access','User Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>
            <span class="side-menu__label">User Management</span><i class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li><a href="{{ route('users') }}" class="slide-item"> Users of Admin Panel</a></li>
                <li><a href="{{route('roles.index')}}" class="slide-item"> Roles For Admin Panel Users</a></li>
                <li><a href="{{ route('role-permission.index') }}" class="slide-item"> Assign Role & Permission</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['Admin Access','Staff Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>
            <span class="side-menu__label">Staff Management</span><i class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li><a href="{{ route('staff') }}" class="slide-item"> All Staff Members of Application User</a></li>
                <li><a href="{{ route('role') }}" class="slide-item"> Add Role For Staff Members</a></li>
                <li><a href="{{ route('allocationExpense') }}" class="slide-item"> Allocations for Sale Expense</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['Admin Access','Manager Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>
            <span class="side-menu__label">Manager Management</span><i class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li><a href="{{ route('manager') }}" class="slide-item" style="@if (Auth::user()->user_type == 3) display: none; @endif"> All Manager</a></li>
                <li><a href="{{ route('expenseRequest') }}" class="slide-item"> Expense Requestes</a></li>
                <li><a href="{{ route('managerStaff') }}" class="slide-item" style="@if (Auth::user()->user_type != 3) display: none; @endif"> My Staff Members</a></li>
            </ul>
        </li>
        @endcanany
        {{-- @canany(['Admin Access','Reconcilation Report'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('reconciliation') }}">
                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 22c4.879 0 9-4.121 9-9s-4.121-9-9-9-9 4.121-9 9 4.121 9 9 9zm0-16c3.794 0 7 3.206 7 7s-3.206 7-7 7-7-3.206-7-7 3.206-7 7-7zm5.284-2.293 1.412-1.416 3.01 3-1.413 1.417zM5.282 2.294 6.7 3.706l-2.99 3-1.417-1.413z"/><path d="M11 9h2v5h-2zm0 6h2v2h-2z"/></svg>
            <span class="side-menu__label">Reconcilation Report</span></a>
        </li>
        @endcanany --}}
        @canany(['Admin Access','Cites'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('city') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7h-4V4c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H4c-1.103 0-2 .897-2 2v9a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9c0-1.103-.897-2-2-2zM4 11h4v8H4v-8zm6-1V4h4v15h-4v-9zm10 9h-4V9h4v10z"></path></svg>
            <span class="side-menu__label">Cities</span></a>
        </li>
        @endcanany
        @canany(['Admin Access','Zone'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('zone') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="m21.447 6.105-6-3a1 1 0 0 0-.895 0L9 5.882 3.447 3.105A1 1 0 0 0 2 4v13c0 .379.214.725.553.895l6 3a1 1 0 0 0 .895 0L15 18.118l5.553 2.776a.992.992 0 0 0 .972-.043c.295-.183.475-.504.475-.851V7c0-.379-.214-.725-.553-.895zM10 7.618l4-2v10.764l-4 2V7.618zm-6-2 4 2v10.764l-4-2V5.618zm16 12.764-4-2V5.618l4 2v10.764z"></path></svg>
            <span class="side-menu__label">Zone</span></a>
        </li>
        @endcanany
        @canany(['Admin Access','Fuel Rates'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('fuelRates') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 17V7c0-2.168-3.663-4-8-4S4 4.832 4 7v10c0 2.168 3.663 4 8 4s8-1.832 8-4zM12 5c3.691 0 5.931 1.507 6 1.994C17.931 7.493 15.691 9 12 9S6.069 7.493 6 7.006C6.069 6.507 8.309 5 12 5zM6 9.607C7.479 10.454 9.637 11 12 11s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2V9.607zM6 17v-2.393C7.479 15.454 9.637 16 12 16s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2z"></path></svg>
            <span class="side-menu__label">Fuel Rates</span></a>
        </li>
        @endcanany
        @canany(['Admin Access','Distance Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('distance') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>
            <span class="side-menu__label">Distance Management</span></a>
        </li>
        @endcanany
        {{-- @canany(['Admin Access','Add Stations'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('station') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path></svg>
            <span class="side-menu__label">Add Stations</span></a>
        </li>
        @endcanany --}}
        @canany(['Admin Access','Calender Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('calander') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7h-1.209A4.92 4.92 0 0 0 19 5.5C19 3.57 17.43 2 15.5 2c-1.622 0-2.705 1.482-3.404 3.085C11.407 3.57 10.269 2 8.5 2 6.57 2 5 3.57 5 5.5c0 .596.079 1.089.209 1.5H4c-1.103 0-2 .897-2 2v2c0 1.103.897 2 2 2v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zm-4.5-3c.827 0 1.5.673 1.5 1.5C17 7 16.374 7 16 7h-2.478c.511-1.576 1.253-3 1.978-3zM7 5.5C7 4.673 7.673 4 8.5 4c.888 0 1.714 1.525 2.198 3H8c-.374 0-1 0-1-1.5zM4 9h7v2H4V9zm2 11v-7h5v7H6zm12 0h-5v-7h5v7zm-5-9V9.085L13.017 9H20l.001 2H13z"></path></svg>
            <span class="side-menu__label">Calendar Management</span></a>
        </li>
        @endcanany

        @canany(['Admin Access','Designation Management'])
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('designation') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7h-1.209A4.92 4.92 0 0 0 19 5.5C19 3.57 17.43 2 15.5 2c-1.622 0-2.705 1.482-3.404 3.085C11.407 3.57 10.269 2 8.5 2 6.57 2 5 3.57 5 5.5c0 .596.079 1.089.209 1.5H4c-1.103 0-2 .897-2 2v2c0 1.103.897 2 2 2v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zm-4.5-3c.827 0 1.5.673 1.5 1.5C17 7 16.374 7 16 7h-2.478c.511-1.576 1.253-3 1.978-3zM7 5.5C7 4.673 7.673 4 8.5 4c.888 0 1.714 1.525 2.198 3H8c-.374 0-1 0-1-1.5zM4 9h7v2H4V9zm2 11v-7h5v7H6zm12 0h-5v-7h5v7zm-5-9V9.085L13.017 9H20l.001 2H13z"></path></svg>
            <span class="side-menu__label">Designation Management</span></a>
        </li>
        @endcanany

    </ul>
</aside>
