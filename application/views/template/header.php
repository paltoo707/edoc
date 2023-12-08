<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>EDOC - Strategy</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/logo-ministry.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/logo-ministry.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- DataTable -->
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">

  <!-- Jquery -->
  <script src="<?php echo base_url();?>assets/js/jquery-3.6.3.js"></script>

  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
</head>

<body>
<?php
		$sessData = $this->session->userdata('logged_in');
		$sessUserID = $sessData['userId'];
    $sessUserFname = $sessData['userFname'];
    $sessUserLname = $sessData['userLname'];
    $sessUserType = $sessData['userType'];
    $sessUserStatus = $sessData['userStatus'];
    $sessUserImage = $sessData['userImage'];
?>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?php echo base_url();?>assets/img/logo-e.png" alt="">
        <span class="d-none d-lg-block">DOC</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <?php if($sessUserImage != '') : ?>
                    <img src="<?php echo base_url();?>uploads/images/users/<?php echo $sessUserImage; ?>" alt="Profile" class="rounded-circle" width="36" height="36">
            <?php else : ?>
                    <img src="<?php echo base_url();?>assets/img/blank-profile-circle.jpg" alt="Profile" class="rounded-circle" width="36" height="36">
            <?php endif; ?>
            <span class="d-none d-md-block dropdown-toggle ps-2">คุณ. <?php echo $sessUserFname; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $sessUserFname.' '.$sessUserLname; ?></h6>
              <span>กลุ่มยุทธศาสตร์แผนงานและเครือข่าย</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url('user/updateProfile'); ?>">
                <i class="bi bi-person"></i>
                <span>ข้อมูลส่วนตัว</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center logout" href="javascript:;">
                <i class="bi bi-box-arrow-right"></i>
                <span>ออกจากระบบ</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
  <script>
    $(document).ready(function(){
      $(".logout").on('click', function(e) {
        e.preventDefault();
        Swal.fire({
          position: 'top',
          title: 'ต้องการออกจากระบบ หรือไม่ ?',
          text: 'กดปุ่มตกลงเพื่อทำรายการ',
          icon: 'error',
          showCancelButton: true,
          confirmButtonText: 'ตกลง',
          cancelButtonText: 'ยกเลิก'
        })
        .then((result) => {
          if (result.isConfirmed) {
            window.location = "<?php echo site_url('auth/logout'); ?>"
          }
        })
      })
    })
  </script>