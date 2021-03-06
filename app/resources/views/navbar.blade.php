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
        <li><a data-open="settings-modal" title='Account Settings'><i class="fas fa-cog"></i>&nbsp;Settings</a></li>
        <li>|</li>
        <li><a href="/logout" title='Logout'><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></li>
      </ul>

      <div class="reveal" id="settings-modal" data-reveal>
        <h3>Account Settings</h3>
        <button class="close-button" data-close aria-label="Close modal" type="button">
          <span aria-hidden="true">&times;</span>
        </button>

        <form action='/change-password' method='post'>
          {{ csrf_field() }}
          <fieldset class='fieldset'>
            <legend>
              Change Password
            </legend>

            <div class='grid-x grid-padding-x'>
              <div class='cell medium-12'>
                <label>Current Password</label>
                <input type='password' name='currentPassword' required />
              </div>
            </div>
            <div class='grid-x grid-padding-x'>
              <div class='cell medium-6'>
                <label>New Password</label>
                <input type='password' name='newPassword' required />
              </div>
              <div class='cell medium-6'>
                <label>Confirm New Password</label>
                <input type='password' name='confirmNewPassword' required />
              </div>
              <div class='cell medium-12'>
                <button type='submit' class='button button-primary'><i class="fas fa-sync"></i>&nbsp;Change Password</button>
              </div>
              <div class='cell medium-12'>
                @if ($errors->any())
                <div data-closable class="callout alert-callout-subtle warning radius">
                  <strong>Error</strong><br />
                  @foreach ($errors->all() as $error)
                  {{ $error }}<br />
                  @endforeach
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">⊗</span>
                  </button>
                </div>
                @endif
                @if (session('change-password-error'))
                <div data-closable class="callout alert-callout-subtle warning radius">
                  <strong>Error</strong><br />{{ session('change-password-error') }}
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">⊗</span>
                  </button>
                </div>
                @endif
              </div>
              <div class='cell medium-12' style="color:grey;">
                <strong>Password Policy</strong><br />
                &dash; Minimum 10 characters<br />
                &dash; Uppercase AND lowercase required<br />
                &dash; Must contain at least 1 number<br />
                &dash; Must contain at least 1 symbol
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
