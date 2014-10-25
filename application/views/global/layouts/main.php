<!doctype html>
<?php include_once 'common/head.php'; ?>

<body class="clearfix">

	<section class="app-wrapper">

	    <?php include_once 'common/header.php'; ?>

	    <div class="content clearfix">
	        <?php $this->load->view($content); ?>
	    </div>

    </section>

    <?php include_once 'common/footer.php'; ?>

    <?php include_once 'common/scripts.php'; ?>
    <script src="<?php echo site_url('assets/js/chat.js'); ?>"></script>
</body>
</html>