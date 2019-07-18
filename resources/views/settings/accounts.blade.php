
        <h2>Administator List</h2>
        <hr>
        <table class="table table-responsive table-striped table-bordered table-hover admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Access Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php($adminCount = 1)
                @foreach($users as $user)
                @php($uName = explode('__', $user->name))
                    <tr>
                        <td>{{ $adminCount++ }}</td>
                        <td>{{ $uName[0] }}, {{ $uName[1] }} {{ @$uName[2][0] }}.</td>
                        <td><img src="{{ asset('img/users') }}/{{ $user->image }}" width="50px" height="50px" class="img-responsive"></td>
                        <td>{{ $user->username }}</td>
                        <td>
                            @switch($user->lvl)
                            @case(0)
                            Administator
                            @break
                            @case(1)
                            User
                            @break
                            @default
                            Undefined
                            @endswitch
                        </td>
                        <td>
                            @if($user->lvl != 0)
                            <button onclick="deleteAdmin('{{ $user->id }}')" class="btn btn-danger btn-sm btn-bitbucket" title="Delete">
                                    <i class="fa fa-trash-o"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h2>Add New User</h2>
        <hr>

        <form method="POST" id="add-admin-form">

            <div class="row">
                <div class="col-xs-4">
                    <label for="">Last Name</label>
                    <input type="text" id="add-admin-lname" class="form-control" placeholder="Last Name" required>
                </div>

                <div class="col-xs-4">
                    <label for="">First Name</label>
                    <input type="text" id="add-admin-fname" class="form-control" placeholder="First Name" required>
                </div>

                <div class="col-xs-4">
                    <label for="">Middle Name</label>
                    <input type="text" id="add-admin-mname" class="form-control" placeholder="Middle Name">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Username</label>
                    <input type="text" id="add-admin-username" class="form-control" placeholder="Username">
                </div>

                <div class="col-xs-3">
                    <label for="">Password</label>
                    <input type="password" id="add-admin-pass" class="form-control" placeholder="Password">
                </div>

                <div class="col-xs-3">
                    <label for="">Confirm Password</label>
                    <input type="password" id="add-admin-cpass" class="form-control" placeholder="Confirm Password">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="col-xs-2">
                    <input type="submit" class="btn btn-primary" value="Add User">
                </div>
            </div>
        </form>
