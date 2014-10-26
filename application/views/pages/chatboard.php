<div class="row">
<div class="col-sm-3 col-md-3 sidebar">
<ul class="nav nav-sidebar" id="chatgroup">
    <li><label>Chat Users</label></li>
    <?php if(!$users): ?>
        <li>No Users yet</li>
    <?php else: ?>
        <?php foreach ($users as $key): ?>
            <?php if($email != $key->email): ?>
                <li>
                    <a href="#<?php echo $key->id; ?>" class="chatusers <?php echo ($key->status == 0 ? 'disabled' : ''); ?>" chatto="<?php echo $key->id; ?>"><span id="cu-email"><?php echo $key->email; ?></span><span class="badge badge-danger notify hide"></span></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 main">
    <h1 class="page-header">Chatboard</h1>
    <div class="row" id="chat-container"></div>
    <div class="clearfix"></div>
    <div class="cb-box hide">
        <span id="suid"><?php echo $userid; ?></span>
        <div id="chat-box" class="col-sm-12 col-md-6 col-lg-4 chat-object">
        <div class="panel">
            <div class="panel-heading"><strong class="chatname_title">1@mail.com</strong><a href="#" class="chat-close btn btn-xs btn-default pull-right"><span class="glyphicon glyphicon-remove"></a></div>
            <div class="cb-main">
                <ul class="cb-feeds list-group"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="panel-footer">
                <form action="<?php echo site_url('users/chatsend'); ?>" method="post" class="chat-form">
                    <input type="hidden" name="chat_to" id="chat_to" value="">
                    <textarea name="message" id="message" class="form-control pull-left required message-box" placeholder="Write some message.."></textarea>
                    <input type="submit" value="Send" class="btn btn-success btn-md pull-right m-t" id="submit-chat-btn">
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>      
        </div>
    </div>
</div>
</div>