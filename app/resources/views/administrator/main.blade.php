<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administrator | Critical Components</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{ asset('css/bootstrap.css') }}'rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.css"/>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src='{{ asset('js/bootstrap.min.js')}}'></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js'></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.js"></script>
    <script src='//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js'></script>


  </head>
  @include('navbar')
  <body>

    <div id='main' class='grid-x'>

      <!-- success messages -->
      @if (session('success'))
      <div class='cell small-12'>
        <div class='message-card-success callout' data-closable>
          <span>{!! session('success') !!}</span>
          <button class="close-button" aria-label="Close alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      @endif

      <div class='cell small-12'>
        <div class='info-card'>
          <div class='title-muted'>
            <h5><strong><i class="fas fa-user-plus"></i>&nbsp;Add User</strong></h5>
          </div>
          <div class='content'>
            <form method='post' action='/user/add'>
              {{ csrf_field() }}
              <div class='grid-x grid-padding-x align-middle'>
                <div class='cell medium-3'>
                  <label>Full Name</label>
                  <input type='text' required name='name' />
                </div>
                <div class='cell medium-7'>


                    <input name='roles[]' value='product-sales' type='checkbox' /><label>Product&nbsp;Sales</label>
                    <input name='roles[]' value='inside-sales' type='checkbox' /><label>Inside&nbsp;Sales</label>
                    <input name='roles[]' value='executive' type='checkbox' /><label>Executive</label>
                    <input name='roles[]' value='administrator' type='checkbox' /><label>System Administrator</label>
                </div>
                <div class='cell medium-2'>
                  <button class='primary button'><i class="fas fa-check"></i>&nbsp;Save</button>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- user directory -->
      <div class='cell small-12'>
        <div class='info-card'>
          <div class='title'>
            <h5><strong><i class="fas fa-users"></i>&nbsp;User Directory</strong></h5>
          </div>
          <div class='content'>
            <div class='table-scroll'>
              <table id='users-table' class="unstriped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Roles</th>
                    <th>Projects</th>
                    <th>Notes</th>
                    <th>Password</th>
                    <th>Last Login</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td><a id='{{$user->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                    <td id='{{ $user->id}}-name'>{{ $user->name }}</td>
                    <td id='{{ $user->id}}-username'>{{ $user->username }}</td>
                    <td id='{{ $user->id}}-roles'>
                      @foreach ($user['roles'] as $role)
                      {{ $role }}<br />
                      @endforeach
                    </td>
                    <td>{{ $user->projectCount }}</td>
                    <td>{{ $user->noteCount }}</td>
                    <td><a data-open='{{$user->id}}-password-modal'><i class="fas fa-sync-alt"></i>&nbsp;Reset Password</a></td>
                    <td id='{{ $user->id}}-lastLogin'>{{ $user['formattedLastLogin'] }}</a></td>
                    <td><a data-open='{{ $user->id}}-delete-user-modal' style='color:lightgrey;'><i class="fas fa-trash-alt"></i></a></td>
                  </tr>

                  <script>

                    $.ajaxSetup({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }

                    });

                      $('#{{$user->id}}-name').editable(
                        {
                          container: 'body',
                          type: 'text',
                          pk: {{ $user->id }},
                          url: '/user/edit/name',
                          title: 'Enter Name',
                          disabled: true,
                          name: 'name',
                        }
                      );

                      $('#{{$user->id}}-username').editable(
                        {
                          container: 'body',
                          type: 'text',
                          pk: {{ $user->id }},
                          url: '/user/edit/username',
                          title: 'Enter Name',
                          disabled: true,
                          name: 'username',
                        }
                      );

                      $('#{{$user->id}}-roles').editable(
                        {
                          container: 'body',
                          type: 'checklist',
                          pk: {{ $user->id }},
                          url: '/user/edit/roles',
                          title: 'Select Roles',
                          disabled: true,
                          name: 'roles',
                          source: [
                            { value: 'product-sales', text: 'Product Sales' },
                            { value: 'inside-sales', text: 'Inside Sales' },
                            { value: 'executive', text: 'Executive' },
                            { value: 'administrator', text: 'Administrator' },
                          ]
                        }
                      );


                    // enable editing of row on click of toggle link
                    $('#{{$user->id}}-toggle').click(function(e) {
                      e.stopPropagation();
                      $('#{{$user->id}}-name').editable('toggleDisabled');
                      $('#{{$user->id}}-username').editable('toggleDisabled');
                      $('#{{$user->id}}-roles').editable('toggleDisabled');

                      $('#{{$user->id}}-name').toggleClass('edit-enabled');
                      $('#{{$user->id}}-username').toggleClass('edit-enabled');
                      $('#{{$user->id}}-roles').toggleClass('edit-enabled');

                    });
                  </script>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- projects table -->
      <div class='cell small-12'>
        <div class='info-card'>
          <div class='title'>
            <h5><strong><i class="fas fa-project-diagram"></i>Projects</strong></h5>
          </div>
          <div class='content'>
            <div class='table-scroll'>
              <table id='projects-table' class='unstriped'>
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Bid Date</th>
                    <th>Product</th>
                    <th>Product Sales</th>
                    <th>Inside Sales</th>
                    <th>Amount</th>
                    <th>APC OPP ID</th>
                    <th>Contractor</th>
                    <th>Engineer</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($projects as $i)
                  <tr>
                    <td>{{ $i->name }}</td>
                    <td
                      <?php

                        $status = $i['status']['status'];

                        if ($status == 'New') { echo 'class=\'status-new\''; }
                        if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                        if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                        if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                        if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                      ?>
                    >{{ $status }}</td>
                    <td
                      <?php
                          if ($i['bidTiming'] == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                          if ($i['bidTiming'] == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                      ?>
                    >{{ $i['formattedBidDate']}}</td>
                    <td>{{ $i->product }}</td>
                    <td>{{ $i['productSales']->name }}</span></td>
                    <td>{{ $i['insideSales']->name }}</td>
                    <td>{{ $i['formattedAmount'] }}</td>
                    <td>{{ $i->apc_opp_id }}</td>
                    <td>{{ $i->contractor }}</td>
                    <td>{{ $i->engineer }}</td>
                    <td><a data-open='{{ $i->id}}-delete-project-modal' style='color:lightgrey;'><i class="fas fa-trash-alt"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>


    <!-- reset password modals -->
    @foreach ($users as $user)
    <div class="reveal" id="{{$user->id}}-password-modal" data-reveal>
      <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;Reset Password</strong></h5>
      Are you sure you want to reset the password of <strong>{{$user->name}}</strong>?
      <br /><br />
      <div class='button-group'>

      </div>
    </div>
    @endforeach

    <!-- user delete modals -->
    @foreach ($users as $i)
    <div class='reveal text-center' id='{{ $i->id}}-delete-user-modal' data-reveal>
      <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;Delete User</strong></h5>
      You are about to delete user <strong>{{ $i->name }}</strong><br /><br />
      All the user's projects and notes will be deleted. If there are any projects you wish to keep,
      please make sure those projects are transferred to another person before deleting this account. This action is <span style='color:red;'>irreversible</span>.<br /><br />
      <div style='text-align:center;'>
        <a class='alert small button' href='/user/delete/{{ $i->id }}'>Delete</a>
        <a class='secondary small button' data-close>Cancel</a>
      </div>
    </div>
    @endforeach

    <!-- project delete modals -->
    @foreach ($projects as $i)
    <div class='reveal text-center' id='{{ $i->id}}-delete-project-modal' data-reveal>
      <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;Delete Project</strong></h5>
      You are about to delete project <strong>{{ $i->name }}</strong><br /><br />
      This project and all associated notes will be deleted. This action is <span style='color:red;'>irreversible</span>.<br /><br />
      <div style='text-align:center;'>
        <a class='alert small button' href='/project/delete/{{ $i->id }}'>Delete</a>
        <a class='secondary small button' data-close>Cancel</a>
      </div>
    </div>
    @endforeach

    @include('footer')


  </body>
  <script>
    $(document).foundation();

    $.fn.dataTable.moment( 'MM/DD/YYYY' );

    $('#users-table').DataTable( {
      'pageLength': 10,
    });

    $('#projects-table').DataTable( {
      'pageLength': 10,
      "order": [[ 2, "desc" ]],
    });
  </script>
</html>
