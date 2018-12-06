<div id='navbar'>
  <div id='top' class='grid-x'>
    <div class='cell medium-6'>
      <div id='logo'>
        <a href='/'><strong><i class="fas fa-home"></i>&nbsp;Critical Components CRM</strong></a>
      </div>
    </div>
    <div id='right' class='cell medium-6'>
      <ul class="dropdown menu align-right align-middle" data-dropdown-menu>
        <li style='text-align:right;'><a href="#"><strong>{{ $userDetails['name'] }}</strong><br />{{ $userDetails['role'] }}</a></li>
        <li>|</li>
        <li>
          <a id='section' href="#"><i class="fas fa-angle-double-down"></i>&nbsp; Go To Section</a>
          <ul class="menu">
            @foreach (session('logged_in_user_roles') as $role)
            <li>
              <a href='/{{ $role }}'>
                @if ($role == 'sales')
                <i class="fas fa-dollar-sign"></i>&nbsp;
                @endif
                @if ($role == 'service')
                <i class="fas fa-truck"></i>&nbsp;
                @endif
                @if ($role == 'executive')
                <i class="fas fa-user-tie"></i>&nbsp;
                @endif
                @if ($role == 'administrator')
                <i class="fas fa-server"></i>&nbsp;
                @endif
                {{ ucwords($role) }}
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        <li>|</li>
        <li><a href="#" title='Account Settings'><i class="fas fa-cog"></i>&nbsp;Settings</a></li>
        <li>|</li>
        <li><a href="/logout" title='Logout'><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></li>
      </ul>
    </div>
  </div>
</div>
