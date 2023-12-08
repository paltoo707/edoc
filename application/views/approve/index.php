<main id="main" class="main">
<div class="pagetitle">
  <h1>หนังสือเวียน ที่ยังไม่ได้อ่าน</h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('approve'); ?>">หน้าหลัก</a></li>
      <li class="breadcrumb-item">หนังสือเวียน</li>
      <li class="breadcrumb-item active">หนังสือที่ยังไม่ได้อ่าน</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <?php
            $this->load->view('template/function');
            if(count($query) >= 1){
            foreach($query as $row){
        ?>
        <a href="<?php echo site_url('approve/detail/'.$row->app_id.'/'.$row->app_user_approve); ?>">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-2">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-envelope" style="font-size: 5rem; color: #012970;"></i>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-caret-right-fill"></i> <?php echo $row->book_title; ?></h5>
                            <p class="card-text">
                                <small class="text-muted" style="margin-right: 20px;"><i class="bi bi-calendar3"></i> <?php echo dateThai($row->book_receive_date); ?> </small>
                                <small class="text-muted"><i class="bi bi-send-check"></i> <?php echo $row->book_from; ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php }} else { ?>
          <div class="card mb-3">
            <div class="col-md-12">
              <div class="card-body">
                <div class="d-flex justify-content-center">
                  <h5 class="card-title">- ยังไม่มีหนังสือเวียนในขณะนี้ค่ะ !! -</h5>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
    </div>
  </div>
</section>
</main>