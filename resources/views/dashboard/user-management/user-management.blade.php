@extends('dashboard.layout.master')

@section('content')
  <div id="user-app" class="row">
      <div class="col-xs-12">
          <div class="box">
              <div class="box-header">
                <h3 class="box-title">User Management</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="table-user" class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Firstname</th>
                      <th>Lastname</th>
                      <th>Birthdate</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in dataList">
                      <td>@{{ index + 1 }}</td>
                      <td>@{{ item.username }}</td>
                      <td>@{{ item.firstname }}</td>
                      <td>@{{ item.lastname }}</td>
                      <td>@{{ item.birthdate }}</td>
                      <td>@{{ item.email }}</td>                          
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
  </div>
@endsection
@section('script-content')
  <script>
    $('#table-user').DataTable({
    'paging'      : true,
    'searching'   : true,
    'ordering'    : true,
  });
  </script>
@endsection
@section('vue-content')
  <script src="{{ asset('main/dashboard/user-management/user-management-vue.js') }}"></script>
@endsection
