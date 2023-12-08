<style>
    #embed-pdf{
        width: 100%;
        height: 850px;
    }
</style>
<main id="main" class="main">
<?php
    $this->load->view('template/function'); 
    $appId = $this->uri->segment(3);
    foreach($query as $row){
        $book_id = $row->book_id;
?>
<div class="pagetitle">
  <h1><?php echo $row->book_title; ?></h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('approve'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item active">หนังสือเวียน</li>
    </ol>
  </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-7">
        <?php 
            $arr = array();
            foreach($queryX as $rowX){ 
                $array = json_decode($rowX['book_files']);
                foreach ($array as $key => $value) {
        ?>
            <div class="card">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-10 d-flex justify-content-start">
                            <h5><strong>หนังสือเวียน</strong></h5>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end">
                            <a href="<?php echo base_url();?>uploads/files/<?php echo $value; ?>" target="_blank" class="btn btn-outline-info me-0">
                                <i class="bi bi-folder-fill"></i><span> เปิดไฟล์</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="embed-responsive">
                            <iframe class="embed-responsive-item" id="embed-pdf" src="<?php echo base_url();?>uploads/files/<?php echo $value; ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        <?php }} ?>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="mt-4">
                        <h4><strong>ลงชื่อรับทราบ</strong></h4>
                        <form id="approveForm" class="needs-validation " novalidate>
                            <div class="col-sm-12 mt-4">
                                <label for="มอบหมายให้ :" class="form-label"><strong>มอบหมายให้ :</strong></label><span class="fs-6 text-danger"> *</span>
                                <div class="form-check">
                                    <input class="form-check-input checkBoxClass" type="checkbox" id="selectAll">
                                    <label class="form-check-label" for="selectAll">
                                        ทั้งหมด
                                    </label>
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
                                    <input class="form-check-input checkBoxClass" type="checkbox" id="ackUserApprove" name="ackUserApprove[]" value="<?php echo $rowx->user_id; ?>" required>
                                    <label class="form-check-label" for="ackUserApprove">
                                        <?php echo $rowx->user_fname.' '.$rowx->user_lname; ?>
                                    </label>
                                </div>
                                <?php }} ?>
                                <small class="fs-12px text-danger invalid-feedback"></small>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <label for="มอบหมายธุรการ :" class="form-label"><strong>มอบหมายธุรการ :</strong></label>
                                <div class="form-check">
                                    <input class="form-check-input checkBoxClassx" type="checkbox" id="appUsePaper" name="appUsePaper" value="Use">
                                    <label class="form-check-label" for="appUsePaper">
                                        ปริ้นเอกสาร
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <label for="ความคิดเห็นเพิ่มเติม :" class="form-label">ความคิดเห็นเพิ่มเติม :</label>
                                <textarea rows="5" cols="50" class="form-control" id="appComment" name="appComment"></textarea>
                            </div>
                            <input type="hidden" name="bookId" id="bookId" value="<?php echo $book_id; ?>">
                            <input type="hidden" name="appId" id="appId" value="<?php echo $appId; ?>">
                            <div class="col-sm-12 mt-4">
                                <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-check-circle-fill"></i> รับทราบ</button>
                                <button type="" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle-fill"></i> กลับหน้าหลัก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="mt-4">
                        <h5><strong>รายละเอียดหนังสือเวียน</strong></h5>
                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <label for="เลขรับ :" class="form-label"><strong>เลขรับ :</strong></label>
                                <input type="text" class="form-control" value="<?php echo $row->book_receive_no; ?>" disabled>
                            </div>
                            <div class="col-md-7 mb-4">
                                <label for="เลขที่ :" class="form-label"><strong>เลขที่ :</strong></label>
                                <input type="text" class="form-control" value="<?php echo $row->book_sent_no; ?>" disabled>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="จาก :" class="form-label"><strong>จาก :</strong></label>
                                <input type="text" class="form-control" value="<?php echo $row->book_from; ?>" disabled>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="เรื่อง :" class="form-label"><strong>เรื่อง :</strong></label>
                                <textarea class="form-control" style="height: 100px;" disabled><?php echo $row->book_title; ?></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="วันที่ส่ง :" class="form-label"><strong>วันที่ส่ง :</strong></label>
                                <input type="text" class="form-control" value="<?php echo dateThai($row->book_sent_date); ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="วันที่รับ :" class="form-label"><strong>วันที่รับ :</strong></label>
                                <input type="text" class="form-control" value="<?php echo dateThai($row->book_receive_date); ?>" disabled>
                            </div>
                            <?php if($row->book_comment != ''){?>
                            <div class="col-md-12 mb-4">
                                <label for="เพิ่มเติมจากธุรการ :" class="form-label"><strong>เพิ่มเติมจากธุรการ :</strong></label>
                                <textarea class="form-control" style="height: 100px;" disabled><?php echo $row->book_comment; ?></textarea>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
</main>
<script>
    $(document).ready(function(){

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

        $("#approveForm").on("submit", function(e){
            e.preventDefault()

            $('#submit').text('กำลังบันทึก...')
            $('#submit').attr('disabled',true)
            
            //const countx = $('[name="ackUserApprove[]"]:checked').length
            //console.log(countx)

            const appId = $('#appId').val()
            const bookId = $('#bookId').val()
            const ackUserApprove = $("input[name='ackUserApprove']").val()

            const appUsePaper = $("input[name='appUsePaper']").val()
            const appComment = $('#appComment').val()

            

            var x = []
            var fomrData = new FormData()
            fomrData.append('appId', appId)
            fomrData.append('bookId', bookId)
            $('input[type=checkbox][name=ackUserApprove\\[\\]]').each(function(){
                if ( this.checked ) {
                    //console.log(this.value)
                    x = this.value
                    fomrData.append('ackUserApprove[]', x)
                } 
            })

            fomrData.append('appUsePaper', appUsePaper)
            fomrData.append('appComment', appComment)

            $.ajax({
                url: "<?php echo site_url('acknowledge/insert')?>",
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
                        }).then(function() {
                            $.ajax({
                                url: "<?php echo site_url('approve/update')?>",
                                method:"POST",
                                data: fomrData,
                                dataType:"JSON",
                                contentType:false,
                                cache:false,
                                processData:false,
                                success:function(data){ 
                                    if(data.status === true){
                                        console.log('update arrove success')
                                        window.location = "<?php echo site_url('approve'); ?>"
                                    }
                                }
                            })
                        })
                    } else {
                        for (let i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').addClass('is-invalid')
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i])
                        }
                    }
                    $('#submit').html('<i class="bi bi-check-circle-fill"></i> รับทราบ')
                    $('#submit').attr('disabled',false)
                }, error:function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding data acknowledge')
                }
            })

            if($('#appUsePaper').is(':checked') || appComment != ''){
                $.ajax({
                    url: "<?php echo site_url('approve/updateApprove')?>",
                    method:"POST",
                    data: fomrData,
                    dataType:"JSON",
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data){ 
                        if(data.status === true){
                            console.log('update arrove success')
                        }
                    }
                })
            }

        })

        $("checkbox").change(function(){
            $(this).removeClass('is-invalid')
            $(this).next().empty()
        })

    })
</script>