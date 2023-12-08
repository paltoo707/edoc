  <!-- Datepicker -->
  <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker-thai.js"></script>
  <script src="<?php echo base_url();?>assets/js/locales/bootstrap-datepicker.th.js"></script>

<main id="main" class="main">

<div class="pagetitle">
  <h1>จัดการหนังสือเวียน</h1></h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('book'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item active">หนังสือเวียนทั้งหมด</li>
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
              <a href="javascript:;" id="btnAddBook" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookModal">
                <i class="bi bi-plus-circle-fill"></i> สร้างหนังสือเวียน
              </a>
          </div>
          <table id="dataTableBook" class="table datatable table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th width="6%">เลขรับ</th>
                <th width=10%">เลขที่</th>
                <th width="20%">จาก</th>
                <th width="24%">เรื่อง</th>
                <th>วันที่ส่ง</th>
                <th>วันที่รับ</th>
                <th width="8%">ผู้ทำรายการ</th>
                <th width="10%">จัดการข้อมูล</th>
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


<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="bookForm" class="needs-validation " enctype="multipart/form-data" novalidate>
        <div class="modal-header text-white bg-primary">
          <h5 class="modal-title" id="bookModalLabel"><i class="bi bi-journal-plus"></i> สร้างหนังสือเวียน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-3 mb-2">
                  <label for="bookReceiveNo" class="form-label">เลขรับ :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="bookReceiveNo" id="bookReceiveNo" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-3 mb-2">
                  <label for="bookSentNo" class="form-label">เลขที่ :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="bookSentNo" id="bookSentNo" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="bookFrom" class="form-label">จาก :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="bookFrom" id="bookFrom" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-12 mb-2">
                  <label for="bookTitle" class="form-label">เรื่อง :</label><span class="fs-6 text-danger"> *</span>
                  <input type="text" class="form-control" name="bookTitle" id="bookTitle" required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="bookSentDate" class="form-label">วันที่ส่ง :</label><span class="fs-6 text-danger"> *</span>
                  <div class="input-group">
                    <label class="input-group-text bi-calendar3"></label>
                    <input type="text" class="form-control datepickerx" name="bookSentDate" id="bookSentDate" data-provide="datepicker" data-date-language="th" autocomplete="off" required>
                    <small class="fs-12px text-danger invalid-feedback"></small>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="bookReceiveDate" class="form-label">วันที่รับ :</label><span class="fs-6 text-danger"> *</span>
                  <div class="input-group">
                    <label class="input-group-text bi-calendar3"></label>
                    <input type="text" class="form-control datepickerx" name="bookReceiveDate" id="bookReceiveDate" data-provide="datepicker" data-date-language="th" autocomplete="off" required>
                    <small class="fs-12px text-danger invalid-feedback"></small>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="bookFiles:" class="form-label">อัพโหลดไฟล์ :</label><span class="fs-6 text-danger"> *</span>
                  <input class="form-control" type="file" name="bookFiles[]" id="bookFiles" multiple required>
                  <small class="fs-12px text-danger invalid-feedback"></small>
                </div>
                <div class="col-md-12 mb-4">
                  <label for="bookComment" class="form-label">ความคิดเห็นเพิ่มเติม :</label>
                  <textarea rows="5" cols="50" class="form-control" id="bookComment" name="bookComment"></textarea>
                </div>
                <div class="col-md-3 mb-4" id="selectLeader">
                  <label for="appUserApprove" class="form-label">ผู้มอบหมาย :</label>
                  <select class="form-select" aria-label="Default select example" id="appUserApprove" name="appUserApprove"></select>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-12 mb-4">
                  <div class="form-check form-switch">
                  <label class="form-check-label" for="nPass">ไม่ต้องผ่านหัวหน้ากลุ่ม</label>
                  <input class="form-check-input checkBoxClassx" type="checkbox" id="nPass" name="nPass" value="Pass">
                  </div>
                </div>
                <div class="col-md-12 mb-4 ps-4" id="selectWorkers">
                  <label for="มอบหมายให้ :" class="form-label"><strong>มอบหมายให้ :</strong></label><span class="fs-6 text-danger"> *</span>
                    <div class="form-check">
                        <label class="form-check-label" for="selectAll">
                            ทั้งหมด
                        </label>
                        <input class="form-check-input checkBoxClass" type="checkbox" id="selectAll">
                    </div>
                    <?php
                        $this->db->select('user_id, user_fname, user_lname');
                        $this->db->from('tb_user');
                        $this->db->where_not_in('user_type', 'Boss');
                        $query = $this->db->get();
                        $countRows = $query->num_rows();
                        foreach($query->result() as $rowx){
                            if($countRows >= 1) {
							      ?>
                    <div class="form-check">
                        <label class="form-check-label" for="ackUserApprove">
                            <?php echo $rowx->user_fname.' '.$rowx->user_lname; ?>
                        </label>
                        <input class="form-check-input checkBoxClass" type="checkbox" id="ackUserApprove" name="ackUserApprove[]" value="<?php echo $rowx->user_id; ?>" required>
                    </div>
                    <?php }} ?>
                </div>
                <div class="col-md-12 mb-4 pdf-file">
                  <label for="bookFilesUpload" class="form-label">ไฟล์เอกสาร :</label>
                  <span id="bookFilesUpload"></span>
                </div>
              </div>
            </div>
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="bookId" id="bookId" value="">
            <input type="hidden" name="userId" id="userId" value="<?php $sessUserData = $this->session->userdata('logged_in');  echo $sessUserID = $sessUserData['userId'];?>">
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

    var table = $("#dataTableBook").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],

      "ajax": {
          "url": "<?php echo site_url('book/list')?>",
          "method": "POST"
      },

      "columnDefs": [
        { 
          "targets": [ -1 ],
          "orderable": false,
        },
      ],
    })

    $("#btnAddBook").click(function(){
      $('#bookForm')[0].reset()
      $('#bookId').val('')
      $('.modal-header').removeClass('bg-warning')
      $('.modal-header').addClass('bg-primary')
      $('.modal-title').html('<i class="bi bi-journal-plus"></i> สร้างหนังสือเวียน')
      $('#bookFilesUpload').empty()
      $('input').removeClass('is-invalid')
      $('select').removeClass('is-invalid')
      $('#bookForm').removeClass('was-validated')
      $('#submit').removeClass('btn-outline-warning')
      $('#submit').addClass('btn-outline-primary')
      $('#action').val('insert')
      $('.modal-title').removeClass('text-black')
      $('.modal-title').addClass('text-white')
      $('.pdf-file').css('display', 'none')
      $('#appUserApprove').replaceWith('<select class="form-select" aria-label="Default select example" id="appUserApprove" name="appUserApprove"></select>')
      $('.form-switch').css('display', 'block')

      $.ajax({
        url:"<?php echo base_url(); ?>approve/userApprove",
        method:"POST",
        dataType:"JSON",
        cache: false,
        success:function(data){
          $('#appUserApprove').html(data.appUserApprove)
        },  error: function (jqXHR, textStatus, errorThrown){
              alert('Error get data from ajax')
        }
      })
    })

    $("#bookForm").on("submit", function(e){
      e.preventDefault()

      var nPass = $("input[name='nPass']").val()
      $('#submit').text('กำลังบันทึก...')
      $('#submit').attr('disabled',true)

      var url
      const action = $('#action').val()
      const userId = $('#userId').val()
      const bookId = $('#bookId').val()
      const bookReceiveNo = $('#bookReceiveNo').val()
      const bookSentNo = $('#bookSentNo').val()
      const bookFrom = $('#bookFrom').val()
      const bookTitle = $('#bookTitle').val()
      const bookReceiveDate = $('#bookReceiveDate').val()
      const bookSentDate = $('#bookSentDate').val()
      const bookComment = $('#bookComment').val()
      const bookFiles = $('#bookFiles')[0].files
      let appUserApprove
      if(nPass == 'Pass'){
        appUserApprove = $('#appUserApprove').val()
      } else {
        appUserApprove = userId
      }
      const ackUserApprove = $("input[name='ackUserApprove']").val()
      var x = []

      const fomrData = new FormData()
      fomrData.append('action', action)
      fomrData.append('userId', userId)
      fomrData.append('bookId', bookId)
      fomrData.append('bookReceiveNo', bookReceiveNo)
      fomrData.append('bookSentNo', bookSentNo)
      fomrData.append('bookFrom', bookFrom)
      fomrData.append('bookTitle', bookTitle)
      fomrData.append('bookReceiveDate', bookReceiveDate)
      fomrData.append('bookSentDate', bookSentDate)
      fomrData.append('bookComment', bookComment)
      for(let count = 0; count<bookFiles .length; count++){
        fomrData.append('bookFiles[]', bookFiles[count])
      }
      fomrData.append('appUserApprove', appUserApprove)
      fomrData.append('nPass', nPass)

      if(nPass == 'N-Pass'){
        $('input[type=checkbox][name=ackUserApprove\\[\\]]').each(function(){
          if ( this.checked ) {
            console.log(this.value)
            x = this.value
            fomrData.append('ackUserApprove[]', x)
          } 
        })
      }

      if(action == 'insert') {
        url = "<?php echo site_url('book/insert')?>"
      } else {
        url = "<?php echo site_url('book/update')?>"
      }
      
      if(nPass == 'N-Pass' && $('input[type=checkbox][name=ackUserApprove\\[\\]]') == ''){
        Swal.fire({
              position: 'top',
              title: 'กรุณาเลือก "ผู้มอบหมาย" ด้วยค่ะ!',
              text: ' ',
              icon: 'warning',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true
            })
      } else {
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
            $('#bookModal').modal('hide')
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
      }

    })

    $(document).on("click", ".deleteData", function(){
      const bookId = $(this).attr("id")
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
            url:"<?php echo site_url('book/delete')?>/" + bookId,
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
	    const bookId = $(this).attr("id")
      const userId = $('#userId').val()
      $('input').removeClass('is-invalid')
      $('select').removeClass('is-invalid')
      $('#bookForm').removeClass('was-validated')
      $('#bookFiles').val('')
      $('.pdf-file').css('display', 'block')
      $('.form-switch').css('display', 'none')
      $('.selectWorkers').css('display', 'none')

      $.ajax({
        url:"<?php echo base_url(); ?>book/edit",
        method:"POST",
        data:{bookId:bookId},
        dataType:"JSON",
        cache: false,
        success:function(data){
          $('#action').val('edit')
          $('#bookId').val(data.bookId)
          $('#bookReceiveNo').val(data.bookReceiveNo)
          $('#bookSentNo').val(data.bookSentNo)
          $('#bookFrom').val(data.bookFrom)
          $('#bookTitle').val(data.bookTitle)
          $('#bookReceiveDate').val(data.bookReceiveDate)
          $('#bookSentDate').val(data.bookSentDate)
          $('#bookComment').val(data.bookComment)
          $('#bookFilesUpload').html(data.bookFiles)
          $('#bookModal').modal('show');
          $('.modal-header').addClass('bg-warning')
          $('.modal-header').removeClass('bg-primary')
          $('.modal-title').html('<i class="bi bi-pencil-fill"></i> แก้ไขข้อมูลหนังสือเวียน')
          $('.modal-title').removeClass('text-white')
          $('.modal-title').addClass('text-black')
          $('#submit').addClass('btn-outline-warning')
          $('#submit').removeClass('btn-outline-primary')
        },  error: function (jqXHR, textStatus, errorThrown){
              alert('Error get data from ajax')
        }
      })
      console.log(bookId)
      $.ajax({
        url:"<?php echo base_url(); ?>approve/userApproveEdit/",
        method:"POST",
        data:{bookId:bookId},
        dataType:"JSON",
        cache: false,
        success:function(data){
          $('#appUserApprove').replaceWith(data.appUserApprove)
          //$('#appUserApprove').html(data.appUserApprove)
        },  error: function (jqXHR, textStatus, errorThrown){
              alert('Error get data from ajax')
        }
      })

    })

    $(document).on('click', '.btnRemove', function(){
      const bookId = $(this).attr("id");
      const relName = $(this).attr('relName');
      const relDiv = $(this).attr('relDiv');
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
        $.ajax({
          url:"<?php echo site_url('book/deleteFile')?>/" + bookId,
          method:"POST",
          data:{bookId:bookId, relName:relName},
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
            $('#fileLocation'+relDiv).hide()
          }
        })
      })
    })

    const currentDate = new Date()
    $(".datepickerx").datepicker({
      autoclose: true,
      todayBtn: true,
      clearBtn: true,
      endDate: "currentDate",
      maxDate: currentDate
    }).on('changeDate', function(ev){
      $(this).datepicker('hide')
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

    $('#selectWorkers').css('display', 'none')

    $('#nPass').click(function(event) {  
      if(this.checked) { 
          $("input[name='nPass']").val('N-Pass')
          this.value
          $('.checkBoxClassx').each(function() { 
            $('#selectLeader').css('display', 'none')
            $('#selectWorkers').css('display', 'block')
          })
      }else{
        $("input[name='nPass']").val('Pass')
        this.value
        $('.checkBoxClassx').each(function() {
          $('#selectLeader').css('display', 'block')
          $('#selectWorkers').css('display', 'none')
        })      
      }
    })

    $('#selectAll').click(function(event) {  
      if(this.checked) { 
        $('.checkBoxClass').each(function() { 
          this.checked = true;     
        })
      }else{
        $('.checkBoxClass').each(function() {
            this.checked = false; 
        })      
      }
    })


  })
</script>