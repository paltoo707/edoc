<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link href="<?php echo base_url();?>assets/img/logo-ministry.png" rel="icon">
    <link href="<?php echo base_url();?>assets/img/logo-ministry.png" rel="apple-touch-icon">
    <title>Login EDOC - Strategy</title>
</head>
<body>
<div class="backwrap gradient">
    <div class="back-shapes">
        <div class="wrapper">
            <div class="container main">
                <div class="row">
                    <div class="col-md-6 side-image">
                        <img src="<?php echo base_url();?>assets/img/logo-ministry.png" alt="">
                    </div>
                    <div class="col-md-6 right">
                        <form action="<?php echo base_url('auth') ?>" method="POST">
                            <div class="input-box">
                                <header class="font-header">EDOC - Strategy</header>
                                <?php if($this->session->flashdata('login_error')): ?>
                                    <div class="alert alert-danger fade show noto" id="alertError">
                                        <span style="font-size: 13px;">
                                            <i class="fa-solid fa-user-lock"></i> <?= $this->session->flashdata('login_error'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div class="input-field">
                                    <input type="text" class="input" name="username" autocomplete="off" required="">
                                    <label for="email">Username</label> 
                                </div> 
                                <div class="input-field">
                                    <input type="password" class="input" name="password" autocomplete="off" required="">
                                    <label for="pass">Password</label>
                                </div> 
                                <div class="input-field">
                                    <input type="submit" class="submit" value="Log in">
                                </div> 
                                <div class="signin"></div>
                            </div> 
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('auth/animation'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#alertError').effect('bounce')
    })
    setTimeout(function(){$('#alertError').fadeOut()}, 4000)
</script>
</body>
</html>