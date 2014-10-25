<div class="row main">
    <div class="col-sm-12 col-md-12">
        <div class="wrapper">
            <h3 class="page-header">Profile of <?php echo $email?></h3>
            <div class="row">
                <?php if($emailValid): ?>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <?php if(!$emailValid['profilepic']): ?>
                            <div id="profile-pic"><img src="<?php echo site_url('assets/img/profile-pic.jpg'); ?>" alt="profile-pic" title="profile-pic"></div>
                        <?php else: ?>
                            <div id="profile-pic"><img src="<?php echo $obj->profilepic; ?>" alt="profile-pic" title="profile-pic" id="profile-pic"></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        <h1 id="profile-header"><?php echo $emailValid['firstname'] .' '. $emailValid['lastname']; ?></h1>
                        <p><strong>Member since: </strong><?php echo $emailValid['date_active']; ?></p>
                        <?php if($userid == $emailValid['id']): ?>
                        <div class="well" id="changepassword-div">
                            <form action="<?php echo site_url('users/change_password'); ?>" method="post" class="class-forms">
                                <h3>Change Password</h3>
                                <input type="password" class="form-control required" name="old-password" placeholder="Old Password">
                                <input type="password" class="form-control required" name="new-password" placeholder="New Password">
                                <input type="password" class="form-control required" name="confirm-password" placeholder="Confirm Password">
                                <input type="submit" value="Update" class="btn btn-lg btn-success">
                            </form>
                        </div>
                        <?php else: ?>
                            <a href="<?php echo site_url('users/chatboard'); ?>" class="btn btn-lg btn-success">Back to Chatboard</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="col-sm-12 col-md-12">This is not available on our database. It must be removed already. Here have some potato or go back to <a href="<?php echo site_url('users/chatboard'); ?>">Chatboard</a></div>
                <?php endif; ?>
                <div>
            </div>
        </div>
    </div>
</div>