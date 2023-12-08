  <!-- Datepicker -->
  <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker-thai.js"></script>
  <script src="<?php echo base_url();?>assets/js/locales/bootstrap-datepicker.th.js"></script>
<main id="main" class="main">

<div class="pagetitle">
  <h1>ค้นหาหนังสือเวียน</h1></h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('book'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item active">หนังสือเวียนทั้งหมด</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">หนังสือเวียนทั้งหมด <span>| เรื่อง</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-journal-bookmark"></i>
                </div>
                <div class="ps-3">
                  <h6 class="mb-2"><?php echo $this->db->count_all_results('tb_book'); ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">หนังสือเวียนรออนุมัติจากหัวหน้ากลุ่ม <span>| เรื่อง</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="ps-3">
                  <h6 class="mb-2">
                    <?php
                      $this->db->where('app_status', 'Not-Approve');
                      $this->db->from('tb_approve');
                      echo $this->db->count_all_results();
                    ?>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">หนังสือเวียนที่ยังไม่ได้ลงชื่อรับทราบ <span>| เรื่อง</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-emoji-expressionless"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="mb-2">
                      <?php
                        $query = $this->db->query("SELECT count(ack_id) FROM tb_acknowledge WHERE ack_status = 'Not-Acknowledge' GROUP BY ack_app_id");
                        echo $query->num_rows();
                      ?>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12 mb-4">
      <div class="row">
        <div class="col-md-7">
          <div class="input-group mb-3">
            <span class="input-group-text" style="background-color: #012970; border: 1px solid #012970;">
                <strong style="color: #fff;">
                    <i class="bi bi-search"></i> ค้นหา
                </strong>
            </span>
            <input type="text" class="form-control" placeholder="ระบุชื่อหนังสือ, เลขที่, เลขรับ, จากหน่วยงาน" id="keywords" onkeyup="searchFilter()">
          </div>
        </div>
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-5 mb-2">
              <div class="input-group">
                <label class="input-group-text bi-calendar3"></label>
                <input type="text" class="form-control datepickerx" name="fromDate" id="fromDate" data-provide="datepicker" data-date-language="th" autocomplete="off" placeholder="วันที่เริ่มต้น" required>
                <small class="fs-12px text-danger invalid-feedback"></small>
              </div>
            </div>
            <div class="col-md-5 mb-2">
              <div class="input-group">
                <label class="input-group-text bi-calendar3"></label>
                <input type="text" class="form-control datepickerx" name="toDate" id="toDate" data-provide="datepicker" data-date-language="th" autocomplete="off" placeholder="วันที่สิ้นสุด" required>
                <small class="fs-12px text-danger invalid-feedback"></small>
              </div>
            </div>
            <div class="col-md-2 mb-2">
              <input type="button" class="btn btn-primary" style="background-color: #012970; border: 1px solid #012970;" name="filter" id="filter" value="ตกลง"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">

      <div id="dataList">
      <?php 
        $this->load->view('template/function');
        if(!empty($allBook)){ foreach($allBook as $row){ 
      ?>
        <a href="<?php echo site_url('book/detail/'.$row['book_id']); ?>" target="_blank">
          <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-2">
                    <div class="d-flex justify-content-center">
                        <i class="bi bi-envelope-open" style="font-size: 3.5rem; color: #012970;"></i>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <h5 class="card-title" style="padding: 20px 0 1px 0;"><?php echo $row['book_title']; ?></h5>
                        <p class="card-text"><small class="text-muted">
                          <strong>เลขที่ : </strong><?php echo $row['book_sent_no']; ?> &nbsp;
                          <strong>เลขรับ : </strong><?php echo $row['book_receive_no']; ?> &nbsp;
                          <strong>จาก : </strong><?php echo $row['book_from']; ?> &nbsp;
                          <strong>วันที่รับ : </strong><?php echo dateThai($row['book_receive_date']); ?>
                        </small> <i class="bi bi-check-lg" style="color: #0f5132;"></i></p>
                    </div>
                </div>
            </div>
          </div>
        </a>
      <?php } } else { ?>
      <p style="line-height: 35px; margin-left: 20px;">- ไม่พบข้อมูลที่ค้นหา -</p>
      <?php } echo $this->ajax_pagination->create_links(); ?>
      <div class="loading" style="display: none;">
          <div class="content"><img src="<?php echo base_url().'assets/img/loading.gif'; ?>"/></div>
      </div>
      </div>

      <div id="resultSearch"></div>
      <div align="right" id="paginationLink"></div>
    </div>
  </div>
</section>

</main>
<script>
  $(document).ready(function(){

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

    $("#filter").click(function(){
      $('#dataList').css('display', 'none')
      $('#resultSearch').css('display', 'block')

      const fromDate = $('#fromDate').val()
      const toDate = $('#toDate').val()
      if(fromDate != '' && toDate != ''){
        $.ajax({  
            url:"<?php echo base_url(); ?>book/dateSearch",  
            method:"POST",  
            data:{fromDate:fromDate, toDate:toDate},
            dataType:"JSON",
            cache: false,  
            success:function(data)  
            {  
              $('#resultSearch').html(data.result)
            }  
        })
      } else {
        Swal.fire({
              position: 'top',
              title: 'เลือก "วันที่เริ่มต้น และ สิ้นสุด" ด้วยค่ะ!',
              text: ' ',
              icon: 'warning',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true
            })
            $('#dataList').css('display', 'block')
            $('#resultSearch').css('display', 'none')
      }
    })
    
  })  

  function searchFilter(page_num){
    $('#resultSearch').css('display', 'none')
    $('#resultSearch').empty()
    $('#dataList').css('display', 'block')
    page_num = page_num?page_num:0
    let keywords = $('#keywords').val()
    //let sortBy = $('#sortBy').val()
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('book/ajaxPagination/'); ?>'+page_num,
        data:'page='+page_num+'&keywords='+keywords,
        //data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function(){
            $('.loading').show()
        },
        success: function(html){
            $('#dataList').html(html)
            $('.loading').fadeOut("slow")
        }
    })
  }
</script>