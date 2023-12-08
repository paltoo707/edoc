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