<div class="col-md-6 col-md-offset-1">
    <div class="panel panel-primary">
        <div class="panel-heading">Admin Details</div>
        <div class="panel-body">
            <form class="" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label class="control-label">Name : </label>
                    <input type="text" name="name" value="Subhash Jha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Email : </label>
                    <input type="email" name="email" value="subhashjha35@gmail.com" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label">Mobile : </label>
                    <input type="number" name="mobile" value="8577853550"max="9999999999" min="7000000000" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">username : </label>
                    <input type="text" name="uname" value="admin" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label">password : </label>
                    <input type="password" name="password" value="12345678" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label">Upload Image : </label>
                    <input type="file">
                </div>
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button class="btn btn-lg btn-success" type="submit">Update Details</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-lg btn-default" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-4 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-body h5">
            <div class="text-center">
                <img src="useful/aaaa.jpg" class="text-center img-responsive img-thumbnail img-rounded" width="100%">
            </div>
            <div class="alert alert-warning" style="padding-bottom: 0px;">
                <div class="form-group">
                <label>Name : </label><span>Subhash Jha</span>
                </div>
                <div class="form-group">
                <label>Username : </label><span>admin</span>
                </div>
                <div class="form-group">
                <label>Email : </label><span style="">subhashjha35@gmail.com</span>
                </div>
                <div class="form-group">
                <label>Mobile : </label><span>8577853550</span>
                </div>
            </div>
        </div>

    </div>
</div>