<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*    clear cache
*/
if ( ! function_exists('clear_cache')) {
    function clear_cache(){
        $CI =& get_instance();
        $CI->output->set_header('Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
        $CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
        $CI->output->set_header("Cache-Control: no-cache, no-store, must-revalidate");
        $CI->output->set_header("Pragma: no-cache");            
    }
}
/**
*    check superadmin logged in
*/
if ( ! function_exists('superadmin_logged_in')) {
    function superadmin_logged_in(){
        $CI =& get_instance();
        $superadmin_info = $CI->session->userdata('superadmin_info');
        if($superadmin_info['logged_in']===TRUE && $superadmin_info['user_role'] == 0 )
            return TRUE;
        else
            return FALSE;
    }
}
if ( ! function_exists('sales_logged_in')) {
    function sales_logged_in(){
        $CI =& get_instance();
        $sale_info = $CI->session->userdata('sale_info');
        if($sale_info['logged_in']===TRUE && $sale_info['user_role'] == 5 )
            return TRUE;
        else
            return FALSE;
    }
}
/**
*    get superadmin id
*/
if ( ! function_exists('sales_user_id')) {
    function sales_user_id(){
        $CI =& get_instance();
        $sale_info = $CI->session->userdata('sale_info');        
            return $sale_info['id'];        
    }
}
if ( ! function_exists('sales_user_name')) { 
    function sales_user_name(){
        $CI =& get_instance();
        $sales_info = $CI->session->userdata('sale_info');
        if($sales_info['logged_in']===TRUE )
             return $sales_info['first_name']." ".$sales_info['last_name'];
        else
            return FALSE;
    }                    
}
if ( ! function_exists('superadmin_id')) {
    function superadmin_id(){
        $CI =& get_instance();
        $superadmin_info = $CI->session->userdata('superadmin_info');        
            return $superadmin_info['id'];        
    }
}
if ( ! function_exists('get_total_store')) {
    function get_total_store(){
        $CI =& get_instance();
        return $CI->account_model->statistics_store_total('stores');        
    }
}
/**
*    superadmin login information
*/
if ( ! function_exists('superadmin_name')) { 
    function superadmin_name(){
        $CI =& get_instance();
        $superadmin_info = $CI->session->userdata('superadmin_info');
        if($superadmin_info['logged_in']===TRUE )
             return $superadmin_info['first_name']." ".$superadmin_info['last_name'];
        else
            return FALSE;
    }                    
}
if ( ! function_exists('getcustomArtWork')) {     
   function getcustomArtWork($design_id=''){            
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('store_atr_work',array('design_id'=>$design_id),array('design_file')))        
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_order_payment_log')) {      
    function get_order_payment_log($id=''){            
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('order_payment_log',array('card_id'=>$id)))        
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_affiliate_commission_history')) {        
    function get_affiliate_commission_history($user_id=''){            
        $CI =& get_instance();
        $SQL="select sum(paid_amount) as paid_amt from user_commission_history where user_id='".$user_id."' group by user_id";
        $query = $CI->db->query($SQL);        
        $result=$query->row();
        if($result)
            return $result->paid_amt;    
        else
            return '0.00';
    }        
}
if ( ! function_exists('get_store_category_affiliate')) {        
    function get_store_category_affiliate($s1=''){            
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('store_category',array('affiliate_category'=>1)))        
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_total_counting_complete')) {        
    function get_total_counting_complete($table_name='',$field_name ='',$status=''){            
        $CI =& get_instance();                
         if($query=$CI->db->query('SELECT count(*) as total_rows FROM '.$table_name.' WHERE `'.$field_name.'` = '.$status . ' && mark_complete = 0'))         
             return $query->row();        
         else        
             return 0;        
    }            
}
if ( ! function_exists('getPromocode')) {        
    function getPromocode(){            
        $CI =& get_instance();                
         if($query=$CI->db->query('SELECT code FROM coupons where start_date<="'.date('Y-m-d').'" && end_date>="'.date('Y-m-d').'" && code_type =3 && status=1 order by  RAND()'))         
             return $query->row();        
         else        
             return false;        
    }            
}
if ( ! function_exists('total_commission_earn_affiliate')) {        
    function total_commission_earn_affiliate(){            
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result_affiliate())        
             return $query;        
         else        
             return false;        
    }        
}        
if ( ! function_exists('normal_user_logged_in')) {
    function normal_user_logged_in(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('normal_user_logged_in');
        if($store_admin_info['logged_in']===TRUE && $store_admin_info['password']!='')
            return TRUE;
        else
            return FALSE;
    }
}
if ( ! function_exists('store_admin_logged_in')) {
    function store_admin_logged_in(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');
        if($store_admin_info['logged_in']===TRUE && ($store_admin_info['user_role'] == 1 || $store_admin_info['user_role'] == 4))
            return TRUE;
        else
            return FALSE;
    }
}
if ( ! function_exists('encodeURIComponent')) {
    function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }
}
/**
*    get admin id
*/
if ( ! function_exists('store_admin_id')) {
    function store_admin_id(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');        
            return $store_admin_info['id'];        
    }
}
// check promo code expiry 

if ( ! function_exists('promocodeexpired')) {
    function promocodeexpired($code){
        $CI =& get_instance();
        $coupons_info = $CI->common_model->get_row('coupons',array('code'=>$code));
        if(!empty($coupons_info))
        {
            if($coupons_info->code_type==3 || $coupons_info->code_type==4 || $coupons_info->code_type==5 || $coupons_info->code_type==6)
            $CI->common_model->update('coupons',array('used_status'=>0),array('id'=>$coupons_info->id));
            
        }            
            //return $store_admin_info;        
    }
}

if ( ! function_exists('get_user_info')) {
    function get_user_info(){
        $CI =& get_instance();
        $store_admin_info = $CI->common_model->get_row('users',array('id'=>store_admin_id()));        
            return $store_admin_info;        
    }
}

if ( ! function_exists('store_admin_slug')) {
    function store_admin_slug(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');        
            return $store_admin_info['admin_slug'];        
    }
}

/**
*    admin login information
*/
if ( ! function_exists('store_admin_name')) {
    function store_admin_name(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');
        if($store_admin_info['logged_in']===TRUE ){
            if($store_admin = $CI->common_model->get_row('users',array('id'=>store_admin_id()), array(), array('first_name','last_name'))){
             return $store_admin->first_name.' '.$store_admin->last_name;
            }else{
                return FALSE;
            }
         }
        else
            return FALSE;
    }                    
}

if ( ! function_exists('store_admin_profile_info')) {
    function store_admin_profile_info(){
        $CI =& get_instance();
        $store_admin_profile_info = $CI->session->userdata('store_admin_profile_info');
             return $store_admin_profile_info['set_status'];
    }                    
}

if ( ! function_exists('store_free_shipping')) {
    function store_free_shipping(){
        $CI =& get_instance();
        $store_free_shipping = $CI->session->userdata('store_free_shipping');
             return $store_free_shipping['set_status'];
    }                    
}
if ( ! function_exists('check_thank_you_mail')) {
    function check_thank_you_mail(){
        $CI =& get_instance();
        $check_thank_you_mail = $CI->session->userdata('check_thank_you_mail');
             return $check_thank_you_mail['set_status'];
    }                    
}
if ( ! function_exists('check_thank_you_mail_gift')) {
    function check_thank_you_mail_gift(){
        $CI =& get_instance();
        $check_thank_you_mail = $CI->session->userdata('check_thank_you_mail_gift');
             return $check_thank_you_mail['set_status'];
    }                    
}
if ( ! function_exists('store_created_popup')) {
    function store_created_popup(){
        $CI =& get_instance();
        $store_created_popup = $CI->session->userdata('store_created_popup');
             return $store_created_popup['set_status'];
    }                    
}
/**
*    user role information
*/
if ( ! function_exists('store_admin_role')) {
    function store_admin_role(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');
        if($store_admin_info['logged_in']===TRUE )
             return $store_admin_info['user_role'];
        else
            return FALSE;
    }                    
}
if ( ! function_exists('store_admin_email')) {
    function store_admin_email(){
        $CI =& get_instance();
        $store_admin_info = $CI->session->userdata('store_admin_info');
        if($store_admin_info['logged_in']===TRUE ){
            $store_admin = $CI->common_model->get_row('users',array('id'=>store_admin_id()), array('email')); 
             return $store_admin->email;
         }
        else
            return FALSE;
    }                    
}


if ( ! function_exists('backend_pagination')) {
    function backend_pagination(){
        $data = array();        
        $data['full_tag_open'] = '<ul class="pagination">';        
        $data['full_tag_close'] = '</ul>';
        $data['first_tag_open'] = '<li>';
        $data['first_tag_close'] = '</li>';
        $data['num_tag_open'] = '<li>';
        $data['num_tag_close'] = '</li>';
        $data['last_tag_open'] = '<li>';
        $data['last_tag_close'] = '</li>';
        $data['next_tag_open'] = '<li>';
        $data['next_tag_close'] = '</li>';
        $data['prev_tag_open'] = '<li>';
        $data['prev_tag_close'] = '</li>';
        $data['cur_tag_open'] = '<li class="active"><a href="#">';
        $data['cur_tag_close'] = '</a></li>';
        return $data;
    }                    
}
/**
*    frontend pagination
*/
if ( ! function_exists('frontend_pagination')) {
    function frontend_pagination(){
        $data = array();
        $data['full_tag_open'] = '<ul class="pagination">';        
        $data['full_tag_close'] = '</ul>';
        $data['first_tag_open'] = '<li>';
        $data['first_tag_close'] = '</li>';
        $data['num_tag_open'] = '<li>';
        $data['num_tag_close'] = '</li>';
        $data['last_tag_open'] = '<li>';        
        $data['last_tag_close'] = '</li>';
        $data['next_tag_open'] = '<li>';
        $data['next_tag_close'] = '</li>';
        $data['prev_tag_open'] = '<li>';
        $data['prev_tag_close'] = '</li>';
        $data['cur_tag_open'] = '<li class="active"><a href="#">';
        $data['cur_tag_close'] = '</a></li>';
        $data['next_link'] = 'Next';
        $data['prev_link'] = 'Previous';
        return $data;
    }                    
}

/**
*    thisis  back end helper 
*/
if ( ! function_exists('msg_alert')) {
    function msg_alert(){
    $CI =& get_instance(); ?>
<?php if($CI->session->flashdata('msg_success')): ?>    
    <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert">&times;</button> 
        <strong>Success :</strong> <br>  <?php echo $CI->session->flashdata('msg_success'); ?>
    </div>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>    
    <div class="alert alert-info">
         <button type="button" class="close" data-dismiss="alert">&times;</button> 
        <strong>Info :</strong> <br> <?php echo $CI->session->flashdata('msg_info'); ?>
    </div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>    
    <div class="alert alert-warning">
         <button type="button" class="close" data-dismiss="alert">&times;</button> 
         <strong>Warning :</strong> <br> <?php echo $CI->session->flashdata('msg_warning'); ?>
    </div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>    
    <div class="alert alert-danger">
         <button type="button" class="close" data-dismiss="alert">&times;</button> 
         <strong>Error :</strong> <br>  <?php echo $CI->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
    <?php }                    
}
/**
*    thisis  back end helper 
*/
if ( ! function_exists('msg_alert_front')) {
    function msg_alert_front(){
    $CI =& get_instance(); ?>
    <?php if($CI->session->flashdata('theme_danger')): ?>    
    <div class="alert theme-alert-danger">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('theme_danger'); ?>
    </div>
 <?php endif; ?>
 <?php if($CI->session->flashdata('theme_success')): ?>    
    <div class="alert theme-success">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('theme_success'); ?>
    </div>
 <?php endif; ?>

<?php if($CI->session->flashdata('msg_success')): ?>    
    <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('msg_success'); ?>
    </div>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>    
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button> 
        <!-- <strong>Info :</strong> <br> --> <?php echo $CI->session->flashdata('msg_info'); ?>
    </div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>    
    <div class="alert alert-warning">
        <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
       <!--  <strong>Warning :</strong> <br> --> <?php echo $CI->session->flashdata('msg_warning'); ?>
    </div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>    
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button> 
        <!-- <strong>Error :</strong> <br> --> <?php echo $CI->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
    <?php }                    
}
/**
*    Menu Information
*/
if ( ! function_exists('upload_file')) {
    function upload_file($param = null){
        $CI =& get_instance();        
        
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|csv|jpeg|pdf|doc|docx';
        $config['max_size']    = 1024*90;
        $config['image_resize']= FALSE;
        $config['resize_width']= 126;
        $config['resize_height']= 126;
        
        if ($param){
            $config = $param + $config;
        }
        $CI->load->library('upload', $config);
        if(!empty( $config['file_name']))
            $file_Status = $CI->upload->do_upload($config['file_name']);
        else
            $file_Status = $CI->upload->do_upload();
        if (!$file_Status){
            return array('STATUS'=>FALSE,'FILE_ERROR' => $CI->upload->display_errors());            
        }else{
            $uplaod_data=$CI->upload->data();
    
            $upload_file = explode('.', $uplaod_data['file_name']);
            
            if($config['image_resize'] && in_array($upload_file[1], array('gif','jpeg','jpg','png','bmp','jpe'))){
                $param2=array(
                    'source_image'     =>    $config['source_image'].$uplaod_data['file_name'],
                    'new_image'     =>    $config['new_image'].$uplaod_data['file_name'],
                    'create_thumb'     =>    FALSE,
                    'maintain_ratio'=>    FALSE,
                    'width'         =>    $config['resize_width'],
                    'height'         =>    $config['resize_height'],
                    );
            
                image_resize($param2);
            }    
            return array('STATUS'=>TRUE,'UPLOAD_DATA' =>$uplaod_data );
        }
    }
}
/**
*    image resize
*/
if ( ! function_exists('image_resize')) {
    function image_resize($param = null){
        $CI =& get_instance();
        $config['image_library'] = 'gd2';
        $config['source_image']    = './assets/uploads/';
        $config['new_image']    = './assets/uploads/';        
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = FALSE;
        $config['width']     = 150;
        $config['height']    = 150;
        
         if ($param) {
            $config = $param + $config;
        }
        $CI->load->library('image_lib', $config); 
        if ( ! $CI->image_lib->resize())
        {
           //return array('STATUS'=>TRUE,'MESSAGE'=>$CI->image_lib->display_errors()); 
            die($CI->image_lib->display_errors());
        }else{
             return array('STATUS'=>TRUE,'MESSAGE'=>'Image resized.'); 
        }
    }
}
/**
*    image delete
*/
if ( ! function_exists('file_delete')) {
    function file_delete($param = null){
        $config['file_path']    = './assets/uploads/';
        $config['file_thumb_path']    = './assets/uploads/';        
        
        if ($param){
            $config = $param + $config;
        }
        //print_r($config); die;
        if(file_exists($config['file_path'])){
                unlink($config['file_path']);
        }
        if(file_exists($config['file_thumb_path'])){
                unlink($config['file_thumb_path']);
        }        
    }
}
/**
*    Menu Information
*/
if ( ! function_exists('get_nav_menu')) {
    function get_nav_menu($slug='',$is_location=FALSE){
        $CI =& get_instance();
        //$CI->load->model('user_model');        
        if($menu =$CI->common_model->get_nav_menu($slug,$is_location))
            return $menu;
        else
            return FALSE;
    }                    
}
/**
*    Get YouTube video ID from URL
*/
if ( ! function_exists('get_youtube_id_from_url')) {
    function get_youtube_thumbnail($youtube_url='',$alt=TRUE){
            $youtubeId = preg_replace('/^[^v]+v.(.{11}).*/', '$1', $youtube_url); 
        
        if($alt) $alt='alt="AA'.$youtubeId.'"'; else $alt='';
        return'<img style="border-radius: 0px !important; transition: none 0s ease 0s;" class="timeline-img pull-left imgsize" src="http://img.youtube.com/vi/'.$youtubeId.'/default.jpg" '.$alt.'>';
                
    }                    
} 
//for option
if ( ! function_exists('get_option_value')) {
    function get_option_value($key=FALSE){    
        $CI =& get_instance();        
        if($option = $CI->getoption->get_option_value($key))        
            return $option;
        else
            return FALSE;    
    }
}
if ( ! function_exists('file_download')) {
    function file_download($title=FALSE,$data=FALSE){
        $data=str_replace('./', '', $data);        
        $CI =& get_instance();        
        $CI->load->helper('download');
        if(!empty($title) && !empty($data)): 
            $title=url_title($title, '-', TRUE);
            if($file = file_get_contents($data)){         
            $extend=end(explode('.',$data));             
            $file_name = $title.'.'.$extend;            
            force_download($file_name, $file);
        }else{
            return FALSE;
        }
        endif;    
    }
}
if ( ! function_exists('get_post')) {
    function get_post($slug='',$is_slug=FALSE){
        $CI =& get_instance();    
        if(!empty($slug))                
            return $CI->common_model->get_post($slug,$is_slug);
        else
            return FALSE;
    }                    
}

if ( ! function_exists('gettwitterfeeds')) {
    function gettwitterfeeds(){
        $CI =& get_instance();
         //include APPPATH.'libraries/twitter/api.php';
        //$CI->api = new Api();
        $twitter_feed=$CI->api->get_user_timeline(array('screen_name' => 'test2mailer', 'count' => 1));
        if(!empty($twitter_feed)){
            echo "@".$twitter_feed[0]['text'];
            echo "<br>";            
            $timespan= explode(',',timespan( strtotime($twitter_feed[0]['created_at']), time()),2); 
            echo "<span>Posted ".$timespan[0]." ago </span>";
        }
    }
}


/**
*    thumbnail image
*/
if ( ! function_exists('create_thumbnail')) {
    function create_thumbnail($config_img='',$img_fix='') {
        $CI =& get_instance();
        $config_image['image_library'] = 'gd2';
        $config_image['source_image'] = $config_img['source_path'].$config_img['file_name'];    
        //$config_image['create_thumb'] = TRUE;
        $config_image['new_image'] = $config_img['destination_path'].$config_img['file_name'];
        if(isset($config_img['height']) && isset($config_img['width']))
        {
            $config_image['height']=$config_img['height'];
            $config_image['width']=$config_img['width'];
        }else{
            $config_image['max_height']=$config_img['max_height'];
            $config_image['max_width']=$config_img['max_width'];
        }

        
        if($img_fix){
        $config_image['maintain_ratio'] = FALSE;
        }
        else{
            $config_image['maintain_ratio'] = TRUE;
            list($width, $height, $type, $attr) = getimagesize($config_img['source_path'].$config_img['file_name']);

            if ($width < $height) {
                $cal=$width/$height;
                $config_image['width']=$config_img['width']*$cal;
            }
            if ($height < $width)
            {
                $cal=$height/$width;
                $config_image['height']=$config_img['height']*$cal;
            }
        }
        
        $CI->load->library('image_lib');
        $CI->image_lib->initialize($config_image);
        
        if(!$CI->image_lib->resize()) 
            return array('status'=>FALSE,'error_msg'=>$CI->image_lib->display_errors());
        else
            return array('status'=>TRUE,'file_name'=>$config_img['file_name']);
    }
}
/*
/**
*    get_social_url
*/
if ( ! function_exists('get_option_url')) {
    function get_option_url($option_name){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('options',array('option_name'=>$option_name)))
             return $query->option_value;
         else
             return false;
    }
}

if ( ! function_exists('slider')) {    
    function slider($status='') {
    
    $CI =& get_instance();    
        if($query = $CI->common_model->get_row('slider_images','','',array('id','desc')))
             return array('description'=>$query->slider_description,'img'=>$query->slider_image);
    }
}

if (!function_exists('get_seo_meta_tags')) {
    function get_seo_meta_tags($params=''){
        $CI =& get_instance();    
        if(!empty($params)):
            $CI->db->like('page_name',$params);
            $seometatags_query=$CI->db->get('meta_tags');                
                if($seometatags_query->num_rows()>0)
                    return $seometatags_query->row();
                else
                    return FALSE;
        else:
        
            return FALSE;

        endif;
    }        
}

if ( ! function_exists('fetch_order_status')) {    
function fetch_order_status($status='') {
    $status_array = array(
                        '1' => 'New',
                        '2' => 'Acknowledged',
                        '3'  => 'Shipped',
                        '4'  => 'On hold',
                        '5'  => 'Archived',
                        '11' => 'Pick Up',
                        '13' => 'No Artwork',
                        '14' => 'Backordered',
                        '16' => 'Printed',
                        '17' => 'No Digitizing',
                        //'19' => 'Acknowledged',
                        '20' => 'Delayed',
                        '21' =>'Split Shipped',
                        '9'  => 'Refund Order', 
                         ); 
    return element($status, $status_array);
  }
}

if ( ! function_exists('order_status_array')) {    
    function order_status_array($status='') {
        $status_array = array(
                            '1' => 'New',
                            '2' => 'Acknowledged',
                            '3' => 'Shipped',
                            '4' => 'On hold',
                            '5' => 'Archived',
                            '11'=> 'Pick Up',
                            '13'=> 'No Artwork',
                            '14'=> 'Backordered',
                            '16' => 'Printed',
                            '17' => 'No Digitizing',
                            //'19' => 'Acknowledged',
                            '20' => 'Delayed',
                            '21' =>'Split Shipped',
                            '9' => 'Refund Order',  
                             );   
        return $status_array;
    }
}
if ( ! function_exists('getRoster')) {    
    function getRoster() {
        $roster_array = array(
                            '1' => 'Name and Size Enable',
                            '2' => 'Number and Size Enable',
                            '3' => 'Name, Number and Size Enable',
                             );   
        return $roster_array;
    }
}


if ( ! function_exists('order_status_array_class')) {    
    function order_status_array_class($status='') {
        $status_array = array(
                            '1' => 'warning',
                            '2' => 'primary',
                            '3' => 'success',
                            '4' => 'danger',
                            '5' => 'info',
                            '9' => 'Refund-Order',
                            '11' => 'Pick-Up',
                            '13' => 'No-Artwork',
                            '14' => 'Backordered',
                            '16' => 'Printed',
                            '17' => 'No-Digitizing',
                            '19' => 'Acknowledged',
                            '20' => 'Delayed',
                            '21' =>'Split-Shipped',
                            
                             ); 
        return element($status, $status_array);
    }
}

if ( ! function_exists('fetch_status_symbol')) {    
    function fetch_status_symbol($status='') {
            $status_array = array(
                            '1'  => 'fa fa-clock-o',
                            '2'  => 'fa fa-exchange',
                            '3'  => 'fa fa-truck',
                            '4'  => 'fa fa-circle-o',
                            '5'  => 'fa fa-check-square',
                            '11' => 'fa fa-share-square',
                            '13' => 'fa fa-times-circle-o',
                            '14' => 'fa fa-arrow-circle-o-left',
                            '16' => 'fa fa-print',
                            '17' => 'fa fa-circle',
                            '19' => 'fa fa-star-half-o',
                            '20' => 'fa fa-asterisk',
                            '21' => 'fa fa-columns',
                            '9'  => 'fa fa-bars' 
                             ); 
            return element($status, $status_array);
    }
}
if ( ! function_exists('slider_position_left')) {    
    function slider_position_left($status='') {
        $status_array = array(
                            '1' => '10',
                            '2' => '15',
                            '3' => '20',
                            '4' => '25',                           
                            '5' => '30',
                            '6' => '35',
                            '7' => '40',
                             ); 
        return $status_array;
    }
}
if ( ! function_exists('slider_position_left_class')) {    
    function slider_position_left_class($status='') {
        $status_array = array(
                               '1' => '10',
                            '2' => '15',
                            '3' => '20',
                            '4' => '25',                           
                            '5' => '30',
                            '6' => '35',
                            '7' => '40',
                             ); 
        return element($status, $status_array);
    }
}

if ( ! function_exists('slider_position_top')) {    
    function slider_position_top($status='') {
        $status_array = array(
                            '1' => 'first',
                            '2' => 'second',
                            '3' => 'third',
                            '4' => 'fourth',
                             ); 
        return $status_array;
    }
}

if ( ! function_exists('slider_position_top_class')) {    
    function slider_position_top_class($status='') {
        $status_array = array(
                           '1' => 'first',
                            '2' => 'second',
                            '3' => 'third',
                            '4' => 'fourth',
                             ); 
        return element($status, $status_array);
    }
}
if ( ! function_exists('get_product_size_name')) {
function get_product_size_name($product_id='',$id=''){
    $CI =& get_instance();
    $query = $CI->common_model->get_row('product_size_price',array('product_id'=>$product_id,'id'=>$id),array('size_name'));
    if($query)
    return $query->size_name;
    
    }
}
if ( ! function_exists('get_product_size_price')) {
function get_product_size_price($product_id='',$size_id=''){
    $CI =& get_instance();
    $query = $CI->common_model->get_row('product_size_price',array('product_id'=>$product_id,'size_id'=>$size_id));
    if($query)
    return $query->price;
    
    }
}
if ( ! function_exists('get_product_size_price_details')) {
function get_product_size_price_details($product_id='',$id=''){
    $CI =& get_instance();
    $query = $CI->common_model->get_row('product_size_price',array('product_id'=>$product_id,'id'=>$id));
    if($query)
        return $query;
    else
    return false;
}
}
if ( ! function_exists('get_product_size')) {
    function get_product_size($product_id=''){
        $CI =& get_instance();
        return  $query = $CI->common_model->get_result('product_size_price',array('product_id'=>$product_id));
    }
}
if ( ! function_exists('get_product_size_price_check')) {
    function get_product_size_price_check($product_id='',$size_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('product_size_price',array('product_id'=>$product_id,'size_id'=>$size_id));
        if($query)
        return $query;
        
    }
}

if ( ! function_exists('get_product_image_default')) {
    function get_product_image_default($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('product_colors',array('product_id'=>$product_id),array(),array('id','RANDOM'));
        if($query)
        return $query->main_image_thumbnail;
    else
        return false;
        
    }
}

if ( ! function_exists('get_store_category_slug_info')) {
    function get_store_category_slug_info($slug){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category',array('category_slug'=>$slug,'registration_subscriber'=>3)))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_store_category_info')) {
    function get_store_category_info($store_category_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category',array('id'=>$store_category_id)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_sub_category_type')) {
    function get_sub_category_type($store_category_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category_search',array('sub_category_id'=>$store_category_id)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_main_category')) {
    function get_product_main_category(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_main_category',array('status'=>1),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_category')) {
    function get_product_category(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_category',array('status'=>1),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_sub_category')) {
    function get_product_sub_category(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_sub_category',array('status'=>1),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}


if ( ! function_exists('get_product_category')) {
    function get_product_category($main_category_id=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_category',array('status'=>1,'product_main_category_id'=>$main_category_id ),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_product_category_menu')) {
    function get_product_category_menu($main_category_id=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_category',array('status'=>1,'product_main_category_id'=>$main_category_id ),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_product_sub_category')) {
    function get_product_sub_category($main_category_id='',$category_id=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('product_sub_category',array('status'=>1,'category_id'=>$main_category_id,'category_sub_id'=>$category_id ),array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_category')) {
    function get_store_category($s1=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category',array('category_slug'=>$s1,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_category_subscriber')) {
    function get_store_category_subscriber(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category',array('registration_subscriber'=>1,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_sub_category')) {
    function get_store_sub_category($s2=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_sub_category',array('store_sub_category_slug'=>$s2,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_category_search')) {
    function get_store_category_search($s3=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category_search',array('category_slug'=>$s3,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_category_search_fourth')) {
    function get_store_category_search_fourth($s4=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_sub_category_fourth',array('category_slug'=>$s4,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_random_design')) {
    function get_random_design($category_id='',$product_id='',$stores_design_allowed='',$store_id='',$get_random_design_result='',$design_type='',$productcolor_id='',$where_not='',$status='',$uniform=0){    
        // this design is not allow to product $where_not
        
        $CI =& get_instance();        
         if($query = $CI->common_model->get_random_design($category_id,$product_id,$stores_design_allowed,$store_id,$get_random_design_result,$design_type,$where_not,$status,$uniform))
         {     
            
            if(($query->custome_art_color!='' || $query->custome_secondaryart_color!='' || $query->custome_terniaryart_color!='') && $productcolor_id!='')
            {
                $product_color_name=$CI->common_model->get_row('product_colors',array('id'=>$productcolor_id),array('color_name','color_code'));

                $color=array();
                $color1=array();
                $color2=array();

                if($query->custome_art_color!='')
                {
                $color= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_art_color));
                }

                if($query->custome_secondaryart_color!='')
                {
                    $color1= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_secondaryart_color));
                }

                if($query->custome_terniaryart_color!='')
                {
                    $color2= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_terniaryart_color));
                }
                

                if(!empty($product_color_name) && (!empty($color) || !empty($color1) || !empty($color2)))
                {
                    $color_names = array();
                    $color_names1 = array();
                    $color_names2 = array();
                    $i=1;
                    if(!empty($color)){
                        $color_names     = unserialize($color->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names))
                            $i=1;
                        else
                            $i=0;            
                    }
                    $j=1;
                    if(!empty($color1)){
                        $color_names1     = unserialize($color1->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names1))
                            $j=1;
                        else
                            $j=0;    
                    }
                    $k=1;
                    if(!empty($color2)){
                        $color_names2     = unserialize($color2->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names2))
                            $k=1;
                        else
                            $k=0;        
                    }

                    //$temp_color_names = array_merge($color_names,$color_names1,$color_names2);
                    if($i==1 && $j==1 && $k==1){
                        return $query;     
                    }else{
                        $where_not[]=$query->id;
                        $result=get_random_design1($category_id,$product_id,$stores_design_allowed,$store_id,$get_random_design_result,$design_type,$productcolor_id,$where_not,$status,$uniform);
                        if($result)
                            return $result;
                        else 
                            return false;
                    }
                }else{
                    return $query;
                }
            }else
            {
                return $query;
            }
         }else
             return false;
    }
}

if ( ! function_exists('get_random_design1')) {
    function get_random_design1($category_id='',$product_id='',$stores_design_allowed='',$store_id='',$get_random_design_result='',$design_type='',$productcolor_id='',$where_not='',$status='',$uniform=0){    
        // this design is not allow to product $where_not
        
        $CI =& get_instance();        
         if($query = $CI->common_model->get_random_design($category_id,$product_id,$stores_design_allowed,$store_id,$get_random_design_result,$design_type,$where_not,$status,$uniform))
         {     
            
            if(($query->custome_art_color!='' || $query->custome_secondaryart_color!='' || $query->custome_terniaryart_color!='') && $productcolor_id!='')
            {

                $product_color_name=$CI->common_model->get_row('product_colors',array('id'=>$productcolor_id),array('color_name','color_code'));

                $color=array();
                $color1=array();
                $color2=array();

                if($query->custome_art_color!='')
                {
                $color= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_art_color));
                }

                if($query->custome_secondaryart_color!='')
                {
                    $color1= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_secondaryart_color));
                }

                if($query->custome_terniaryart_color!='')
                {
                    $color2= $CI->common_model->get_row('color_palette',array('color_code_rgb'=>$query->custome_terniaryart_color));
                }

                if(!empty($product_color_name) && (!empty($color) || !empty($color1) || !empty($color2)))
                {

                    $color_names = array();
                    $color_names1 = array();
                    $color_names2 = array();

                    $i=1;
                    if(!empty($color)){
                        $color_names     = unserialize($color->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names))
                            $i=1;
                        else
                            $i=0;            
                    }
                    $j=1;
                    if(!empty($color1)){
                        $color_names1     = unserialize($color1->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names1))
                            $j=1;
                        else
                            $j=0;    
                    }
                    $k=1;
                    if(!empty($color2)){
                        $color_names2     = unserialize($color2->allowed_color);
                        if(in_array($product_color_name->color_name, $color_names2))
                            $k=1;
                        else
                            $k=0;        
                    } 
                    //$temp_color_names = array_merge($color_names,$color_names1,$color_names2);
                    if($i==1 && $j==1 && $k==1){
                        return $query;     
                    }else{
                        $where_not[]=$query->id;
                        $result = get_random_design1($category_id,$product_id,$stores_design_allowed,$store_id,$get_random_design_result,$design_type,$productcolor_id,$where_not,$status,$uniform);
                        if($result)
                            return $result;
                        else 
                            return false;
                    }
                }else{
                    return $query;
                }
            }else
            {
                return $query;
            }
         }else
             return false;
    }
}

if ( ! function_exists('location_menu')) {
    function location_menu(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('location'))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('rgb2html')) {
function rgb2html($r, $g=-1, $b=-1)
{
    $CI =& get_instance();    
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return '#'.$color;
}
}

if ( ! function_exists('get_color_plate')) {
    function get_color_plate(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('color_palette'))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_sub_category_by_id')) {
    function get_store_sub_category_by_id($store_category_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_sub_category',array('store_category_id'=>$store_category_id,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_sub_category_by_id_spec')) {
    function get_store_sub_category_by_id_spec($store_category_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_sub_category',array('store_category_id'=>$store_category_id,'status'=>1),array('store_sub_category_slug','store_sub_category_title'),array('order','asc')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_design_sub_category')) {
    function get_design_sub_category($design_category_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('design_sub_category',array('design_category_id'=>$design_category_id,'status'=>1),array(),array('design_sub_category_title','ASC')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_color_price_through_product_id')) {
    function get_product_color_price_through_product_id($product_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_colors',array('id'=>$product_id)))

             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_design_info')) {
    function get_design_info($design_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('designs',array('id'=>$design_id),array('enable_string','enable_year','enable_number','enable_line1','enable_line2','design_title')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_design_enable_line1')) {
    function get_design_enable_line1($design_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('designs',array('id'=>$design_id),array('enable_line1')))
             return $query->enable_line1;
         else
             return false;
    }
}
if ( ! function_exists('get_design_enable_line2')) {
    function get_design_enable_line2($design_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('designs',array('id'=>$design_id),array('enable_line2')))
             return $query->enable_line2;
         else
             return false;
    }
}
if ( ! function_exists('get_design_price')) {
    function get_design_price($design_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('designs',array('id'=>$design_id),array('base_price')))
             return $query->base_price;
         else
             return false;
    }
}
if ( ! function_exists('get_design_color')) {
    function get_design_color($design_id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('designs',array('id'=>$design_id),array('color_status')))
             return $query->color_status;
         else
             return 0;
    }
}
if ( ! function_exists('get_colors')) {
    function get_colors(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('color_palette',array(),array(),array('color_name','ASC')))

             return $query;
         else
             return false;
    }
}

if ( ! function_exists('store_category_menu')) {
    function store_category_menu(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category',array(),array(),array('registration_subscriber','ASC')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('store_category_main_menu')) {
    function store_category_main_menu($type=''){    
        $CI =& get_instance();    
        if($type){
        $where=array('status'=>1,'registration_subscriber'=>2);    }
        else{
            $where=array('status'=>1);
        }
         if($query = $CI->common_model->get_result('store_category',$where,array(),array('order_by','asc')))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_main_category_name')) {
    function get_product_main_category_name($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_main_category',array('status'=>1,'id'=>$id)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_category_name')) {
    function get_product_category_name($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_category',array('status'=>1,'id'=>$id)))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_product_details_invoice')) {
    function get_product_details_invoice($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('products',array('id'=>$id),array('product_item_no','main_category_id','category_id','sub_category_id','product_brand','design_type_id','product_supplier')))
             return $query;
         else
             return false;
    }
}
if(! function_exists('getProductCategoryname'))
{
    function getProductCategoryname($id='')
    {
        $CI =& get_instance();        
        $CI->db->select('pcm.category_name,pcs.category_name as sub,psc.sub_category_name');
        $CI->db->from('products as p');
        $CI->db->join('product_main_category as pcm','pcm.id=p.main_category_id','left');
        $CI->db->join('product_category as pcs','pcs.id=p.category_id','left');
        $CI->db->join('product_sub_category as psc','psc.id=p.sub_category_id','left');
        $CI->db->where('p.id',$id);
        $query = $CI->db->get();
        if($query->num_rows()>0)
        {
            $result=$query->row();
            return $result->category_name.' '.$result->sub.' '.$result->sub_category_name;
        }else
            return '';
        
    }
}
if ( ! function_exists('get_product')) {
    function get_product($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('products',array('id'=>$id)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_sub_category_name')) {
    function get_product_sub_category_name($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_sub_category',array('status'=>1,'id'=>$id)))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_store_sub_category_row_by_id')) {
    function get_store_sub_category_row_by_id($s2=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_sub_category',array('id'=>$s2)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('publish_store_category_main_menu')) {
function publish_store_category_main_menu(){    
$CI =& get_instance();    
if($query = $CI->common_model->get_result('store_category',array('status'=>1,'registration_subscriber'=>1)))
    return $query;
else
    return false;
 }
}

if ( ! function_exists('get_store_category_promo_text')) {
    function get_store_category_promo_text($s3=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category',array('category_slug'=>$s3)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_unread_msg')) {
    function get_unread_msg($message_id=''){    
        $CI =& get_instance();        
         if($query = $CI->account_model->get_unread_msg($message_id))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_unread_msg_superadmin')) {
    function get_unread_msg_superadmin($message_id=''){    
        $CI =& get_instance();        
         if($query = $CI->superadmin_model->get_unread_msg($message_id))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_msg_count')) {
    function get_msg_count($table_name='',$status=''){    
        $CI =& get_instance();        
         if($query = $CI->account_model->get_msg_count($table_name='',$status))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_product_color_image')) {
    function get_product_color_image($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_random_product_color('product_colors',array('product_id'=>$product_id,'status'=>1),array(),array('order_by','ASC'));
        if($query)
        return $query;
    else
        return false;
        
    }
}
if ( ! function_exists('get_color_image')) {
    function get_color_image($color_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('product_colors',array('id'=>$color_id,'status'=>1));
        if($query)
        return $query;
    else
        return false;
        
    }
}

if ( ! function_exists('get_product_color')) {
    function get_product_color($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_result('product_colors',array('product_id'=>$product_id,'status'=>1),array(),array('order_by','ASC'));

        if($query)
        return $query;
    else
        return false;
        
    }
}

if ( ! function_exists('get_product_color_bulk')) {
    function get_product_color_bulk($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_result('product_colors',array('product_id'=>$product_id,'status'=>1),array(),array('order_by','ASC'));

        if($query)
        return $query;
    else
        return false;
        
    }
}

if ( ! function_exists('product_color_image')) {
    function product_color_image($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_colors',array('id'=>$id)))

             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_admin_name_by_id')) {
    function get_store_admin_name_by_id($user_id=''){
        $CI =& get_instance();
        
        if($user_info = $CI->common_model->get_row('users', array('id'=>$user_id)))
             return $user_info;
        else
            return FALSE;
    }                    
}

if ( ! function_exists('get_blank_design_by_cat')) {
    function get_blank_design_by_cat($store_id=''){
        $CI =& get_instance();
        
        if($design_info = $CI->common_model->get_row('designs', array('store_category_id'=>$store_id,'no_design_on_product'=>1,'status'=>'1'),array('id','base_price'),array('id','desc')))
             return $design_info;
        else
            return FALSE;
    }                    
}



if ( ! function_exists('get_bulk_product_size_price_check')) {
    function get_bulk_product_size_price_check($product_id='',$size_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('bulk_product_size_price',array('product_id'=>$product_id,'size_id'=>$size_id));
        if($query)
        return $query;
        
    }
 }

  if ( ! function_exists('get_bulk_product_image_default')) {
    function get_bulk_product_image_default($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('bulk_product_colors',array('product_id'=>$product_id),array(),array('id','RANDOM'));
        if($query)
        return $query->main_image_thumbnail;
    else
        return false;
        
    }
}

if ( ! function_exists('bulk_product_color_image')) {
    function bulk_product_color_image($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('product_colors',array('id'=>$id)))

             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_bulk_product_color_image')) {
    function get_bulk_product_color_image($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('product_colors',array('product_id'=>$product_id,'status'=>1),array(),array('order_by','ASC'));
        if($query)
        return $query;
    else
        return array();
        
    }
}

if ( ! function_exists('design_enabling_fields')) {
    function design_enabling_fields($design_id='',$uniform=0){
        $CI =& get_instance();
        $query = $CI->common_model->get_row('designs',array('id'=>$design_id,'status'=>1,'uniform_design'=>$uniform),array('limittoset_line1','limittoset_line2','enable_line1','enable_line2','enable_string','enable_year','enable_number'));
        if($query)
        return $query;
    else
        return false;
        
    }
}
if ( ! function_exists('get_page_banner')) {    
    function get_page_banner($page_id='') {    
    $CI =& get_instance();    
      if($query = $CI->common_model->get_row('sub_page_banners',array('page_id'=>$page_id,'status'=>1),'',array('id','DESC')))
             return $query;
    }
}

if ( ! function_exists('get_store_info')) {
    function get_store_info($store_id=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('stores',array('id'=>$store_id),array('line1','line2','store_title','store_link','id','store_category_id','store_logo_image','store_slogan','store_type','is_bulk','is_affiliate','store_address','store_city','store_state','store_zip','store_country','user_id','is_company','store_email')))   
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_store_info_slug')) {
    function get_store_info_slug($store_slug=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('stores',array('store_link'=>$store_slug),array('id','line1','line2','store_title','store_link','store_category_id','store_logo_image','store_type','is_bulk','is_affiliate','shipping_address_type')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_store_commission')) {
    function get_store_commission($store_slug='',$store_id=''){    
        $store=array();
        if($store_slug!='')
            $store['store_link']=$store_slug;
        if($store_id!='')
            $store['id']=$store_id;

        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('stores',$store,array('id','store_commission','store_commissions_status')))
         {
             if($query->store_commissions_status==0)
                 return $query->store_commission;
             else
                 return 0;    

         }
         else
             return 0;
    }
}
if ( ! function_exists('get_store_commission_amt')) {
    function get_store_commission_amt($store_id='',$code='',$product_id=''){    
        $store=array();
        if($store_id!='')
            $store['id']=$store_id;

        $CI =& get_instance();    
        if(get_option_value('STORE_COMMISSION_STATUS')){
            $sliding_scale_commssions=1;
            $commissions=0;
            if($code!='' && $coupons_info = $CI->common_model->get_row('coupons',array('code'=>$code)))
            {
                if($coupons_info->store_commissions_status==0)
                     return 0;
                if($coupons_info->slid_scale_commissions==0)
                     $sliding_scale_commssions=0;
                if($coupons_info->reduction_type==1)
                    $commissions=$coupons_info->reduction_amount;      
            }
            if($query = $CI->common_model->get_row('stores',$store,array('id','store_commission','store_commissions_status')))    
            {
                //$commissions=0;
                if($product_id!='' && $query->store_commissions_status)
                        $commissions+=$CI->common_model->get_product_disccount($product_id);
                    
                if($commissions>0 && $query->store_commissions_status && get_option_value('SLIDING_SCALE_COMMISSIONS')>0 && $sliding_scale_commssions>0){
                    if($commissions>=15)
                        return get_option_value('SCALING_COMMISSION_PERCENTAGES_15%+');
                    else
                        return get_option_value('SCALING_COMMISSION_PERCENTAGES_1-14%');
                    
                }else if($query->store_commissions_status)
                     return $query->store_commission;
                 else
                     return 0;    
            }
             else
                 return 0;
        }else
            return 0;
    }
}

if ( ! function_exists('get_order_store_info')) {
    function get_order_store_info($store_id=''){    
        $CI =& get_instance();        
        $store_id=explode(',',str_replace('#','',$store_id)); 
        $result = $CI->db->select('id,store_title')->where_in('id',$store_id)->get('stores')->result();    
        if(!empty($result))
        {
            $store_name=array();
            foreach($result as $row)
                $store_name[]=$row->id.'  '.$row->store_title.' ';
                return implode(',',$store_name);
        }else
             return false;
    }
}
if ( ! function_exists('convert_weight')) {
    function convert_weight($current_unit=''){    
        $CI =& get_instance();
        $multiply_by=1;        

         if($current_unit=='gm'){
             $multiply_by='1';
         }
         elseif($current_unit=='lb'){
             $multiply_by='453.59';
         }
         elseif($current_unit=='oz'){
             $multiply_by='28.349';
         }else{
             $multiply_by='1000';
         }
         return $multiply_by;
    }
}

if ( ! function_exists('check_bulk_discount')) {
    function check_bulk_discount(){    
        $CI =& get_instance();

        $total_bulk_discount=0;
        /* if($cart_item=$CI->cart->contents()){

            $product_id=array();
            $qty=array();
            $sub_total=array();
            foreach ($CI->cart->contents() as $items){ 
                $product_id[]=$items['options']['product_id'];
                $tqty[]=$items['qty'];
                $tsub_total[] = $items['price'] * $items['qty']; 
            }

            $create_array=array();
            foreach ($product_id as $value) {
                $qty=0;
                $sub_total=0;
                if(!in_array($value,$create_array)){
                    for ($i=0; $i < count($product_id); $i++) { 
                        if($product_id[$i] == $value){
                            $qty=$tqty[$i]+$qty;
                            $sub_total=$tsub_total[$i]+$sub_total;
                            $p_id=$value;
                        }
                    }
                    if($check_qty=$CI->common_model->check_qty_exit($p_id,$qty)){
                        $pecentage=($check_qty->discount_percentage)/100;
                        $discountof=$sub_total * $pecentage;
                        $total_bulk_discount=$total_bulk_discount + $discountof;
                        $total_bulk_discount=$total_bulk_discount;
                    }
                  }
                $create_array[]=$value;
            }} */
            return $total_bulk_discount;
    }
}


if ( ! function_exists('check_shipping_api')) {
    function check_shipping_api(){    
        $CI =& get_instance();

        $shipping_api='Canada Post/Purolator/UPS';
        $total_wight='';
        if($cart_item=$CI->cart->contents()){
            
            foreach($CI->cart->contents() as $items){ 
                $product_id=$items['options']['product_id'];
                $product=$CI->common_model->get_row('products',array('id'=>$product_id),array('weight','weight_unit'));
                $product_weight=$product->weight * $items['qty'];
                $total_wight= $product_weight + $total_wight;
              }
            }
            if($total_wight >='900'){
                $shipping_api='Canada Post/Purolator/UPS';
            }
            return $shipping_api;
        }
    }


if ( ! function_exists('get_shipping_rates')) {
    function get_shipping_rates($qty='',$province=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->shipping_rates($qty,$province))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_auto_shipping_rates')) {
    function get_auto_shipping_rates($cart_total=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->auto_shipping_rates($cart_total))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('get_store_categories')) {
    function get_store_categories(){
        $CI =& get_instance();    
        // $query = $CI->common_model->get_result('store_category',array(),array(),array('registration_subscriber','desc'));    
         if($query = $CI->common_model->get_result_order('store_category',array(),array(),array('registration_subscriber','asc')))
         {
             return $query;
         }else
             return false;
    }    
}

if ( ! function_exists('get_total_counting')) {
    function get_total_counting($table_name='',$field_name ='',$status=''){    
        $CI =& get_instance();    
         if($query=$CI->db->query('SELECT count(*) as total_rows FROM '.$table_name.' WHERE `'.$field_name.'` = '.$status)) 
             return $query->row();
         else
             return 0;
    }    
}
if ( ! function_exists('get_total_counting_support')) {
    function get_total_counting_support($table_name='',$field_name ='',$status=''){    
        $CI =& get_instance();    
         if($query=$CI->db->query('SELECT count(*) as total_rows FROM '.$table_name.' WHERE `'.$field_name.'` = '.$status.' && parent_id=0')) 
             return $query->row();
         else
             return 0;
    }    
}
if ( ! function_exists('get_total_design_counting')) {
    function get_total_design_counting($table_name='',$field_name ='',$status=''){    
        $CI =& get_instance();        
         if($query=$CI->db->query('SELECT count(*) as total_rows FROM '.$table_name.' WHERE status=0 AND store_id > 0')) 
             return $query->row();
         else
             return false;
    }    
}

if ( ! function_exists('get_all_product_color_image')) {
    function get_all_product_color_image($product_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_result('product_colors',array('product_id'=>$product_id),array(),array('order_by','ASC'));
    if($query)
        return $query;
    else
        return false;
    }
  }


if ( ! function_exists('commission_status_array')) {    
    function commission_status_array($status='') {
        $status_array = array(
                            '1' => 'In Balance',
                            '3' => 'Paid',                            
                             ); 
        return $status_array;
    }
}

if ( ! function_exists('fetech_commission_status_array')) {    
function fetech_commission_status_array($status='') {
    $status_array = array(
                        '1' => 'In Balance',
                        '2' => 'In Process',
                        '3' => 'Paid',
                         ); 
    return element($status, $status_array);
  }
}
if ( ! function_exists('get_store_category_search_fourth_id')) {
    function get_store_category_search_fourth_id($id=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_sub_category_fourth',array('sub_category_type_id'=>$id,'status'=>1)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('check_store_id')) {
    function check_store_id($store_id=''){    
        $user_id=store_admin_id();
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('stores',array('id'=>$store_id,'user_id'=>$user_id),array('id')))
             return $query;
         else
             return false;
    }
}


if ( ! function_exists('page_name_array')) {    
    function page_name_array($status='') {
        $status_array = array(
                            
                            '1' => 'Shop Product Details',
                            '2' => 'Shop Product List',
                            '3' => 'Product List',
                            '4' => 'Product Details',
                            '5' => 'Terms & Conditions',
                            '6' => 'Privacy Policy',
                            '7' => 'Signup',
                            '8' => 'Front Home Page',
                            '9' => 'Bulk order',
                            '10'=>'Quick Quote',
                            '11'=>'Cart login',
                            '12'=>'Shipping And Billing',
                            '13'=>'Order Overview',
                            '14'=>'Cart',
                            '15'=>'Shop Category',
                            /* '3' => 'Sizing for Garments',  
                             '4' => 'Bulk Order FAQ',                             
                             '5' => 'About US',  
                             '6' => 'Contact Us',   
                             '5' => 'About US',  
                             '6' => 'Contact Us',  
                             '5' => 'About US',  
                             '6' => 'Contact Us',  
                             '5' => 'About US',  
                             '6' => 'Contact Us',  
                             '5' => 'About US',  
                             '6' => 'Contact Us',   */
                             
                             ); 
        return $status_array;
    }
}

if ( ! function_exists('fetech_page_name_array')) {    
function fetech_page_name_array($status='') {
    $status_array = array(
                           
                            '1' => 'Product Details',
                            '2' => 'Shop Product List',
                            '3' => 'Product List',
                            '4' => 'Product Details',
                            '5' => 'Terms & Conditions',
                            '6' => 'Privacy Policy',
                            '7' => 'Signup',
                            '8' => 'Front Home Page',
                            '9' => 'Bulk order',
                            '10'=>'Quick Quote',
                            '11'=>'Cart login',
                            '12'=>'Shipping And Billing',
                            '13'=>'Order Overview',
                            '14'=>'Cart',
                            '15'=>'Shop Category',
                            // '2' => 'Item List',
                            // '3' => 'Item detail',  
                            // '4' => 'Post an Item',                             
                            // '5' => 'About US',  
                            // '6' => 'Contact Us',                             
                         ); 
    return element($status, $status_array);
  }
}

   if(! function_exists('get_pagenames')){
          function get_pagenames($id){
          $CI = & get_instance();
           if($query = $CI->common_model->get_row('meta_tags',array('page_id'=>$id)))
             return $query;
         else
             return false;
          }
   }


if ( ! function_exists('menu_section')) {    
    function menu_section($status='') {
        $status_array = array(
                            '1' => 'Customer Support Section',
                            '2' => 'Company Section',
                            '3' => 'Short link Section',
                            '4' => 'Affiliate Footer',
                             ); 
        return $status_array;
    }
}

if ( ! function_exists('menu_section_class')) {    
    function menu_section_class($status='') {
        $status_array = array(
                           '1' => 'Customer Support Section',
                            '2' => 'Company Section',
                            '3' => 'Short link Section',
                            '4' => 'Affiliate Footer',
                            
                             ); 
        return element($status, $status_array);
    }
}

if ( ! function_exists('menu_section_color')) {    
    function menu_section_color($status='') {
        $status_array = array(
                              '1' => 'customer_section',
                            '2' => 'company_section',
                            '3' => 'short_link_section',
                            '4' => 'Affiliate Footer',
                             ); 
        return element($status, $status_array);
    }
}

if ( ! function_exists('get_footer_menu')) {
    function get_footer_menu($section=''){
        $CI =& get_instance();
            $query = $CI->common_model->get_result('menu_footer',array('menu_section'=>$section,'status'=>1),array(),array('order','ASC'));
        if($query)
            return $query;
        else
            return false;

    }
}

if ( ! function_exists('get_buyer_info')) {
    function get_buyer_info($user_id=''){
        $CI =& get_instance();
            $query = $CI->common_model->get_row('users',array('id'=>$user_id),array('first_name,last_name,contact_title'),array());

        if($query)
            return $query;
        else
            return false;

    }
}
if ( ! function_exists('get_shipping_automative')) {
    function get_shipping_automative(){
        $CI =& get_instance();
            $query = $CI->common_model->get_row('shipping_automative',array('id'=>1,'status'=>1),array(),array());

        if($query)
            return $query;
        else
            return false;

    }
}
if ( ! function_exists('get_promo_code_orderid')) {
    function get_promo_code_orderid($code){
        $CI =& get_instance();
            $query = $CI->common_model->get_row('orders',array('discount_code'=>$code),array('order_id'));
        if($query)
            return $query->order_id;
        else
            return false;
    }
}

if ( ! function_exists('get_static_page_data')) {
    function get_static_page_data($table='', $slug=''){
        $CI =& get_instance();
            $query = $CI->common_model->get_row($table,array('page_slug'=>$slug,'status'=>1));
        if($query)
            return $query;
        else
            return false;

    }
}

if ( ! function_exists('feedback_subject')) {    
    function feedback_subject($status='') {
        $status_array = array(
                                '1' => 'General',
                                /* '2' => 'Dashboard Support',
                                '3' => 'Storefront Support', */
                                '4' => 'Product / Design Selection',
                                /* '5' => 'Designs',
                                '6' => 'Payments and Rates', */  
                                /* '7' => 'Bulk Orders', 
                                '8' => 'Fundraiser Campaigns',*/ 
                                '9' => 'Freight / Shipping',
                                '10' => 'Order info',
                                '11' => 'Request Flyer', 
                                '12' => 'Commissions', 
                                '13' => 'Group Order', 
                                '14' => 'Other',
                                '15' => 'Free Demo', 
                                '16' => 'Store', 
                                '17' => 'Order Details',
                                '18' => 'Products', 
                                '19'=>'Decoration Info',
                                
                             ); 
        return $status_array;
    }
}

if ( ! function_exists('feedback_subject_status')) {    
    function feedback_subject_status($status='') {
        $status_array = array(
                              '1' => 'General',
                                /* '2' => 'Dashboard Support',
                                '3' => 'Storefront Support', */
                                '4' => 'Product / Design Selection',
                                /* '5' => 'Designs',
                                '6' => 'Payments and Rates', */  
                                /* '7' => 'Bulk Orders', 
                                '8' => 'Fundraiser Campaigns',*/ 
                                '9' => 'Freight / Shipping',
                                '10' => 'Order info',
                                '11' => 'Request Flyer', 
                                '12' => 'Commissions', 
                                '13' => 'Group Order', 
                                '14' => 'Other', 
                                '15' => 'Free Demo',
                                '16' => 'Store', 
                                '17' => 'Order Details',
                                '18' => 'Products', 
                                '19'=>'Decoration Info', 
                            
                             );
        if($status=='all')
            return $status_array;
        else
        return element($status, $status_array);
    }
}

if(!function_exists('default_design_array')){
    function default_design_array()
    {
        return array(
        'background_width'    =>  232,
        'background_height'   =>  232,
        'background_type'     =>  1,
        'background_color'    =>  '255, 255, 255',
        'design_size'         =>  1,
        'design_left'         =>  1,
        'design_top'          =>  1,
        'design_rotate_angle' =>  0,
        'design_size_1'         =>  0.80,
        'design_left_1'         =>  5,
        'design_top_1'          =>  30,
        'design_rotate_angle_1' =>  0,
        'design_color_1'        =>  2,
        'placement'           =>1,
        'text1'               =>  'STORE LINE 1',
        'text1_size'          =>  20,
        'text1_left'          =>  0,
        'text1_top'           =>  57,
        'text1_font_file'     =>  'PAPL.ttf',
        'text1_arc_angle'     =>  0,
        'text1_angle'         =>  0,
        'text1_type'          =>  2,
        'text1_limit'         =>  20,
        'text2'               =>  'STORE LINE 2',
        'text2_size'          =>  20,
        'text2_left'          =>  0,
        'text2_top'           =>  91,
        'text2_font_file'     =>  'batmfa__ copy.ttf',
        'text2_arc_angle'     =>  0,
        'text2_angle'         =>  0,
        'text2_type'          =>  2,
        'text2_limit'         =>  20,
        'text3'               =>  'STORE LINE 3',
        'text3_size'          =>  35,
        'text3_left'          =>  0,
        'text3_top'           =>  135,
        'text3_font_file'     =>  'PAPL.ttf',
        'text3_arc_angle'     =>  0,
        'text3_angle'         =>  0,
        'text3_type'          =>  2,
        'text3_limit'         =>  20,
        'text4'               =>  'STORE LINE 4',
        'text4_size'          =>  58,
        'text4_left'          =>  0,
        'text4_top'           =>  181,
        'text4_font_file'     =>  'PAPL.ttf',
        'text4_arc_angle'     =>  0,
        'text4_angle'         =>  0,
        'text4_type'          =>  2,
        'text4_limit'         =>  20,
        'secondary_color'     =>  '11,83,148',      
        'design_center'       =>  1,
        'primary_color'       =>  '255,153,0',
        'design_color'        =>  1,
        'text1_border'        =>  0,
        'text2_border'        =>  0,
        'text3_border'        =>  0,
        'text4_border'        =>  0,
        'text1_center'        =>  1,
        'text2_center'        =>  1,
        'text3_center'        =>  1,
        'text4_center'        =>  1,
        'text1_color'         =>  1,
        'text2_color'         =>  1,
        'text3_color'         =>  1,
        'text4_color'         =>  1,
        );
    }
}

if(!function_exists('user_status')){
    function user_status($status=''){
        $status_array= array(
            '1' => 'Active',
            '2' => 'Deactive',
            '3' => 'Banned',/*
            '4' => 'Pending' */            
            );
        return $status_array;
     }
}


if(!function_exists('create_banner_image')){
    function create_banner_image($banner_array=array()){
        
        print_r($banner_array);
        die();
        $curl_handle=curl_init();

      curl_setopt($curl_handle,CURLOPT_URL,base_url('stores/createbanner'));
      curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
      curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);

        $fields_string = http_build_query($banner_array);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

      $buffer = curl_exec($curl_handle);
      curl_close($curl_handle);
          

        return $buffer;
     }
}

if ( ! function_exists('dateDiff')) {
    function dateDiff($start=0, $end=0, $type=''){    
    $CI =& get_instance();    
    $start_ts = strtotime($start); 
    $end_ts = strtotime($end); 
    $diff = $end_ts - $start_ts; 
    $total_days = round($diff / 86400);
        if($type=='day'){
        return round($diff / 86400);
        }
        if($type=='week'){ 
        return round($total_days / 7);
        }
        if($type=='month'){ 
        return round($total_days / 30);
        }
    }
}


if ( ! function_exists('all_user_email')) {
function all_user_email(){
    $CI =& get_instance();
    $query = $CI->common_model->get_result('users',array('user_role'=>1),array('email,first_name,last_name'));
    if($query)
        return $query;
    else
        return false;
    }
}


 if ( ! function_exists('get_notification_type')) {
    function get_notification_type(){    
    $CI =& get_instance();    
    if($query = $CI->common_model->get_result(' notification_type   '))
        return $query;
    else
        return false;
    }
 }
    if ( ! function_exists('get_design_title')) {
        function get_design_title($id=''){

            $CI =& get_instance();
            $design_title = $CI->common_model->get_row('design_type',array('id'=>$id)); 
                if($design_title)
                    return $design_title->design_type;
                else
                    return '';            
            }
        }
    

    if ( ! function_exists('blog_status_array')) {    
        function blog_status_array($status='') {
            $status_array = array(
                '0' => 'All',
                '2' => 'Active',
                '1' => 'Deactive'
            ); 
            return $status_array;
        }
    }

    if ( ! function_exists('get_blog_categories')) {
        function get_blog_categories(){    
            $CI =& get_instance();        
             if($query = $CI->common_model->get_blog_categories())
                return $query;
             else
                return false;
        }
    }
    if ( ! function_exists('get_bulk_categories')) {
        function get_bulk_categories(){     
            $CI =& get_instance();        
             if($query =  $CI->common_model->get_result('bulk_category',array('status'=>1))) 
                return $query;
             else
                return array();
        }
    }
    if ( ! function_exists('check_product_available')) {
        function check_product_available($cat,$col){     
            $CI =& get_instance();        
             if($query =  $CI->common_model->check_product_availables($cat,$col)) 
                return $query;
             else
                return array();
        }
    }
    if ( ! function_exists('check_bulk_product_availables')) {
        function check_bulk_product_availables($cat,$col){     
            $CI =& get_instance();        
             if($query =  $CI->common_model->check_bulk_product_availables($cat,$col)) 
                return $query;
             else
                return array();
        }
    }
    if ( ! function_exists('product_min_size_price')) {
        function product_min_size_price($product_id){     
            $CI =& get_instance();        
             if($query =  $CI->common_model->get_result('product_size_price',array('product_id'=>$product_id),array('price'),array('price','asc'))) 
                return $query;
             else
                return array();
        }
    }
    if ( ! function_exists('settingValue')) {
        function settingValue($setting, $key, $value = '')
        {
            if (isset($setting->$key))
                return $setting->$key;
            else
                return $value;
        }
    }
    /*Config settings send email*/
function configEmail($field, $params=array())
{
    $settingEmail = array(
        'sub_register'=>'Thank you for sign up',
        'register'=>'<p>Dear {username}!</p><p>Thank you register for tshirt</p><p>Your Login ID: {email}</p><p>Please Click <a target="_blank" href="{confirm_url}">here</a> to confirm account</p><p>Regards</p>',
        'sub_change_pass'=>'Change pass',
        'change_pass'=>'<p>Hi, {username}!</p><p>Please have change password.</p><p>Regards</p>',
        'sub_forget_pass'=>'Forgot password',
        'forget_pass'=>'<p>Hi, {username}!</p><p>Please click <a target="blank_" href="{confirm_url}">here</a> to change your password!</p><p>Regards</p>',
        'sub_save_design'=>'Saved Your Design',
        'save_design'=>'<p>Hi, {username}!</p><p>Thanks you use designer of shop. Please click <a target="_blank" href="{url_design}">here</a> to edit design.</p><p>Regards</p>',
        'sub_order_detai'=>'Buy product by shop',
        'order_detai'=>'<p>Thank you for order by shop</p><p>Order info:</p> {table}',
        'sub_order_status'=>'You have new order status',
        'order_status'=>'<p>Hi, {username}. </p><p>The status of your order number {order_number} is changed to {status}</p><p>Regards</p>',
    );

    $CI =& get_instance();
    $query = $CI->db->get('email_templates');
    $settings = $query->result();
    $res = '';
    $count = 0;
    
    for($i=0; $i<count($settings); $i++)
    {
        foreach($settings[$i] as $key=>$val)
        {
            if($key == 'template_name' && $val == $field)
            {
                $record = $val;
                $count = $i;
            }
            if(isset($record) && $key == 'template_body' && $count == $i)
            {
                $res = $val;
            }
            if($res != '')
                break;
        }
    }
    
    if($res != '')
    {
        foreach($params as $key=>$val)
        {
            $res = str_replace('{'.$key.'}', $val, $res);
        }
    }else
    {
        $res = $settingEmail[$field];
        foreach($params as $key=>$val)
        {
            $res = str_replace('{'.$key.'}', $val, $res);
        }
    }
    return $res;
}
function getSettings($email = '')
{
    $CI =& get_instance();
    $query = $CI->db->get('settings');
    return json_decode($query->row()->settings);
}
// Get page category name
if ( ! function_exists('getPageCategoryName')) {
    function getPageCategoryName($id,$table_name,$col){
        $CI =& get_instance();
        $store_admin = $CI->common_model->get_row($table_name,array('id'=>$id), array($col)); 
             return $store_admin->$col;

    }                    
}
// MailChimp Api code
if(!function_exists('mailchimpinsert')){
    function mailchimpinsert($json,$type,$email){
       // MailChimp API credentials
        $apiKey =MAILCHIMP_API_KEY;
        if($type=='Subscribers')
            $listID =MAILCHIMP_SUBSCRIBERS;
        else if($type=='customerReg')
            $listID =MAILCHIMP_CUSTOMERREG;
        else
            $listID =MAILCHIMP_CUSTOMERREG;
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        //echo '<pre>'; print_r(json_decode($result));die;
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }                    
}
// Get page category name
if ( ! function_exists('p')) {
    function p($data){
        echo '<pre>'; print_r($data); echo '</pre>';

    }                    
}
if ( ! function_exists('get_pageContent')) {
    function get_pageContent($id){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('pages',array('id'=>$id)))
             return $query;
         else
             return false;
    }
}

if ( ! function_exists('checkdesigntype')) {
    function checkdesigntype($design_checked_for_store,$product_id,$store_category_id,$return_type=0){    
    $CI =& get_instance();        
    $design_emd_id=$CI->common_model->checkdesigntype($design_checked_for_store,$product_id,$store_category_id);              
    if($design_emd_id)
    {
        if($return_type){
            $design_checked_for_store_type=$design_emd_id;
        }else{
            $design_emd_id = array_map('current',$design_emd_id);
            $design_checked_for_store_type=implode(',',$design_emd_id);
        }
      return $design_checked_for_store_type;
    }
    return '';
  }
}

// get Commission
if ( ! function_exists('get_Commission')) {
    function get_Commission($store_id='',$start_date='',$end_date=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_user_commission_total($store_id,$start_date,$end_date))
         {
             $total=0;
            foreach($query as $row)
            {
                $total+=$row->balance_recevied;
            }
            return number_format($total, 2, '.', '');
         }else
             return '0.00';
    }
}

// get sale report 
if ( ! function_exists('get_sale_ordre')) {
    function get_sale_ordre($store_id='',$start_date='',$end_date=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_sale_ordre_total($store_id,$start_date,$end_date))
         {
             $total=0;
            foreach($query as $row)
            {
                $total+=$row->total;
            }
            return number_format($total, 2, '.', '');
         }else
             return '0.00';
    }
}

if ( ! function_exists('get_result_state')) {
    function get_result_state(){
        $CI =& get_instance();
        $query = $CI->common_model->get_result_state('states',array(),array(),array('name','asc'));
        if($query)
        return $query;
        
    }
}

if ( ! function_exists('get_row_tax')) {
    function get_row_tax($name){
        $CI =& get_instance($name);
        $query = $CI->common_model->get_row('tax',array('tax_id'=>$name),array('short'));
        if($query)
            return $query->short;
        else 
            return false;
        
    }
}
if ( ! function_exists('get_sale_ordre_store')) {
    function get_sale_ordre_store($order='',$store_id=''){
        $CI =& get_instance();
        $query = $CI->common_model->get_sale_ordre_store($order,$store_id);
        return $query;
        
    }
}
if ( ! function_exists('update_data')) {
    function update_data($table,$data,$condition){
        $CI =& get_instance();
        return  $query = $CI->common_model->update($table,$data,$condition);
        
        
    }
}
if ( ! function_exists('store_notification_update')) {
    function store_notification_update($data,$condition){
        $CI =& get_instance();
        return  $query = $CI->common_model->update('store_notification',$data,$condition);
        
        
    }
}
if ( ! function_exists('get_province')) {
    function get_province($id){
        $CI =& get_instance();
        return  $query = $CI->common_model->get_row('tax',array('tax_id'=>$id),array('province'));
        
        
    }
}
if ( ! function_exists('generate_random_promocode_gift')) {
function generate_random_promocode_gift($length = 8) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    //$additional_characters = array('_','.');
    $final_array = array_merge($alphabets,$numbers);
    $code= '';
    while($length--) {
      $key = array_rand($final_array);
      $code .= $final_array[$key];
    }
    
    if(check_coupon_code_order_gift_exit($code))
        generate_random_promocode_gift(8);
    else
        return $code;
  }
}
if ( ! function_exists('check_coupon_code_order_gift_exit')) {
function check_coupon_code_order_gift_exit($code){
    
    $CI =& get_instance();
       $resp = $CI->common_model->get_row('gift_order_detail', array('promo_code' => strtolower($code))); 
            if ($resp){
                return TRUE;
            }else
                return FALSE;
     }
}
if ( ! function_exists('generate_random_promocode')) {
function generate_random_promocode($length = 8) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    //$additional_characters = array('_','.');
    $final_array = array_merge($alphabets,$numbers);
    $code= '';
    while($length--) {
      $key = array_rand($final_array);
      $code .= $final_array[$key];
    }
    
    if(check_coupon_code_exit($code))
        generate_random_promocode(8);
    else
        return $code;
  }
}
if ( ! function_exists('check_coupon_code_exit')) {
function check_coupon_code_exit($code){
    
    $CI =& get_instance();
       $resp = $CI->common_model->get_row('coupons', array('code' => strtolower($code))); 
            if ($resp){
                return TRUE;
            }else
                return FALSE;
     }
}
if(!function_exists('calculation_bulk_cart')){
    function calculation_bulk_cart()
    {
        $CI =& get_instance();
        $result=array();
        $product=array();
        $i=0;
        $cart_array=$CI->cart->contents();
        //p($cart_array);
        foreach($cart_array as $key=>$row)
        {
            $store_info = $CI->common_model->get_row('stores', array('id' =>$row['options']['store_id']),array('is_bulk'));
            if($store_info->is_bulk==2 && $row['options']['uniform']==0)
            {
                if(!in_array($row['options']['product_id'], $product))
                {
                    
                    $product[]=$row['options']['product_id'];
                    $result[$i]['rowid'][]=$key;
                    $result[$i]['Hidden_ProductColorId']=$row['options']['product_color_id'];
                    $result[$i]['Hidden_DesignId']=$row['options']['design_id'];
                    $result[$i]['Hidden_back_design_id']=$row['options']['back_design_id'];
                    $result[$i]['Hidden_left_design_id']=$row['options']['left_design_id'];
                    $result[$i]['Hidden_right_design_id']=$row['options']['right_design_id'];
                    $result[$i]['Hidden_top_design_id']=$row['options']['top_design_id'];
                    $result[$i]['store_category_id']=$row['options']['store_category_id'];
                    $result[$i]['store_id']=$row['options']['store_id'];
                    $qty_name='quantity_'.$row['options']['Size_id'];
                    $result[$i][$qty_name]=$result[$i][$qty_name]+$row['qty'];
                    $result[$i]['reg_price']=$row['reg_price'];
                    $result[$i]['price']=$row['price'];
                    $result[$i]['uniform']=$row['options']['uniform'];
                    $result[$i]['promo_discount']=$row['promo_discount'];
                    $result[$i]['promo_type']=$row['promo_type'];
                    $i++;
                }else{
                    $cureent_key=array_search($row['options']['product_id'], $product);
                    for($j=0;$j<sizeof($result);$j++)
                    {
                        if($row['options']['uniform']==1)
                        {
                            if($result[$j]['Hidden_ProductColorId']==$row['options']['product_color_id'] && $result[$j]['Hidden_DesignId']==$row['options']['design_id'] && $result[$j]['Hidden_back_design_id']==$row['options']['back_design_id'] && $result[$j]['Hidden_left_design_id']==$row['options']['left_design_id'] && $result[$j]['Hidden_right_design_id']==$row['options']['right_design_id'] && $result[$j]['Hidden_top_design_id']==$row['options']['top_design_id'] && $row['options']['uniform']==$result[$j]['uniform'])
                            {
                                $cureent_key=$j;
                                break;
                            }
                        }else{
                            if($result[$j]['Hidden_ProductColorId']==$row['options']['product_color_id'] && $result[$j]['Hidden_DesignId']==$row['options']['design_id'] && $result[$j]['Hidden_back_design_id']==$row['options']['back_design_id'] && $result[$j]['Hidden_left_design_id']==$row['options']['left_design_id'] && $result[$j]['Hidden_right_design_id']==$row['options']['right_design_id'] && $result[$j]['Hidden_top_design_id']==$row['options']['top_design_id'] && $row['options']['uniform']==$result[$j]['uniform'])
                            {
                                $cureent_key=$j;
                                break;
                            }
                        }
                    }
                
                    if($result[$cureent_key]['Hidden_ProductColorId']==$row['options']['product_color_id'] && $result[$cureent_key]['Hidden_DesignId']==$row['options']['design_id'] && $result[$cureent_key]['Hidden_back_design_id']==$row['options']['back_design_id'] && $result[$j]['Hidden_left_design_id']==$row['options']['left_design_id'] && $result[$j]['Hidden_right_design_id']==$row['options']['right_design_id'] && $result[$j]['Hidden_top_design_id']==$row['options']['top_design_id'] && $row['options']['uniform']==$result[$cureent_key]['uniform'])
                    {
                        $qty_name='quantity_'.$row['options']['Size_id'];
                        $result[$cureent_key][$qty_name]=$result[$cureent_key][$qty_name]+$row['qty'];
                        $result[$cureent_key]['rowid'][]=$key;
                    }else{
                        $product[]=$row['options']['product_id'];
                        $result[$i]['rowid'][]=$key;
                        $result[$i]['Hidden_ProductColorId']=$row['options']['product_color_id'];
                        $result[$i]['Hidden_DesignId']=$row['options']['design_id'];
                        $result[$i]['Hidden_back_design_id']=$row['options']['back_design_id'];
                        $result[$i]['Hidden_left_design_id']=$row['options']['left_design_id'];
                        $result[$i]['Hidden_right_design_id']=$row['options']['right_design_id'];
                        $result[$i]['Hidden_top_design_id']=$row['options']['top_design_id'];
                        $result[$i]['store_category_id']=$row['options']['store_category_id'];
                        $result[$i]['store_id']=$row['options']['store_id'];
                        $qty_name='quantity_'.$row['options']['Size_id'];
                        $result[$i][$qty_name]=$result[$i][$qty_name]+$row['qty'];
                        $result[$i]['reg_price']=$row['reg_price'];
                        $result[$i]['price']=$row['price'];
                        $result[$i]['uniform']=$row['options']['uniform'];
                        $result[$i]['promo_discount']=$row['promo_discount'];
                        $result[$i]['promo_type']=$row['promo_type'];
                        $i++;
                    }
                
                }
            }
        }
        //p($result);die;
        $resultCalculation=calculation_store_bulk_cart($result);
        
        for($i=0;$i<sizeof($resultCalculation);$i++)
        {
            
            for($j=0;$j<sizeof($resultCalculation[$i]['rowid']);$j++)
            {
                
                $old_cart=$cart_array[$resultCalculation[$i]['rowid'][$j]];
                
                if($old_cart['disount_amt'])
                {
                    $data=array(
                        'rowid' => $resultCalculation[$i]['rowid'][$j],
                        'price'=>number_format($old_cart['price'],2,'.',''),
                    ) ;
                }else{    
                $price=$old_cart['product_price']-($old_cart['product_price']*$resultCalculation[$i]['pecentage']);
                $price=$price*$old_cart['qty'];
                if ($resultCalculation[$i]['promo_type'] == 1)
                { 
                    $price =$price-(($price *$resultCalculation[$i]['promo_discount']) / 100);
                }
                elseif($resultCalculation[$i]['promo_discount']!=0)
                {
                    $price =$price-$resultCalculation[$i]['promo_discount'];
                }
                $data=array(
                        'rowid' => $resultCalculation[$i]['rowid'][$j],
                        'price'=>number_format(($old_cart['product_price']-($old_cart['product_price']*$resultCalculation[$i]['pecentage'])),2,'.',''),
                        'promo_discount'=>$resultCalculation[$i]['promo_discount'],
                        'promo_type'=>$resultCalculation[$i]['promo_type'],
                        'sub_total_discount'=>$price,
                    ) ;
                
                }                    
                //die;
                $CI->cart->update($data);
            }
        }
        
    }
}
if ( ! function_exists('calculation_store_bulk_cart')) {
   function calculation_store_bulk_cart($result){
    $CI =& get_instance();
    $list=array('STATUS'=>FALSE);
    
    for($i=0;$i<sizeof($result);$i++){
        $product_color_id=$result[$i]['Hidden_ProductColorId'];
        $product_color_info = $CI->common_model->get_row('product_colors', array('id' => $product_color_id));
        $product_id=$product_color_info->product_id;
        if(isset($_GET['uniform']) && $_GET['uniform']==1)
        {
            $product_info = $CI->common_model->get_unifrom_price($product_id,$result[$i]['store_category_id']);
        }else{
            $product_info = $CI->common_model->get_row('products', array('id' => $product_id),array('id','base_price','discount_price','title'));
        }
        
        
        $design_id=$result[$i]['Hidden_DesignId'];
        $back_design_id=$result[$i]['Hidden_back_design_id'];
        $design_info = $CI->common_model->get_row('designs', array('id' => $design_id),array('id','base_price'));
        $design_front_price=$design_info->base_price;
        $design_back_price=0;
        if($back_design_id){
            $design_back_info = $CI->common_model->get_row('designs', array('id' =>$back_design_id),array('id','base_price'));
            $design_back_price=$design_back_info->base_price;
        }
        $product_additinal_size_price=0;
        $total_qty='0';
            foreach ($result[$i] as $key => $value) {
            $pos1 = stripos($key, "quantity_");
            if($pos1 !== FALSE){
                $array = explode('_', $key);
                $value=abs($value);
                if($value != '0' && $value != ''){
                    $total_qty=$total_qty+$value;    
                    $product_size_info = $CI->common_model->get_row('product_size_price',array('id'=>$array[1]));
                    $product_price_with_size=$product_size_info->price * $value; 
                      $product_additinal_size_price= $product_price_with_size + $product_additinal_size_price;
                  }
               }
             }
        $totalQty=$total_qty;
        if($total_qty==0)
        {
            $product_size_price=0;
                  if($size=product_min_size_price($product_id))
                  {
                      if(!empty($size))
                      {
                        $product_price_with_size=$size[0]->price * 1; 
                          $product_additinal_size_price= $product_price_with_size + $product_additinal_size_price;
                          $total_qty=1;
                      }
                  }
        }
        $product_base_price=$product_info->base_price;
        $product_additinal_color_price=$product_color_info->product_color_additional_price;
          $produact_acc_price = $product_base_price + $product_additinal_color_price + $design_front_price + $design_back_price ;

          $produact_acc_price_qty=$produact_acc_price * $total_qty;
        $product_total_price = $product_additinal_size_price + $produact_acc_price_qty ;

        $regular_product_single_price=$product_total_price/$total_qty;
        $new_product_single_price=$regular_product_single_price;
        $bulk_discount_apply=0;
        $deduct_price=0;
        $pecentage=0;
        $pur_qty=0;
        $disount_amt=0;
        if(get_option_value('STORE_COMMISSION_STATUS'))
        {
            if($store_comm=get_store_commission('',$result[$i]['store_id']))
                $product_info->discount_price+=$store_comm;
        }  
        if($product_info->discount_price){
            $new_product_single_price=$regular_product_single_price-(($regular_product_single_price* $product_info->discount_price)/100);
        }else{
            if($check_qty=$CI->common_model->check_qty_exit($product_id,$total_qty)){
                $bulk_discount_apply=1;
                $pecentage=($check_qty->discount_percentage)/100;
            }
        
            $product_bulk_discount = $CI->common_model->get_result('product_bulk_discount',array('product_id'=>$product_id));
        
            foreach($product_bulk_discount as $row)
            {   
                if($row->quantity_start > $total_qty)
                {
                    $pur_qty=$row->quantity_start-$total_qty;
                    $disount_amt=$row->discount_percentage;
                    break;
                }
            }    
        }
        $result[$i]['pecentage']=$pecentage;    
        /* if($pecentage){
            $new_product_single_price = $new_product_single_price - ($new_product_single_price * $pecentage);
        }else{
            
        }
        $single_qty_dis = $regular_product_single_price - $new_product_single_price;
        $all_discount = $single_qty_dis * $total_qty;
        
        $product_total_price = $new_product_single_price *  $total_qty;
        
        $result[$i]['reg_price']=number_format($regular_product_single_price,2);
        $result[$i]['price']=number_format($new_product_single_price,2); */
        
        }
        return $result;
    }
    
}
if ( ! function_exists('getoriginalPrice')) {
    function getoriginalPrice($product_id,$color_id,$size){
        $CI =& get_instance();
        $product =$CI->superadmin_model->get_row('products',array('id'=>$product_id),array('original_price'));
        
        $product_color_sizes = $CI->superadmin_model->get_result('product_size_price',array('product_id'=>$product_id),array(),array('id','ASC'));
        
        $updated_product_sc=$product->original_price;
        $price_p_s_c='';
        if($updated_product_sc){
              $price_p_s_c= explode(',', $updated_product_sc);
            }
            
        $get_all_product_color_image='';        $get_all_product_color_image = get_all_product_color_image($product_id);
        $i=0;
        
        if(!empty($get_all_product_color_image)) { 
        
        foreach ($get_all_product_color_image as  $value_color) {
             if(!empty($product_color_sizes)){ 
             
                 foreach ($product_color_sizes as  $size_value) {
                     $current_price=0;
                    if($price_p_s_c){
                          $current_price= $price_p_s_c[$i];
                    }
                    $i++;
                    if($value_color->id==$color_id && $size==$size_value->size_name)
                    {
                        return $current_price;
                    }
                }
             }
        }
        }            
    }
}
/**
    *    check superadmin logged in
    */
    if ( ! function_exists('affiliate_logged_in')) {
        function affiliate_logged_in(){
            $CI =& get_instance();
            $affiliate_info = $CI->session->userdata('affiliate_info');
            if($affiliate_info['logged_in']===TRUE && $affiliate_info['user_role'] == 3 )
                return TRUE;
            else
                return FALSE;
        }
    }
    /**
    *    superadmin login information
    */
    if ( ! function_exists('affiliate_name')) { 
        function affiliate_name(){
            $CI =& get_instance();
            $affiliate_info = $CI->session->userdata('affiliate_info');
            if($affiliate_info['logged_in']===TRUE )
                 return $affiliate_info['first_name']." ".$affiliate_info['last_name'];
            else
                return FALSE;
        }                    
    }
    if ( ! function_exists('sale_name')) { 
        function sale_name(){
            $CI =& get_instance();
            $sale_info = $CI->session->userdata('sale_info');
            if($sale_info['logged_in']===TRUE )
                 return $sale_info['first_name']." ".$sale_info['last_name'];
            else
                return FALSE;
        }                    
    }
    /**
    *    get admin id
    */
    if ( ! function_exists('')) {
        function affiliate_user_id(){
            $CI =& get_instance();
            $affiliate_info = $CI->session->userdata('affiliate_info');        
                return $affiliate_info['id'];        
        }
    }

    /*affiliate user id*/
    if ( ! function_exists('affiliate_user_id_db')) {
    function affiliate_user_id_db(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('users',array('user_role'=>3),array('id')))
             return $query;
         else
             return false;
    }
    }
    if ( ! function_exists('get_store_category_affiliate')) {
    function get_store_category_affiliate($s1=''){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_row('store_category',array('affiliate_category'=>1)))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('get_user_payee_info')) {
    function get_user_payee_info($store_id){    
        $CI =& get_instance();
         if($query = $CI->common_model->get_row('user_payee_info',array('store_id'=>$store_id)))
         {
            return $query;
         }else
             return false;
    }
}
if ( ! function_exists('get_store_category_subscriber')) {
    function get_store_category_subscriber(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category',array('registration_subscriber'=>1,'status'=>1,'affiliate_category'=>2)))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('store_category_menu')) {
    function store_category_menu(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category',array('affiliate_category'=>2),array(),array('category_name','ASC')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('affiliate_store_category_menu')) {
    function affiliate_store_category_menu(){    
        $CI =& get_instance();        
         if($query = $CI->common_model->get_result('store_category',array('affiliate_category'=>1),array(),array('category_name','ASC')))
             return $query;
         else
             return false;
    }
}
if ( ! function_exists('publish_store_category_main_menu')) {
function publish_store_category_main_menu(){    
$CI =& get_instance();    
if($query = $CI->common_model->get_result('store_category',array('status'=>1,'registration_subscriber'=>1,'affiliate_category'=>2)))
    return $query;
else
    return false;
 }
}
if ( ! function_exists('get_resource_link')) {
    function get_resource_link($store_id){    
    $CI =& get_instance();
    if($query = $CI->common_model->get_result('resourcelink',array('store_id'=>$store_id)))
    {
        return $query;
    }else
        return false;
    }
}

if ( ! function_exists('get_affiliate_user_payee_info')) {
    function get_affiliate_user_payee_info($user_id){    
    $CI =& get_instance();
    if($query = $CI->common_model->get_row('user_payee_info',array('user_id'=>$user_id)))
    {
    return $query;
    }else
    return false;
    }
}



/**
*    get particular user total affiliate earn commissions
*/
if ( ! function_exists('total_affiliate_earn_commissions')) {
    function total_affiliate_earn_commissions($affiliateId){
        $CI =& get_instance();
        if($query = $CI->common_model->total_affiliate_earn_commissions($affiliateId))
            return $query;
        else
            return false;       
    }
}


/**
*    get particular user total my commissions
*/
if ( ! function_exists('total_my_commissions')) {
    function total_my_commissions($affiliateId){
        $CI =& get_instance();
        if($query = $CI->common_model->total_my_commissions($affiliateId))
            return $query;
        else
            return false;       
    }
}



/**
*    get count of affliate user
*/
if ( ! function_exists('get_affiliate_user')) {
    function get_affiliate_user(){
        $CI =& get_instance();
        if($query = $CI->common_model->get_affiliate_user())
            return $query;
        else
            return false;       
    }
}



/**
*    get count of affliate store category
*/
if ( ! function_exists('get_affiliate_store_category')) {
    function get_affiliate_store_category(){
        $CI =& get_instance();
        if($query = $CI->common_model->get_affiliate_store_category())
            return $query;
        else
            return false;       
    }
}


/**
*    get count of total my commissions
*/
if ( ! function_exists('total_affiliated_my_commissions')) {
    function total_affiliated_my_commissions(){
        $CI =& get_instance();
        if($query = $CI->common_model->total_affiliated_my_commissions())
            return $query;
        else
            return false;       
    }
}


/**
*    get count of total store commissions
*/
if ( ! function_exists('total_affiliate_store_commissions')) {
    function total_affiliate_store_commissions(){
        $CI =& get_instance();
        if($query = $CI->common_model->total_affiliate_store_commissions())
            return $query;
        else
            return false;       
    }
}

/* get uniform store */
if ( ! function_exists('get_uniform_product_exit')) {
    function get_uniform_product_exit($cat_id){
        $CI =& get_instance();
        if($query = $CI->common_model->get_uniform_product_exit($cat_id))
            return $query;
        else
            return false;       
    }
}
if ( ! function_exists('get_uniform_sub_category')) {
    function get_uniform_sub_category($cate_id,$pcategory_id){
        $CI =& get_instance();
        if($query = $CI->common_model->get_uniform_sub_category($cate_id,$pcategory_id))
            return $query;
        else
            return false;       
    }
}
if ( ! function_exists('getGiftCard')) {           
    function getGiftCard(){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('retail_gift',array('status'=>1),array(),array('amount','asc')))        
             return $query;        
         else        
             return false;        
    }        
}
  
if ( ! function_exists('get_total_gift_balance')) {           function get_total_gift_balance($user_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_total_gift_balance($user_id))        
             return $query;        
         else        
             return '0.00';        
    }        
}
if ( ! function_exists('get_total_gift_used_balance')) {       
    function get_total_gift_used_balance($user_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_total_gift_used_balance($user_id))       return $query;        
         else        
             return '0.00';        
    }        
}


if ( ! function_exists('get_PromoCode_of_itemDetails')) {       
    function get_PromoCode_of_itemDetails($item_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_PromoCode_of_itemDetails($item_id))       
             return $query;        
         else        
             return false;        
    }        
}

if ( ! function_exists('get_PromoCode_of_used_datails')) {       
    function get_PromoCode_of_used_datails($item_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('gift_order_detail',array('gift_item_id'=>$item_id)))       
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_all_gift_amount')) {       
    function get_all_gift_amount($user_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('gift_order_detail',array('used_user_id'=>$user_id,'remaining_amount>'=>0)))       
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_bulk_category_id')) {       
    function get_bulk_category_id($category_id,$id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('bulk_store_category',array('id'=>$id,'category_id'=>$category_id)))       
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('get_bulk_category')) {       
    function get_bulk_category($store_id,$id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('bulk_store_category',array('id'=>$id,'store_id'=>$store_id)))       
             return $query;        
         else        
             return false;        
    }        
}

if ( ! function_exists('get_uniform_category')) {       
    function get_uniform_category($category_id,$id){
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('bulk_store_category',array('id'=>$id,'category_id'=>$category_id)))       
             return $query;        
         else        
             return false;        
    }        
}

if ( ! function_exists('get_all_bulk_category')) {       
    function get_all_bulk_category($store_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('bulk_store_category',array('store_id'=>$store_id)))       
             return $query;        
         else        
             return false;        
    }        
}

if ( ! function_exists('get_all_uniform_category')) {       
    function get_all_uniform_category($category_id){    
        $CI =& get_instance();                
         if($query = $CI->common_model->get_result('bulk_store_category',array('category_id'=>$category_id)))       
             return $query;        
         else        
             return false;        
    }        
}

if ( ! function_exists('get_all_province')) {       
    function get_all_province(){    
        $CI =& get_instance();                
         if($query = $CI->common_model->province())       
             return $query;        
         else        
             return false;        
    }        
}
// get bulk product base price
if ( ! function_exists('get_bulk_product_base_price')) {
    function get_bulk_product_base_price($product_id='',$store_id=''){
        $CI =& get_instance();
        $store_admin_info = $CI->common_model->get_row('bulk_product_price',array('product_id'=>$product_id,'store_id'=>$store_id));        
            if(!empty($store_admin_info)) 
                return $store_admin_info->new_base_price;
            else 
                return '0';       
    }
}
if ( ! function_exists('get_bulk_product_fundraiser_amt')) {
    function get_bulk_product_fundraiser_amt($product_id='',$store_id=''){
        $CI =& get_instance();
        $store_admin_info = $CI->common_model->get_row('bulk_product_price',array('product_id'=>$product_id,'store_id'=>$store_id));        
            if(!empty($store_admin_info)) 
                return $store_admin_info->fundraiser_amt;
            else 
                return '0';       
    }
}
if ( ! function_exists('get_bulk_design_price')) {
    function get_bulk_design_price($product_id='',$store_id=''){
        $CI =& get_instance();
        $store_admin_info = $CI->common_model->get_row('bulk_design_price',array('design_id'=>$product_id,'store_id'=>$store_id));        
        return $store_admin_info;
                
    }
}
if ( ! function_exists('getDesignSubCategory')) {
    function getDesignSubCategory($category_id=''){
        $CI =& get_instance();
        $store_admin_info = $CI->common_model->get_result('design_tool_sub_category',array('status'=>1,'design_main_category_id'=>$category_id),array('category_name','id'),array('order_by','asc'));        
        return $store_admin_info;
                
    }
}
if ( ! function_exists('get_promo_code_detail_abandoned_id')) {
function get_promo_code_detail_abandoned_id($id='',$user_id=''){
    
    $CI =& get_instance();
       $resp = $CI->common_model->get_row('coupons', array('code_type' =>6,'abandoned_id'=>$id,'user_id'=>$user_id )); 
       
            if ($resp){
                return  $resp;
            }else
                return FALSE;
     }
}
if ( ! function_exists('get_country_name')) {
function get_country_name($id=''){
    
    $CI =& get_instance();
       $resp = $CI->common_model->get_row('country', array('id' =>$id)); 
       
            if ($resp){
                return  $resp->country_name;
            }else
                return FALSE;
     }
}
if ( ! function_exists('get_country_id')) {
function get_country_id($name=''){
    
    $CI =& get_instance();
       $resp = $CI->common_model->get_row('country', array('country_name' =>$name)); 
       
            if ($resp){
                return  $resp->id;
            }else
                return FALSE;
     }
}
if ( ! function_exists('get_paid_amount')) {
    function get_paid_amount($store_id=''){
        $CI =& get_instance();
        $CI->load->model('superadmin_model');
        return $resp = $CI->superadmin_model->get_paid_amount($store_id); 
    }
}
if ( ! function_exists('get_design_text_type')) {    
    function get_design_text_type($status='') {
        $status_array = array(
                            '1' => 'No fields',
                            '2' => 'Name',
                            '3' => 'Number',
                            '4' => 'Name and Number',
                            '5' => 'Line 1',
                            '6'=>  'Line 2',
                            '7'=>  'Line 1 & Line 2,',
                            '8'=>  'Year',
                        );   
        return $status_array;
    }
}
if ( ! function_exists('get_sales_type')) {    
    function get_sales_type($status='') {
        $status_array = array(
                            'Decal' => 'Decal',
                            'DTG' => 'DTG',
                            'Embroidery' => 'Embroidery',
                            'Srceen_Print' => 'Screen Print',
                            'Vinyl' => 'Vinyl',
                            'Other'=>  'Other',
                        );   
        return $status_array;
    }
}

if ( ! function_exists('get_sales_placement')) {    
    function get_sales_placement($status='') {
        $status_array = array(
                            'Centre Chest' => 'Centre Chest',
                            //'DTG' => 'DTG',
                            'Left Chest' => 'Left Chest',
                            'Centre Back' => 'Centre Back',
                            'Nape of Neck' => 'Nape of Neck',
                            'Back Waistband'=>  'Back Waistband',
                            'Left Sleeve'=>  'Left Sleeve',
                            'Left Cuff'=>  'Left Cuff',
                            'Left Sleeve - Vertical'=>  'Left Sleeve - Vertical',
                            'Right Sleeve'=>  'Right Sleeve',
                            'Right Cuff'=>  'Right Cuff',
                            'Right Sleeve - Vertical'=>  'Right Sleeve - Vertical',
                            'Right Sleeve'=>  'Right Sleeve',
                            'Other'       =>'Other',

                        );   
        return $status_array;
    }
}
if ( ! function_exists('getsallername')) {
    function getsallername($sallerid=''){
        $CI =& get_instance();
        $CI->load->model('superadmin_model');
        return $resp = $CI->superadmin_model->get_saller_name($sallerid); 
    }
}

if ( ! function_exists('getstorename')) {
    function getstorename($store_id=''){
        $CI =& get_instance();
        $CI->load->model('superadmin_model');
        return $resp = $CI->superadmin_model->get_store_name($store_id); 
    }
}
if ( ! function_exists('getproductname')) {
    function getproductname($pid=''){
        $CI =& get_instance();
        $CI->load->model('superadmin_model');
        return $resp = $CI->superadmin_model->get_product_name($pid); 
    }
}

if ( ! function_exists('getPageAceess')) {        
    function getPageAceess($module='', $sales_user_id=''){            
        $CI =& get_instance();                
         if($query = $CI->common_model->get_row('access_level_user',array('module'=>$module, 'user_id'=>$sales_user_id)))        
             return $query;        
         else        
             return false;        
    }        
}
if ( ! function_exists('getallowance')) {

    function getallowance($allowance){
        $CI =& get_instance();
        $CI->load->model('superadmin_model');
        return $resp = $CI->superadmin_model->get_allowance_name($allowance); 
    }
}
if ( ! function_exists('getsubmitOPS')) {

    function getsubmitOPS($store_id){
    //echo $store_id;
        $CI =& get_instance();
        $CI->load->model('common_model');
        $bulk_store_category_count=$CI->common_model->get_result_count('bulk_store_category',$store_id);
        $product_count=$CI->common_model->get_result_count('sale_product_info',$store_id);
        $logistic_count=$CI->common_model->get_result_count('store_order_details',$store_id);
        if($bulk_store_category_count>0 && $product_count>0 && $logistic_count>0)
        {
            return "true";
        }
        else
        {
            return "false";
        }        
    }
}
