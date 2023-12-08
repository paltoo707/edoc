<main id="main" class="main">

<div class="pagetitle">
  <h1>ผู้ใช้งานระบบ</h1></h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('book'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item active">ผู้ใช้งานทั้งหมด</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="mt-4 mb-4">
              <button type="button" class="btn btn-outline-secondary" onClick="javascript:location.reload();">
                  <i class="bi bi-arrow-repeat"></i> รีเฟรช
              </button>
              <a href="javascript:;" id="btnAddUser" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                  <i class="bi bi-person-plus-fill"></i> เพิ่มผู้ใช้งาน
              </a>
          </div>
          <table id="dataTableUser" class="table datatable table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th>รูปโปรไฟล์</th>
                <th>ชื่อ - สกุล</th>
                <th>username</th>
                <th>ประเภทผู้ใช้งาน</th>
                <th>การเปิดใช้งาน</th>
                <th>จัดการข้อมูล</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="userForm" class="needs-validation " enctype="multipart/form-data" novalidate>
        <div class="modal-header text-white bg-primary">
          <h5 class="modal-title" id="userModalLabel"><i class="bi bi-person-plus-fill"></i> เพิ่มผู้ใช้งาน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
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
                <div class="col-md-4 mb-2">
                  <label for="Username :" class="form-label">Username :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="username" id="username" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                  <span id="usernameCheckLength"></span>
                  <span id="usernameCheck"></span>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="Password :" class="form-label">Password :</label><span class="fs-6 text-danger"> *</span>
                  <div class="input-group">
                    <button class="btn btn-outline-secondary bi-eye-slash" type="button" id="togglePassword"></button>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <small class="fs-12px text-danger invalid-feedback"></small>
                  </div>
                  <span id="pwdCheckLength"></span>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="ประเภทผู้ใช้งาน :" class="form-label">ประเภทผู้ใช้งาน :</label><span class="fs-6 text-danger"> *</span>
                  <select class="form-select" aria-label="Default select example" name="userType" id="userType" required>
                      <option value="" selected>เลือก</option>
                      <option value="Admin">ผู้ดูแลระบบ</option>
                      <option value="Boss">หัวหน้ากลุ่ม</option>
                      <option value="Administrative">ธุรการกลุ่ม</option>
                      <option value="User">ผู้ใช้ทั่วไป</option>
                  </select>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-8">
                  <label for="อัพโหลดรูปภาพ :" class="form-label">อัพโหลดรูปภาพ :</label>
                  <input class="form-control" type="file" id="userImage" name="userImage">
                </div>
                <div class="col-md-4">
                  <label for="สถานะการเข้าใช้งาน :" class="form-label">สถานะการเข้าใช้งาน :</label><span class="fs-6 text-danger"> *</span>
                  <select class="form-select" aria-label="Default select example" name="userStatus" id="userStatus" required>
                      <option value="" selected>เลือก</option>
                      <option value="Active">เปิดใช้งาน</option>
                      <option value="noActive">ยังไม่เปิดใช้งาน</option>
                  </select>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-12">
                  <label for="" class="form-label"></label>
                    <button type="button" name="deleteImageProfile" id="deleteImageProfile" class="btn btn-outline-danger btn-sm deleteImageProfile">
                      <i class="bi bi-trash-fill"></i> ลบรูปโปรไฟล์
                    </button>
                </div>
              </div>
            </div>
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="userId" id="userId" value="">
            <input type="hidden" name="no" id="no" value="">
            <input type="hidden" id="hiddenUserImage" name="hiddenUserImage" value="">
            <input type="hidden" id="hiddenPassword" name="hiddenPassword" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button id="submit" class="btn btn-outline-primary"><i class="bi bi-check-circle-fill"></i> ตกลง</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>

</main>
<script>
  $(document).ready(function(){

    var table = $("#dataTableUser").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],

      "ajax": {
          "url": "<?php echo site_url('user/list')?>",
          "method": "POST"
      },

      "columnDefs": [
        { 
          "targets": [ -1 ],
          "orderable": false,
        },
      ],
    })

    $("#btnAddUser").click(function(){
      $('#userForm')[0].reset()
      $('.modal-header').removeClass('bg-warning')
      $('.modal-header').addClass('bg-primary')
      $('.modal-title').html('<i class="bi bi-person-plus-fill"></i> เพิ่มผู้ใช้งาน')
      $('.modal-title').removeClass('text-black')
      $('.modal-title').addClass('text-white')
      $('input').removeClass('is-invalid')
      $('select').removeClass('is-invalid')
      $('#userForm').removeClass('was-validated')
      $('#submit').removeClass('btn-outline-warning')
      $('#submit').addClass('btn-outline-primary')
      $('#usernameCheck').empty()
      $('#password').prop('required',true)
      $('#action').val('insert')
      $('#imageProfile').attr('src', '<?php echo base_url();?>assets/img/blank-profile.gif')
      $('.deleteImageProfile').css('display', 'none')
    })

    $("#userForm").on("submit", function(e){
      e.preventDefault()

      $('#submit').text('กำลังบันทึก...')
      $('#submit').attr('disabled',true)

      var url
      const action = $('#action').val()
      const userId = $('#userId').val()
      const no = $('#no').val()
      const userFname = $('#userFname').val()
      const userLname = $('#userLname').val()
      const userType = $('#userType').val()
      const userStatus = $('#userStatus').val()
      const username = $('#username').val()
      const password = $('#password').val()
      const userImage = $('#userImage').prop('files')[0]
      const hiddenUserImage = $('#hiddenUserImage').val()
      const hiddenPassword = $('#hiddenPassword').val()

      const fomrData = new FormData()
      fomrData.append('action', action)
      fomrData.append('userId', userId)
      fomrData.append('userFname', userFname)
      fomrData.append('userLname', userLname)
      fomrData.append('userType', userType)
      fomrData.append('userStatus', userStatus)
      fomrData.append('username', username)
      fomrData.append('password', password)
      fomrData.append('userImage', userImage)
      fomrData.append('hiddenUserImage', hiddenUserImage)
      fomrData.append('hiddenPassword', hiddenPassword)

      if(action == 'insert') {
        url = "<?php echo site_url('user/insert')?>"
      } else {
        url = "<?php echo site_url('user/update')?>"
      }

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
            $('#userModal').modal('hide')
            reloadTable()
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
    
    $(document).on("click", ".deleteData", function(){
      var userId = $(this).attr("id");
      Swal.fire({
        position: 'top',
        title: 'ต้องการลบข้อมูลนี้ หรือไม่ ?',
        text: 'หากทำการลบสำเร็จ ข้อมูลจะไม่สามารถกู้คืนได้',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
      })
      .then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:"<?php echo site_url('user/delete')?>/" + userId,
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
              reloadTable()
            }
          })
        }
      })
    })

    $(document).on("click", ".editData", function(){
	    const userId = $(this).attr("id")
      const password = $('#password').val = ""
      $('#userImage').val('')
      $('#password').val('')
      $('input').removeClass('is-invalid')
      $('select').removeClass('is-invalid')
      $('#userForm').removeClass('was-validated')
      $('#password').prop('required',false)

      $.ajax({
        url:"<?php echo base_url(); ?>user/edit",
        method:"POST",
        data:{userId:userId},
        dataType:"JSON",
        cache: false,
        success:function(data){
          $('#action').val('edit')
          $('#userId').val(data.userId)
          $('#userFname').val(data.userFname)
          $('#userLname').val(data.userLname)
          $('#username').val(data.username)
          $('#passowrd').val(password)
          $('#userType').val(data.userType)
          $('#userStatus').val(data.userStatus)
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
          $('#userModal').modal('show');
          $('.modal-header').addClass('bg-warning')
          $('.modal-header').removeClass('bg-primary')
          $('.modal-title').html('<i class="bi bi-pencil-fill"></i> แก้ไขข้อมูลผู้ใช้งาน')
          $('.modal-title').removeClass('text-white')
          $('.modal-title').addClass('text-black')
          $('#submit').addClass('btn-outline-warning')
          $('#submit').removeClass('btn-outline-primary')
        },  error: function (jqXHR, textStatus, errorThrown){
              alert('Error get data from ajax')
        }
      })
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
              reloadTable()
            }
          })
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
    
    $("input").change(function(){
        $(this).removeClass('is-invalid')
        $(this).next().empty()
    })
    $("select").change(function(){
        $(this).removeClass('is-invalid')
        $(this).next().empty()
    })
    
    function reloadTable(){
      table.ajax.reload(null,false);
    }

  })

  const togglePassword = document.querySelector("#togglePassword")
  const password = document.querySelector("#password")

  togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type)
      
        this.classList.toggle("bi-eye")
  })
</script>