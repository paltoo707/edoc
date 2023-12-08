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
?>
<div class="pagetitle">
  <h1><?php echo $row->book_title; ?></h1>
  <nav class="mt-1">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo site_url('acknowledge'); ?>">หน้าหลัก</a></li>
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
                        <h4 class="mb-4"><strong>ลงชื่อรับทราบ</strong></h4>
                        <h5 class="card-title" style="padding: 20px 0 1px 0;"><strong>หัวหน้ากลุ่ม :</strong></h5>
                        <div class="row mb-4 mt-2">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">ชื่อ - นามสกุล</th>
                                        <th scope="col">สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $this->db->select('app_status, user_fname, user_lname');
                                        $this->db->from('tb_approve');
                                        $this->db->join('tb_book', 'tb_book.book_id = tb_approve.app_book_id', 'left');
                                        $this->db->join('tb_user', 'tb_user.user_id = tb_approve.app_user_approve', 'left');
                                        $this->db->where('app_user_approve', $row->app_user_approve);
                                        $this->db->where('app_book_id', $row->book_id);
                                        $queryUser = $this->db->get();
                                        $rowUser = $queryUser->row();
                                    ?>
                                        <tr>
                                            <td>
                                                คุณ <?php echo $rowUser->user_fname.' '.$rowUser->user_lname; ?>
                                            </td>
                                            <td>
                                                <?php if($rowUser->app_status == 'Approve') : ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> รับทราบ</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> ยังไม่รับทราบ</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($row->app_status == 'Approve') :?>
                        <h5 class="card-title" style="padding: 20px 0 1px 0;"><strong>แจ้งเวียน :</strong></h5>
                        <div class="row mb-4 mt-2">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">ชื่อ - นามสกุล</th>
                                        <th scope="col">สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $this->db->select('ack_status, user_fname, user_lname');
                                        $this->db->from('tb_acknowledge');
                                        $this->db->join('tb_user', 'tb_user.user_id = tb_acknowledge.ack_user_approve', 'left');
                                        $this->db->where('ack_book_id', $row->book_id);
                                        $queryUserx = $this->db->get();
                                        foreach($queryUserx->result() as $rowUserx) :
                                    ?>
                                        <tr>
                                            <td>คุณ <?php echo $rowUserx->user_fname.' '.$rowUserx->user_lname; ?></td>
                                            <td>
                                                <?php if($rowUserx->ack_status == 'Acknowledge') : ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> รับทราบ</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> ยังไม่รับทราบ</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
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