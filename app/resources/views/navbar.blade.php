<div id='navbar'>
  <div class='grid-x'>
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
              @if ($role == 'product-sales')
              <a href='/product-sales'><i class='fas fa-dollar-sign'></i>&nbsp;Product Sales</a>
              @endif
              @if ($role == 'inside-sales')
              <a href='/inside-sales'><i class='fas fa-dollar-sign'></i>&nbsp;Inside Sales</a>
              @endif
              @if ($role == 'executive')
              <a href='/exec'><i class='fas fa-user-tie'></i>&nbsp;Executive</a>
              @endif
              @if ($role == 'administrator')
              <a href='/admin'><i class='fas fa-server'></i>&nbsp;Administrator</a>
              @endif

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
