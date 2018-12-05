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

        <li>
          <a href="#"><i class="fas fa-angle-double-down"></i>&nbsp; Change Section</a>
          <ul class="menu">
            <li><a href="#">Administrator</a></li>
            <li><a href="#">Sales</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Executive</a></li>
          </ul>
        </li>
        <li><a href="#" title='Account Settings'><i class="fas fa-cog"></i></a></li>
        <li><a href="/logout" title='Logout'><i class="fas fa-sign-out-alt"></i></a></li>
      </ul>
    </div>
  </div>
</div>
