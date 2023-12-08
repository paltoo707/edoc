<?php
	$sessionData = $this->session->userdata('logged_in');
	$sessUserId = $sessionData['userId'];
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>ข้อมูลส่วนตัว</h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('book'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item active">ข้อมูลส่วนตัว</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"></h5>
          <form class="row g-3 needs-validation " id="userForm" enctype="multipart/form-data" novalidate>
            <div class="col-md-3">
              <div class="col-md-12">
                <div class="d-flex justify-content-center">
                  <img id="imageProfile" src="<?php echo base_url();?>assets/img/blank-profile.gif" class="img-thumbnail" alt="รูปโปรไฟล์">
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-6 mb-2">
                  <label for="ชื่อ :" class="form-label">ชื่อ :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="userFname" id="userFname" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="นามสกุล :" class="form-label">นามสกุล :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="userLname" id="userLname" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-4">
                  <label for="อัพโหลดรูปภาพ :" class="form-label">อัพโหลดรูปภาพ :</label>
                  <input class="form-control" type="file" id="userImage" name="userImage">
                </div>
                <div class="col-md-4">
                  <label for="Username :" class="form-label">Username :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="username" id="username" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                  <span id="usernameCheckLength"></span>
                  <span id="usernameCheck"></span>
                </div>
                <div class="col-md-4">
                  <label for="Password :" class="form-label">Password :</label>
                  <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password">
                    <button class="btn btn-outline-secondary bi-eye-slash" type="button" id="togglePassword"></button>
                  </div>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                  <span id="pwdCheckLength"></span>
                </div>
                <div class="col-md-12">
                  <label for="" class="form-label"></label>
                    <button type="button" name="deleteImageProfile" id="deleteImageProfile" class="btn btn-outline-danger btn-sm deleteImageProfile">
                      <i class="bi bi-trash-fill"></i> ลบรูปโปรไฟล์
                    </button>
                </div>
                <input type="hidden" name="userId" id="userId" value="<?php echo $sessUserId ?>"/>
                <input type="hidden" id="hiddenUserImage" name="hiddenUserImage" value="" />
                <input type="hidden" id="hiddenPassword" name="hiddenPassword" value="" />
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end">
              <button id="submit" class="btn btn-outline-primary">
                <i class="bi bi-check-circle-fill"></i> ตกลง
              </button>&nbsp;
              <a type="button" class="btn btn-outline-secondary" href="<?php echo site_url('book'); ?>#">
                <i class="bi bi-x-circle-fill"></i> ยกเลิก
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
<script>

  $("input").change(function(){
      $(this).removeClass('is-invalid')
      $(this).next().empty()
  })
  $("select").change(function(){
      $(this).removeClass('is-invalid')
      $(this).next().empty()
  })

  $("#userForm").on("submit", function(e){
    e.preventDefault()

    $('#submit').text('กำลังบันทึก...')
    $('#submit').attr('disabled',true)

    var url
    const userId = $('#userId').val()
    const userFname = $('#userFname').val()
    const userLname = $('#userLname').val()
    const username = $('#username').val()
    const password = $('#password').val()
    const userImage = $('#userImage').prop('files')[0]
    const hiddenUserImage = $('#hiddenUserImage').val()
    const hiddenPassword = $('#hiddenPassword').val()

    const fomrData = new FormData()
    fomrData.append('userId', userId)
    fomrData.append('userFname', userFname)
    fomrData.append('userLname', userLname)
    fomrData.append('username', username)
    fomrData.append('password', password)
    fomrData.append('userImage', userImage)
    fomrData.append('hiddenUserImage', hiddenUserImage)
    fomrData.append('hiddenPassword', hiddenPassword)

    url = "<?php echo site_url('user/updateProfileSuccess')?>"

    $.ajax({
      url: url,
      method:"POST",
      data: fomrData,
      dataType:"JSON",
      contentType:false,
      cache:false,
      processData:false,
      success:function(data){ 
        if(data.status === true){
          Swal.fire({
            position: 'top',
            title: 'บันทึกข้อมูลสำเร็จ!',
            text: ' ',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          })
          getUserProfile()
        } else {
          for (let i = 0; i < data.inputerror.length; i++) {
            $('[name="'+data.inputerror[i]+'"]').addClass('is-invalid')
            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i])
          }
        }
        
        $('#submit').html('<i class="bi bi-check-circle-fill"></i> ตกลง')
        $('#submit').attr('disabled',false)
    }, error:function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data')
        $('#submit').html('<i class="bi bi-check-circle-fill"></i> ตกลง');
        $('#submit').attr('disabled',false)
      }
    })
  })

  $('#userImage').change(function(){
    const input = this
    const url = $(this).val()
    const ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase()
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {

        var reader = new FileReader()

        reader.onload = function (e) {
          $('#imageProfile').attr('src', e.target.result)
        }
      reader.readAsDataURL(input.files[0])
    }
  })

  $("#username").change(function(){
    const username = $('#username').val()
    if(username.length < 4){
      $('#usernameCheck').empty()
      $('#usernameCheckLength').html('<small class="fs-12px text-danger"> username ต้องมี 4 ตัวขึ้นไปค่ะ! </small>')
    } else {
      $('#usernameCheckLength').empty()
      if(username != ''){
        $.ajax({
          url:"<?php echo site_url('user/checkUsername')?>/" + username,
          method:"POST",
          dataType:"JSON",
          success:function(data){
              //console.log(data);
            if (data.status === false){
              $('#usernameCheck').html('<small class="fs-12px text-danger"><i class="bi bi-slash-circle"></i> username นี้มีผู้ใช้แล้วค่ะ </small>')
              $('#username').val('')
              $('#username').focus()
            } else {
              $('#usernameCheck').html('<small class="fs-12px text-success"><i class="bi bi-check-circle-fill"></i> username นี้สามารถใช้งานได้ค่ะ</small>')
            }
          }
        })
      }
    }
  })

  $("#password").change(function(){
    const password = $('#password').val()
    if(password.length < 4){
      $('#pwdCheckLength').html('<small class="fs-12px text-danger"> password ต้องมี 4 ตัวขึ้นไปค่ะ! </small>')
    } else {
      $('#pwdCheckLength').empty()
    }
  })

  $(document).on("click", ".deleteImageProfile", function(){
    var userId = $(this).attr("id");
    Swal.fire({
      position: 'top',
      title: 'ต้องการลบรูปโปรไฟล์ หรือไม่ ?',
      text: 'หากทำการลบสำเร็จ ข้อมูลจะไม่สามารถกู้คืนได้',
      icon: 'error',
      showCancelButton: true,
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก'
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url:"<?php echo site_url('user/deleteImageProfile')?>/" + userId,
          method:"POST",
          dataType:"JSON",
          success:function(data){
            Swal.fire({
              position: 'top',
              title: 'ลบข้อมูลสำเร็จ!',
              text: ' ',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true

            })
            $('#imageProfile').attr('src', '<?php echo base_url();?>assets/img/blank-profile.gif')
            $('.deleteImageProfile').attr('id', '')
            $('.deleteImageProfile').css('display', 'none')
          }
        })
      }
    })
  })

  function getUserProfile(){
    const userId = $('#userId').val();
    $.ajax({
        url:"<?php echo base_url(); ?>user/edit",
        method:"POST",
        data:{userId:userId},
        dataType:"JSON",
        cache: false,
        success:function(data){
          $('#userId').val(data.userId)
          $('#userFname').val(data.userFname)
          $('#userLname').val(data.userLname)
          $('#username').val(data.username)
          $('#passowrd').val(password)
          $('#hiddenUserImage').val(data.userImage)
          $('#hiddenPassword').val(data.hiddenPassword)
          $('.deleteImageProfile').attr('id', data.userId)
          if(data.userImage == ''){
            $('#imageProfile').attr('src', '<?php echo base_url();?>assets/img/blank-profile.gif')
            $('.deleteImageProfile').css('display', 'none')
          } else {
            $('#imageProfile').attr('src', '<?php echo base_url();?>uploads/images/users/' + data.imageProfile)
            $('.deleteImageProfile').css('display', 'block')
          }
        },  error: function (jqXHR, textStatus, errorThrown){
              alert('Error get data from ajax')
        }
      })

  }

  getUserProfile()

  const togglePassword = document.querySelector("#togglePassword")
  const password = document.querySelector("#password")

  togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type)
      
        this.classList.toggle("bi-eye")
  })
</script>