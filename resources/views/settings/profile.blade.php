<h2>Profile</h2>
<hr>
<form method="POST" id="update-profile-form">
        <div class="row">
                @php($adminName = explode('__', Auth::user()->name))
                <div class="col-xs-3">
                    <label for="">Last Name</label>
                    <input type="text" id="update-admin-lname" class="form-control" value="{{ $adminName[0] }}" placeholder="Last Name" required>
                </div>
            
                <div class="col-xs-3">
                    <label for="">First Name</label>
                    <input type="text" id="update-admin-fname" class="form-control" value="{{ $adminName[1] }}" placeholder="First Name" required>
                </div>
            
                <div class="col-xs-3">
                    <label for="">Middle Name</label>
                    <input type="text" id="update-admin-mname" class="form-control" value="{{ $adminName[2] }}" placeholder="Middle Name">
                </div>

                <div class="col-xs-1">
                    <label for="">&nbsp;</label>
                    <input type="submit" class="form-control btn btn-primary" value="Save">
                </div>

        </div>
</form>

<br><br>

<h2>Credentials</h2>
<hr>
<form method="POST" id="update-credential-form">
        <div class="row">

                <div class="col-xs-3">
                    <label for="">Username</label>
                    <input type="text" value="{{ Auth::user()->username }}" readonly class="form-control" placeholder="Username" required>
                </div>
            
                <div class="col-xs-2">
                    <label for="">Old Password</label>
                    <input type="password" id="update-opass" class="form-control" placeholder="Old Password" required>
                </div>
            
                <div class="col-xs-2">
                    <label for="">New Password</label>
                    <input type="password" id="update-npass" class="form-control" placeholder="New Password">
                </div>

                <div class="col-xs-2">
                        <label for="">Confirm Password</label>
                        <input type="password" id="update-cpass" class="form-control" placeholder="Confirm Password">
                </div>

                <div class="col-xs-1">
                        <label for="">&nbsp;</label>
                        <input type="submit" class="form-control btn btn-primary" value="Save">
                </div>

        </div>
</form>

<br><br>

<h2>Image</h2>
<hr>

<img id="cand-image" src="{{ asset('img/users') }}/{{ Auth::user()->image }}" class="img-responsive img-thumbnail" style="margin-bottom: 30px;">


<form method="POST" id="update-image-admin">
<div class="row">
    <div class="col-lg-4">
        <input type="hidden" id="crop-image" value="">
        <input type="file" name="upload_image" id="upload_image" accept="image/*" class="form-control" required>
    </div>
    <div class="col-lg-2">
        <button class="btn btn-primary" type="submit">Save</button>
    </div>
</div>
</form>
