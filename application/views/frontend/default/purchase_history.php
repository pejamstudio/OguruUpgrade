<?php
    $this->db->where(array('id_pengirim' => $this->session->userdata('user_id'), 'transaction_status' => 'settlement'));
    $purchase_history = $this->db->get('payment_mid',$per_page, $this->uri->segment(3));
?>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('my_courses'); ?></h1>
                <ul>
                  <li><a href="<?php echo site_url('home/kelas_saya'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <!-- <li><a href="<?php echo site_url('home/pesan'); ?>"><?php echo get_phrase('my_messages'); ?></a></li> -->
                  <li class="active"><a href="<?php echo site_url('home/riwayat_pembayaran'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                  <li><a href="<?php echo site_url('home/profil/profil_saya'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="purchase-history-list-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="purchase-history-list">
                    <li class="purchase-history-list-header">
                        <div class="row">
                            <div class="col-sm-6"><h4 class="purchase-history-list-title"> <?php echo get_phrase('purchase_history'); ?> </h4></div>
                            <div class="col-sm-6 hidden-xxs hidden-xs">
                                <div class="row">
                                    <div class="col-sm-3"> <?php echo get_phrase('date'); ?> </div>
                                    <div class="col-sm-3"> <?php echo get_phrase('total_price'); ?> </div>
                                    <div class="col-sm-4"> <?php echo get_phrase('payment_type'); ?> </div>
                                    <div class="col-sm-2"> Order Id </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php if ($purchase_history->num_rows() > 0):
                        foreach($purchase_history->result_array() as $each_purchase):
                        $course_details = $this->crud_model->get_course_by_id($each_purchase['id_course'])->row_array();
                        $parent = 'Akademik_';
                        if($course_details['parent_category'] == '1'){
                            $parent = 'Vokasional_';
                        }
                        ?>
                            <li class="purchase-history-items mb-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="purchase-history-course-img">
                                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($each_purchase['id_course']);?>" class="img-fluid">
                                        </div>
                                        <a class="purchase-history-course-title" href="<?php echo site_url('home/'.$parent.'/'.slugify($course_details['title']).'/'.$course_details['id']); ?>" >
                                            <?php
                                                echo $course_details['title'];
                                            ?>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 purchase-history-detail">
                                        <div class="row">
                                            <div class="col-sm-3 date">
                                                <?php echo $each_purchase['transaction_time']; ?>
                                            </div>
                                            <div class="col-sm-3 price"><b>
                                                Rp. <?php echo $each_purchase['gross_amount']; ?>
                                            </b></div>
                                            <div class="col-sm-4 payment-type">
                                                <?php echo ucfirst($each_purchase['payment_type']); ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo ucfirst($each_purchase['order_id']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <div>
                                <?php echo get_phrase('no_records_found'); ?>
                            </div>
                            <br><br><br><br>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<nav>
    <?php echo $this->pagination->create_links(); ?>
</nav>
