<?php
		$sessData = $this->session->userdata('logged_in');
    $sessUserId = $sessData['userId'];
    $sessUserType = $sessData['userType'];
?>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link <?php if(($this->uri->segment(1)!="approve") && ($this->uri->segment(1)!="acknowledge") && $this->uri->segment(2)!="detail" &&  $this->uri->segment(2)!="all"){echo "collapsed";}?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="javascript:;">
          <i class="bi bi-menu-button-wide"></i><span>หนังสือเวียน</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="list-group nav-content collapse <?php if($this->uri->segment(1)=="approve" || $this->uri->segment(1)=="acknowledge" || $this->uri->segment(2)=="updateProfile" || $this->uri->segment(2)=="detail" || $this->uri->segment(2)=="all"){echo "show";}?>" data-bs-parent="#sidebar-nav">
        <?php if($sessUserType == 'Boss') : ?>
          <li class="list-group-itemx d-flex justify-content-between align-items-center">
            <a href="<?php echo site_url('approve'); ?>" class="<?php if($this->uri->segment(1)=="approve"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>หนังสือยังไม่ได้อ่าน</span>
            </a>
          </li>
        <?php  else : ?>
          <li class="list-group-itemx d-flex justify-content-between align-items-center">
            <a href="<?php echo site_url('acknowledge'); ?>" class="<?php if($this->uri->segment(1)=="acknowledge"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>หนังสือยังไม่ได้อ่าน</span>
            </a>
              <span class="badge rounded-pill" style="background-color: #4154f1;">
                <?php
                  $this->db->where('ack_user_approve', $sessUserId);
                  $this->db->where('ack_status', 'Not-Acknowledge');
                  $this->db->from('tb_acknowledge');
                  echo $this->db->count_all_results();
                ?>  
              </span>
          </li>
        <?php endif; ?>
          <li class="list-group-itemx d-flex justify-content-between align-items-center">
            <a href="<?php echo site_url('book/all'); ?>" class="<?php if($this->uri->segment(2)=="all"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>หนังสือทั้งหมด</span>
            </a>
          </li>
        </ul>
      </li>
      <?php if($sessUserType == 'Administrative' || $sessUserType == 'Admin') : ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(1)=="user" || $this->uri->segment(1)=="approve" || $this->uri->segment(1)=="acknowledge" || $this->uri->segment(2)=="all"){echo "collapsed";}?>" href="<?php echo site_url('book'); ?>">
          <i class="bi bi-journal-text"></i>
          <span> สร้างหนังสือเวียน</span>
        </a>
      </li>
      <?php endif; ?>
      <?php if($sessUserType == 'Admin') : ?>
      <li class="nav-item">
        <a class="nav-link <?php if(($this->uri->segment(2)=="index" || $this->uri->segment(1)=="book" || $this->uri->segment(1)=="approve" || $this->uri->segment(1)=="acknowledge")){echo "collapsed";}?>" href="<?php echo site_url('user'); ?>">
          <i class="bi bi-person"></i>
          <span>ผู้ใช้งานระบบ</span>
        </a>
      </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link collapsed logout" href="javascript:;">
          <i class="bi bi-box-arrow-right"></i>
            <span>ออกจากระบบ</span>
          </i>
        </a>
      </li>
    </ul>
  </aside>