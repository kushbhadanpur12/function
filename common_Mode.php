<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {    

    public function insert($table_name='',  $data=''){
        $query=$this->db->insert($table_name, $data);
        // echo $this->db->last_query();
        // die;
        if($query)
            return $this->db->insert_id();
        else
            return FALSE;        
    }
    

    public function get_result($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            } 
        endif;    
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            }
        endif;
        if(!empty($limit) && $limit!=''):    
            $this->db->limit($limit);
        endif;    

        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_row($table_name='', $id_array='',$columns=array(),$order_by=array(),$where_in=array()){
        //echo $table_name;
        //print_r($where_in);die;
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            } 
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        $query=$this->db->get($table_name);
            
        if($query->num_rows()>0)
        {
            
            return $query->row();
        }else
            return FALSE;
    }

    public function get_row_product_uniform($table_name='', $id_array='',$columns=array(),$order_by=array(),$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        $where_store_vise="(products.product_type LIKE '%#1#%' or products.product_type LIKE '%#4#%' or products.product_type LIKE '%#2#%')";
        $this->db->where($where_store_vise);
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        $query=$this->db->get($table_name);
        if($query->num_rows()>0) 
        {
            return $query->row();
        }else
            return FALSE;
    }

    public function get_row_product($table_name='', $id_array='',$columns=array(),$order_by=array(),$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        $where_store_vise="(products.product_type LIKE '%#1#%')";
        $this->db->where($where_store_vise);
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        $query=$this->db->get($table_name);
        if($query->num_rows()>0) 
        {
            return $query->row();
        }else
            return FALSE;
    }



    public function get_row_old_uri($table_name='', $id_array='',$columns=array(),$order_by=array(),$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        $this->db->where('old_uri is not NULL');
        $query=$this->db->get($table_name);
        if($query->num_rows()>0) 
        {
            return $query->row();
        }else
            return FALSE;
    }



    public function update($table_name='', $data='', $id_array=''){
        if(!empty($id_array)):
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        return $this->db->update($table_name, $data);        
    }



    public function delete($table_name='', $id_array=''){        
     return $this->db->delete($table_name, $id_array);
    }
    


    public function password_check($data=''){  
        $query = $this->db->get_where('users',$data);
         if($query->num_rows()>0)
            return TRUE;
        else{
            //$this->form_validation->set_message('password_check', 'The %s field can not match');
            return FALSE;
        }
    }
    


    public function get_nav_menu($slug='',$is_location=FALSE){        
        $this->db->select('menus.id,menus.menu_label,menus.menu_link');
        $this->db->order_by('menus.menu_order','asc');
        $this->db->group_by('menus.menu_order');
        $this->db->from('menus');
        $this->db->join('menu_categories','menu_categories.id=menus.menu_category_id','right');
        if($is_location)
            $this->db->where('menus.menu_location',$slug);
        else
            $this->db->where('menu_categories.menu_category_slug',$slug);
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            //return $query->result();
            $main_menu=array();
            foreach ($query->result() as $row):
                $main_menu[]= (object) array(
                    'id' =>$row->id,
                    'menu_label' =>$row->menu_label,
                    'menu_link' =>$row->menu_link,
                    'child_menu' => $this->get_result('menus',array('menu_parent_id'=>$row->id),array('id','menu_label','menu_link'),array('menu_order','asc')),
                    );
            endforeach;
            //print_r($main_menu);
            //die;
            return $main_menu;
        }
        else
            return FALSE;
    }



    public function page($slug=''){
        
        if(!empty($slug)){
            $query = $this->db->get_where('pages',array('page_slug'=>$slug, 'status'=>'1'));
        
            if($query->num_rows()>0)
            
                return $query->row();
            else
                return FALSE;
        }else{
            return FALSE;
        }
    }    
    


    public function get_post($slug,$is_slug){
        if($is_slug)
            $where=array('id'=>$slug,'post_type'=>'post');
        else
            $where=array('post_slug'=>$slug,'post_type'=>'post');
        return    $this->get_row('posts',$where,array('post_title','post_content'));        
    }



    public function news_categories($offset='',$per_page=''){
        if($offset>=0 && $per_page>0){
            $this->db->order_by('id','desc');
            $this->db->limit($per_page,$offset);
            $query = $this->db->get('news_categories');
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
        }else{
            $query = $this->db->get('news_categories');
            return $query->num_rows();            
        }
    }



    public function stores_list($category_id='0',$sub_category_id='0',$sub_type_category_id='0',$sub_type_category_id_fourth='0')
    {
        $this->db->select('first_position,id,store_category_id,store_sub_category_id,store_sub_category_type_id,sub_category_fourth,store_link,store_title');
        
        if(!empty($category_id)){
            $this->db->where('store_category_id',$category_id);
        }
        if(!empty($sub_category_id)){
            $where_in=$sub_category_id;
            $this->db->where('store_sub_category_id',$where_in);
        }
        if(!empty($sub_type_category_id)){
            $where_in=$sub_type_category_id;
            $this->db->where('store_sub_category_type_id',$where_in);
        }
        if(!empty($sub_type_category_id_fourth)){
            $where_in=$sub_type_category_id_fourth;
            $this->db->where('sub_category_fourth',$where_in);
        }
        $this->db->where('store_status',1);
        $this->db->order_by('first_position', 'asc');
        $this->db->order_by('store_title', 'asc');
        $query=$this->db->get('stores');
        return $query->result();
    }
    public function stores_products_bulk($offset,$per_page,$stores_products='',$store_id='',$store_category_id='')
    {
        
        
        if(!empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc3']);
            $this->db->where_in('products.sub_category_id',$where_in);
        }
        if(!empty($_GET['pc2']) && empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc2']);
            $this->db->where_in('products.category_id',$where_in);
        }
        if(!empty($_GET['pc1']) && empty($_GET['pc2']) && empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc1']);
            $this->db->where_in('products.main_category_id',$where_in);
        }
        
        //$where_store_vise="(products.product_type LIKE '%#1#%')";
        //$this->db->where($where_store_vise);
        $this->db->select('products.product_brand,products.product_item_no,products.title,products.discount_price,products.id as product_id,pb.*,pb.id as bulk_product_id,pb.product_tag as short_label,products.show_offer,products.design_type_id,pb.base_price as bulk_base_price');
        //$this->db->where("products.id IN(".$stores_products.")");
        $this->db->where('products.status',1);
        $this->db->where('pb.status',1);
        $this->db->from('products');
        $this->db->join('bulk_product_price as pb','products.id=pb.product_id');
        $this->db->join('bulk_store_category as bc','pb.product_category=bc.id');
        if($store_category_id!='')
            $this->db->where('pb.store_category_id',$store_category_id);
        else    
            $this->db->where('pb.store_id',$store_id);
        $this->db->where('bc.status',1);
        
        $this->db->order_by('bc.order_by','ASC');
        $this->db->order_by('pb.order_by','ASC');
        $this->db->order_by('pb.product_category','ASC');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
        
    }



    public function stores_products($offset,$per_page,$stores_products='')
    {
        
        
        if(!empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc3']);
            $this->db->where_in('sub_category_id',$where_in);
        }
        if(!empty($_GET['pc2']) && empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc2']);
            $this->db->where_in('category_id',$where_in);
        }
        if(!empty($_GET['pc1']) && empty($_GET['pc2']) && empty($_GET['pc3'])){
            $where_in=explode(",",$_GET['pc1']);
            $this->db->where_in('main_category_id',$where_in);
        }
        
        $where_store_vise="(products.product_type LIKE '%#1#%')";
        $this->db->where($where_store_vise);
        $this->db->where("id IN(".$stores_products.")");
        $this->db->where('status',1);
        
        $this->db->from('products');
        
        if($offset>=0 && $per_page>0){
            $this->db->limit($per_page,$offset);
            $this->db->order_by('order','ASC');
            
            $query = $this->db->get();
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
        }else{
            return $this->db->count_all_results();
        }
    }



    public function stores_products_info($product_cate='')
    {
        $where_in=$product_cate;
        $this->db->like('main_category_id',$where_in);
        $this->db->where('status',1);
        $this->db->order_by('id', 'desc');
        $query=$this->db->get('products');
        return $query->row();
    }



    public function stores_products_info_select($product_cate='')
    {
        $where_in=$product_cate;
        $this->db->like('main_category_id',$where_in);
        $this->db->where('status',1);
        $this->db->order_by('id', 'desc');
        $query=$this->db->select('id');
        $query=$this->db->get('products');
        return $query->row();
    }



    public function get_random_design($category_id='',$product_id='',$stores_design_allowed='',$store_id='',$get_random_design_result='',$design_type='',$where_not='',$status='',$uniform=0){
        $store_info=array();
        if($store_id!='')
            $store_info=get_store_info($store_id);
        
        
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->where('store_category_id',$where_in);
        }
        if($get_random_design_result){
            $put_where_con="(product_side=$get_random_design_result OR product_side=3)";
            $this->db->where($put_where_con);
        }    
        else{
            $put_where_con="(product_side=1 OR product_side=3)";
            $this->db->where($put_where_con);
        }
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%'";
            $this->db->where("($c)");
        }
        if($design_type!='')
        {
            $where_in='"8"';
            $c="design_type LIKE '%".$where_in."%'";
            $this->db->where("($c)");
        }
        if(!empty($where_not))
        {
            $this->db->where_not_in('id', $where_not);
        }
        if($status!='')
        {
            $this->db->where('allow_status', $status);
        }
        $this->db->where('uniform_design', $uniform);
            /* if(!empty($store_info))
            {
                if($store_info->store_category_id==5 && $store_info->store_type==1)
                {
                    $where_store_vise="(design_title LIKE '%".$store_info->line1."%' or  design_title LIKE '%".$store_info->line2."%' or design_title LIKE '%".$store_info->store_title."%' )";
                    $this->db->or_where($where_store_vise);
                }
            } */
        if($store_id!='')
        {
            $where_store_vise="((store_id=$store_id OR store_id=0) AND ((custom_store_id LIKE '%#".$store_id."#%' AND design_access = 1) OR design_access=2))";
            $this->db->where($where_store_vise);
        }
        $this->db->select('id,base_price,custome_art_color,custome_terniaryart_color,custome_secondaryart_color');
        $this->db->where("id IN(".$stores_design_allowed.")");
        $this->db->where('no_design_on_product',0);
        //$this->db->order_by('order_by','ASC');
        $this->db->order_by('store_id','desc');
        $this->db->order_by('id','RANDOM');
        $this->db->where('status',1);
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->row();
        else  
            return FALSE;
    }




    public function get_random_design_result($category_id='',$product_id='',$design_sub_category_id='',$design_checked_for_store='',$store_id='',$get_random_design_result='',$all_design=''){
        
        if($get_random_design_result){
            $put_where_con="(product_side=$get_random_design_result OR product_side=3)";
        }    
        else{
            $put_where_con="(product_side=1 OR product_side=3)";
        }
        $this->db->where($put_where_con);
        $where_store_vise="((store_id=$store_id OR store_id=0) AND ((custom_store_id LIKE '%#".$store_id."#%' AND design_access = 1) OR design_access=2))";
        $this->db->where($where_store_vise);
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->where('store_category_id',$where_in);
        }
        
        $b='';
        $c='';
        if(!empty($design_sub_category_id)){
            $where_in='#'.$design_sub_category_id.'#';
            $b="design_sub_category  LIKE '%".$where_in."%'";
        }
        else{
            if(!$all_design){
            $this->db->where('designs_front_allowed',1);}
        }
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%'";
        }
        if($b && $c){
            $this->db->where("($b AND $c)");
        }
        elseif($b){
            $this->db->where($b);
        }
        elseif($c){
            $this->db->where($c);
        }
        
        $this->db->where("id IN(".$design_checked_for_store.")");
        $this->db->where('no_design_on_product',0);
        $this->db->order_by('id','RANDOM');
        $this->db->where('status',1);
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }
    


    public function get_random_design_product($category_id='',$product_id='',$design_sub_category_id='',$design_checked_for_store='',$store_id='',$get_random_design_result='',$all_design='',$store_uniform_design_id='',$uniform=''){
        
        if($get_random_design_result==4 || $get_random_design_result==5 || $get_random_design_result==6)
        {
            $put_where_con="(product_side_1 like '%$get_random_design_result%' )";
        }else if($get_random_design_result){
            $put_where_con="(product_side=$get_random_design_result OR product_side=3)";
        }    
        else{
            $put_where_con="(product_side=1 OR product_side=3)";
        }
        $this->db->where($put_where_con);
        if(empty($store_uniform_design_id))
        {
            
        $where_store_vise="((store_id=$store_id OR store_id=0) AND ((custom_store_id LIKE '%#".$store_id."#%' AND design_access = 1) OR design_access=2))";
        $this->db->where($where_store_vise);
        }
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->where('store_category_id',$where_in);
        }
        
        $b='';
        $c='';
        if(!empty($design_sub_category_id)){
            $where_in='#'.$design_sub_category_id.'#';
            $b="design_sub_category  LIKE '%".$where_in."%'";
        }
        else{
            if(!$all_design){
            $this->db->where('designs_front_allowed',1);}
        }
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%'";
        }
        if($b && $c){
            $this->db->where("($b AND $c)");
        }
        elseif($b){
            $this->db->where($b);
        }
        elseif($c){
            $this->db->where($c);
        }
        if($uniform!='')
        {
            $this->db->where('uniform_design', 0);
        
        }
        /* $store_info=array();
        if($store_id!='')
            $store_info=get_store_info($store_id);
        if(!empty($store_info))
        {
            if($store_info->store_category_id==5 && $store_info->store_type==1)
            {
                $where_store_vise="(design_title LIKE '%".$store_info->line1."%' or  design_title LIKE '%".$store_info->line2."%' or design_title LIKE '%".$store_info->store_title."%' )";
                $this->db->or_where($where_store_vise);
            }
        } */
    
        $this->db->select('id');
        $this->db->where_not_in('store_category_id',$where_in);
        if(!empty($store_uniform_design_id))
        {
            $design_ids=explode(',',$store_uniform_design_id);
            $this->db->where_in('id',$design_ids);
        }else{
            $this->db->where("id IN(".$design_checked_for_store.")");
        }
        $this->db->where('no_design_on_product',0);
        $this->db->order_by('store_id','desc');
        $this->db->order_by('id','RANDOM');
        $this->db->where('status',1);
        $query=$this->db->get('designs');
        //echo $this->db->last_query();
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }


    public function getrandomdesignproduct($category_id='',$product_id='',$design_sub_category_id='',$design_checked_for_store='',$store_id='',$get_random_design_result='',$all_design=''){
        
        if($get_random_design_result){
            $put_where_con="(product_side=$get_random_design_result OR product_side=3)";
        }    
        else{
            $put_where_con="(product_side=1 OR product_side=3)";
        }
        $this->db->where($put_where_con);
        $where_store_vise="((store_id=$store_id OR store_id=0) AND ((custom_store_id LIKE '%#".$store_id."#%' AND design_access = 1) OR design_access=2))";
        $this->db->where($where_store_vise);
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->where('store_category_id',$where_in);
        }
        
        /*$b='';
        $c='';
        if(!empty($design_sub_category_id)){
            $where_in='#'.$design_sub_category_id.'#';
            $b="design_sub_category  LIKE '%".$where_in."%'";
        }
        else{*/
            if(!$all_design){
                $this->db->where('designs_front_allowed',1);
            }
        /*}*/
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%'";
            $this->db->where($c);
        }
        /*if($b && $c){
            $this->db->where("($b OR $c or `designs_front_allowed`=1)");
        }
        elseif($b){
            $this->db->where("($b or `designs_front_allowed`=1)");
        }
        elseif($c){
            $this->db->where("($c or `designs_front_allowed`=1)");
        }*/
        //$this->db->where_OR('designs_front_allowed',1);
        $this->db->where("id IN(".$design_checked_for_store.")");
        $this->db->select('id');
        $this->db->where('status',1);
        $this->db->where('no_design_on_product',0);
        $this->db->order_by('store_id','desc');
        $this->db->order_by('id','RANDOM');
        //$this->db->order_by('id','desc');
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function checkdesigntype($design_checked_for_store='',$product_id='',$category_id=''){
        
        
        
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->where('store_category_id',$where_in);
        }
        
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%' AND design_type LIKE '%8%'";
            $this->db->where($c);
        }
        $this->db->where("id IN(".$design_checked_for_store.")");
        $this->db->select('id');
        $this->db->where('status',1);
        $this->db->where('no_design_on_product',0);
        $this->db->order_by('store_id','desc');
        $this->db->order_by('id','RANDOM');
        //$this->db->order_by('id','desc');
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_relavent_color($rgb){
        $this->db->where('color_code_rgb',$rgb);
        $query=$this->db->get('color_palette');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    public function get_revalent_bulk_product_image($product_id='',$color_array='',$block_id=''){
        $this->db->where('product_id',$product_id);
         if($color_array)
         { 
          $this->db->where_in('color_name',$color_array);
         }
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_in('id',$block_id);
         }
        $this->db->select('id,product_color_additional_price');

        $this->db->order_by('id', 'desc');
        //$this->db->order_by('rand()');

        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
    //    echo $this->db->last_query().'<br>';
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    public function get_block_product_image($product_id='',$block_id)
    {
        $this->db->where('product_id',$product_id);
        if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        $this->db->select('id');
        $this->db->order_by('id', 'desc');
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
        if($query->num_rows()>0)
        {
            $result=$query->result();
            $result = array_map('current', $result);
            return implode(',',$result);
        }else
            return FALSE;
    }

    public function get_revalent_product_image($product_id='',$color_array='',$block_id=''){
        $this->db->where('product_id',$product_id);
         if($color_array)
         { 
          $this->db->where_in('color_name',$color_array);
         }
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        $this->db->select('id,product_color_additional_price');

        $this->db->order_by('id', 'desc');
        //$this->db->order_by('rand()');

        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
    //    echo $this->db->last_query().'<br>';
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }

    public function get_revalent_product_bulk_image_rand($product_id='',$block_id=''){
        
        $this->db->where('product_id',$product_id);
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_in('id',$block_id);
         }
        $this->db->order_by('order_by', 'asc');
        //$this->db->order_by('rand()');
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }

    public function get_revalent_product_image_rand($product_id='',$block_id=''){
        
        $this->db->where('product_id',$product_id);
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        $this->db->order_by('order_by', 'asc');
        //$this->db->order_by('rand()');
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



    public function get_revalent_product_image_result($product_id='',$block_id=''){
        
        $this->db->where('product_id',$product_id);
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        $this->db->order_by('order_by', 'asc');
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_row_like($table_name='', $id_array='',$columns=array(),$order_by=array()){
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where_in($key, $value);
            }
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



    public function check_random_design_product($design_id='',$product_id='',$store_category_id='',$uniform=''){
        
        if(!empty($store_category_id)){
            $this->db->where('store_category_id',$store_category_id);
        }

        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $this->db->like('product_id_allowed',$where_in);
        }
        if($uniform==0)
        {
            $this->db->where('uniform_design',$uniform);
        }
        $this->db->select('id');
        $this->db->where('status',1);
        $this->db->where('id',$design_id);
        $query=$this->db->get('designs');
        
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



    public function stores_products_infopage($stores_products='',$main_category='',$category='',$sub_category='')
    {
        $this->db->where("id IN(".$stores_products.")");
        $this->db->where('status',1);
        if(!empty($main_category)){
            $where_in=$sub_category;
            $this->db->where('main_category_id',$where_in);
        }
        if(!empty($category)){
            $where_in=$category;
            $this->db->where('category_id',$where_in);
        }
        if(!empty($sub_category)){
            $where_in=$main_category;
            $this->db->where('sub_category_id',$where_in);
        }
        $this->db->select('id,title,base_price');
        $this->db->order_by('id','RANDOM');
        $this->db->limit(1);
        $this->db->from('products');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



    public function stores_products_infopage_bycategory($stores_products='',$main_category='',$category='',$sub_category='',$product_type='')
    {
        $this->db->where("id IN(".$stores_products.")");
        $this->db->where('status',1);
        if(!empty($sub_category)){
            $where_in=explode(",",$sub_category);
            $this->db->where_in('sub_category_id',$where_in);
        }
        if(!empty($category) && empty($sub_category)){
            $where_in=explode(",",$category);
            $this->db->where_in('category_id',$where_in);
        }
        if(!empty($main_category) && empty($category) && empty($sub_category)){
            $where_in=explode(",",$main_category);
            $this->db->where_in('main_category_id',$where_in);
        }
        if($product_type!='')
        {
            $this->db->like('product_type','#'.$product_type.'#','both');
        }
        $this->db->select('id,title,base_price,design_type_id');
        $this->db->order_by('id','RANDOM');
        $this->db->limit(1);
        $this->db->from('products');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



    public function get_design_on_registration($category_id='',$product_id='',$registration_design_id=''){
        if(!empty($category_id)){
            $where_in=$category_id;
            $this->db->like('store_category_id',$where_in);
        }
        if(!empty($registration_design_id)){
            $where_in=str_replace(',',"','",$registration_design_id);
            $c="id IN('".$where_in."')";
            $this->db->where($c);
        }
        
        if(!empty($product_id)){
            $where_in='#'.$product_id.'#';
            $c="product_id_allowed LIKE '%".$where_in."%'";
            $this->db->where("($c)");
        }
        $this->db->limit(4);
        $this->db->order_by('id','RANDOM');
        $this->db->where('status',1);
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_result_bulk($offset,$per_page,$cate_id='')
    {
        if(!empty($cate_id)){
            $where_in=$cate_id;
            $this->db->like('bulk_category',$where_in);
        }
        $this->db->where('status',1);
        $where_store_vise="(products.product_type LIKE '%#2#%' or  products.product_type LIKE '%#3#%')";
        $this->db->where($where_store_vise);    
        $this->db->from('products');
        if($offset>=0 && $per_page>0){
            $this->db->limit($per_page,$offset);
            $this->db->order_by('order','ASC');
            $query = $this->db->get();
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
        }else{
            return $this->db->count_all_results();
        }
    }



    public function get_result_designs_withcustom($store_cat_id='',$store_id='')
    {        
        $where_store_vise="((store_id=$store_id OR store_id=0) AND ((custom_store_id LIKE '%#".$store_id."#%' AND design_access = 1) OR design_access=2))";
        $this->db->where($where_store_vise);
        $this->db->where('store_category_id',$store_cat_id);
        $this->db->where('status',1);
        $this->db->order_by('store_id','desc');

        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_search_result()
    {
          $this->db->select('id,store_title,store_category_id');
        $this->db->from('stores');
        $this->db->like('store_title', trim($_GET['query']));
        $this->db->where('store_status', 1);
        $this->db->where('store_type', 2);
         $this->db->where('is_bulk', 2);
        $this->db->where('is_affiliate', 2);
        $this->db->order_by('store_category_id');
        $query = $this->db->get();    
       if ($query->num_rows() > 0){
          return $query->result();
       } else{
           return FALSE;
       }
    }



      public function get_search_result_post()
      {
          $this->db->select('id,store_title,store_category_id,store_sub_category_id,store_sub_category_type_id,sub_category_fourth,store_link');
        $this->db->from('stores');
        $this->db->like('store_title', trim($_GET['query']));
        $this->db->where('store_status', 1);
        $this->db->where('store_type', 1);
        $this->db->where('is_affiliate !=', 1);
        $this->db->where('is_bulk !=', 1);
        $this->db->where('search_words_status', 1);
        $this->db->order_by('store_title','ASC');
        $this->db->order_by('store_category_id');
        $query = $this->db->get();    
       if ($query->num_rows() > 0){
          return $query->result();
       } else{
           return FALSE;
       }
      }
    public function get_search_result_store_affi($keyword,$category)
      {
          $this->db->select('first_position,stores.id,store_title,store_category_id,store_sub_category_id,store_sub_category_type_id,sub_category_fourth,store_link');
        $this->db->from('stores');
        $this->db->join('users','users.id=stores.user_id');
        $this->db->join('store_category','stores.store_category_id=store_category.id');
        $this->db->like('store_title', $keyword);
        $this->db->where('store_status', 1);
        $this->db->where('store_type', 2);
        $this->db->where('is_affiliate', 1);
        $this->db->where('search_words_status', 1);
        $this->db->where('store_category_id',$category);
        $this->db->where('store_category.status', 1);
        $this->db->order_by('first_position','ASC');
        $this->db->order_by('store_category_id');
        $query = $this->db->get();    
       if ($query->num_rows() > 0){
            return $query->result();
       } else{
           return FALSE;
       }
    }


      public function get_search_result_store($keyword)
      {
          $this->db->select('stores.id,store_title,store_category_id,store_sub_category_id,store_sub_category_type_id,sub_category_fourth,store_link');
        $this->db->from('stores');
        $this->db->join('users','users.id=stores.user_id');
        $this->db->join('store_category','stores.store_category_id=store_category.id');
        $this->db->like('store_title', $keyword);
        $this->db->where('store_status', 1);
        $this->db->where('store_type', 2);
        $this->db->where('is_affiliate !=', 1);
        $this->db->where('is_bulk !=', 1);
        $this->db->where('search_words_status', 1);
        $this->db->where('store_category.status', 1);
        $this->db->order_by('store_title','ASC');
        $this->db->order_by('store_category_id');
        $query = $this->db->get();    
       if ($query->num_rows() > 0){
          return $query->result();
       } else{
           return FALSE;
       }
    }




    public function get_row_bystoretitle()
    {
        $this->db->select('id');
        $this->db->from('stores');
        $this->db->where('store_title', trim($this->input->post('query')));
        $this->db->where('store_status', 1);
        $this->db->where('store_type', 2);
        $query = $this->db->get();    
           if ($query->num_rows() > 0){
          return $query->result();
           } else{
           return FALSE;
           }
      }


     
     public function get_discount($promo_code='',$order_total='')
    {
        $this->db->where('start_date <=', date('Y-m-d'));
        $this->db->where('end_date >=', date('Y-m-d'));
        $this->db->where('status', 1);
        $this->db->where('code', $promo_code);
        $this->db->where('min_amount <=',$order_total);
        $query=$this->db->get('coupons');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    public function get_discount_free($promo_code='',$order_total='')
    {
        $this->db->where('start_date <=', date('Y-m-d'));
        $this->db->where('end_date >=', date('Y-m-d'));
        $this->db->where('status', 1);
        $this->db->where('level', 6);
        $this->db->where('code', $promo_code);
        $this->db->where('min_amount <=',$order_total);
        $query=$this->db->get('coupons');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }



      public function bulk_product_calculation($bulk_calculation_type_id='',$quantity='',$row_id=''){
        if($row_id){
            $this->db->where('id !='.$row_id);
        }
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('bulk_calculation_type_id',$bulk_calculation_type_id);
        $this->db->from('bulk_product_calculation');
        $query = $this->db->get();
        
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
          }

        public function bulk_calculation($bulk_calculation_type_id='',$quantity='',$row_id=''){
        if($row_id){
            $this->db->where('id !='.$row_id);
        }
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('bulk_calculation_type_id',$bulk_calculation_type_id);
        $this->db->from('bulk_product_calculation');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
      }



      public function upload_image_gd($link){
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        
        curl_setopt_array($curl, 
            array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $link,
            CURLOPT_USERAGENT => 'Create and save image'
            )
        );
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
         //$ACurlError = curl_error($curl);
        curl_close($curl);
    }
    public function bulk_discount_calculation_design($product_id='',$quantity='',$row_id=''){
        $this->db->from('product_bulk_discount_design');
        if($row_id){
            $this->db->where('id !='.$row_id);
        }
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
      }


      public function bulk_discount_calculation($product_id='',$quantity='',$row_id=''){
        $this->db->from('product_bulk_discount');
        if($row_id){
            $this->db->where('id !='.$row_id);
        }
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
          }
          public function check_qty_exit($product_id='',$quantity=''){
        $this->db->from('product_bulk_discount');
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
          }
        public function check_qty_exit_design($product_id='',$quantity=''){
        $this->db->from('product_bulk_discount_design');
          $this->db->where('quantity_start <='.$quantity.' and quantity_end >='.$quantity);
          $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
          }
          public function shipping_rates($quantity='',$province=''){
        $this->db->from('shipping_calculation');
          $this->db->where('start_quantity <='.$quantity.' and end_quantity >='.$quantity);
        if($province!='')
        {
            $this->db->where('province',$province);
        }
        $query = $this->db->get();
        if($query->num_rows()>0)
            
            return $query->row();
        else
            return FALSE;
          }
          public function auto_shipping_rates($cart_total=''){
        $this->db->from('shipping_automative');
          $this->db->where('min_amount <='.$cart_total);
          $this->db->where('status',1);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
      }



      public function get_result_order($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit=''){
          $this->db->select('*');
        $this->db->from('store_category');      
          $this->db->order_by('registration_subscriber asc, category_name asc');    
          $query = $this->db->get();        
        
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_result_with_pagination($offset='', $per_page='',$tablename){
        $this->db->from($tablename);
        if($offset>=0 && $per_page>0){
            $this->db->limit($per_page,$offset);
            $this->db->order_by('id','desc');
            $query = $this->db->get();
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
        }else{
            return $this->db->count_all_results();
        }
    }



    public function escape_embroidery_product(){
        $this->db->where('status',1);
        $escape_embroidery_design="`design_type_id` !='#7#' AND `design_type_id` NOT LIKE'%#7#,%'";
        $this->db->where($escape_embroidery_design);
        $this->db->order_by('id', 'desc');
        $query=$this->db->get('products');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function checkimg($tablename='',$id=''){
        $query= $this->db->get_where($tablename, array('id' => $id));
        return $query->row();
    }



    /*    public function update_design_cus_test(){
            $cus_des="`store_id` > '0' AND `design_access`=1 AND custom_store_id=''";
            $this->db->where($cus_des);
            $query=$this->db->get('designs');
                if($query->num_rows()>0)
                    return $query->result();
                else
                    return FALSE;
          }    */

    public function check_exist_or_not($tablename='',$id=0){
         $this->db->where('id',$id);
         $this->db->from($tablename);
         $query = $this->db->get();         
         if($query->row()){             
             return true;
         }else{             
             return false;
         }
    } 



    public function store_banner_products_random($store_category_id='')
    {
        $this->db->where('store_category_id',$store_category_id);
        $this->db->where('status',1);
        $this->db->order_by('position','ASC');
        $this->db->order_by('id','RANDOM');
        $query=$this->db->get('store_banner_products');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;

    } 



    function updateStoreProductIdAdd($table='',$productID=''){
        

     $sql= "UPDATE `".$table."` SET `product_id_allowed` = CONCAT(`product_id_allowed`,',"."#".$productID."#"."')";
         
        if(!empty($_POST['type'])){
            $i=0;
            $sql.=' where ';
                foreach ($_POST['type'] as $value) {
                    if($i>0)
                    {
                        $sql.=' or ';
                    }
                    $con='"'.$value.'"';
                    $sql.="design_type like '%".$con."%'";
                    $i++;
                } 
            }

         $this->db->query($sql);     
    }
    function updateStoreProductIdApparelTemplate($table='',$productID=''){
     $sql= "UPDATE `".$table."` SET `product_id` = CONCAT(`product_id`,',"."#".$productID."#"."')";
     $this->db->query($sql);     
    }


    function updateStoreProductId($table='',$productID=''){
     $sql= "UPDATE `".$table."` SET `product_id_allowed` = CONCAT(`product_id_allowed`,',"."#".$productID."#"."')";
     $this->db->query($sql);     
    }


    
       function updateStoreDesignId($table='',$design_id='',$store_category_id=''){
      $sql= "UPDATE `".$table."` SET `design_id_allowed` = CONCAT(`design_id_allowed`,',"."#".$design_id."#"."') where store_category_id ='".$store_category_id."'";
      $this->db->query($sql);         
    }



    function removeProductIdStore($product_id=''){
        $sql= "UPDATE `stores` SET `product_id_allowed` = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', `product_id_allowed`, ','), ',"."#".$product_id."#"."', '')) WHERE FIND_IN_SET('#".$product_id."#', `product_id_allowed`)";
      $this->db->query($sql);         
    } 



    function removeProductIdDesign($product_id=''){
        $sql= "UPDATE `designs` SET `product_id_allowed` = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', `product_id_allowed`, ','), ',"."#".$product_id."#"."', '')) WHERE FIND_IN_SET('#".$product_id."#', `product_id_allowed`)";
      $this->db->query($sql);         
    }



    function removeDesignId($design_id=''){
        $sql= "UPDATE `stores` SET `design_id_allowed` = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', `design_id_allowed`, ','), ',"."#".$design_id."#"."', '')) WHERE FIND_IN_SET('#".$design_id."#', `design_id_allowed`)";
      $this->db->query($sql);         
    } 



    public function randomartwork($store_id='')
    {
        $this->db->where('status',1);
        $this->db->where('store_id',$store_id);        
        $this->db->select(" `designs`.`id` , (
                            SELECT  `stores`.`id` AS  'store_id'
                            FROM  `stores` 
                            WHERE  `stores`.`id` =  '".$store_id."'
                            AND  `stores`.`design_id_allowed` LIKE  '%`designs`.`id`%'
                    )");
        $this->db->limit(4);
        $this->db->order_by('id','RANDOM');
        $this->db->from('designs');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function check_product_block($store_id='', $product_color_id=''){
        $this->db->select('id');
        $where_store_vise="(product_color_blocked LIKE '%#".$product_color_id."#%')";
        $this->db->where($where_store_vise);
        $this->db->where('store_id',$store_id);
        $query=$this->db->get('stores_product_color_blocked');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function check_product_on_store($product_id='',$store_id=''){
        $where_store_vise="(product_id_allowed LIKE '%#".$product_id."#%')";
        $this->db->where($where_store_vise);
        $this->db->where('id',$store_id);
        $query=$this->db->get('stores');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_blog_categories()
    {
        $this->db->select('bc.id,bc.category_name,bc.category_slug');
        $this->db->from('blog_category as bc');
        $this->db->join('blogs as b','bc.id = b.category_id');
        $this->db->where('b.status',1);
        $this->db->where('bc.status',1);
        $this->db->where('bc.id>',0);
        $this->db->order_by('order','ASC');
        $this->db->group_by('b.category_id');
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_result_all_product($offset,$per_page,$cate_id='')
    {

        $this->db->select('products.*,product_colors.main_image_thumbnail,product_colors.id as p_color_id');
        if(!empty($cate_id)){
            $where_in=$cate_id;
            $this->db->like('products.bulk_category',$where_in);
        }
        if(!empty($_GET['cate'])){
            $this->db->like('products.category_id',$_GET['cate']);
        }
        if(!empty($_GET['mcate'])){
            $this->db->like('products.main_category_id',$_GET['mcate']);
        }
        if(!empty($_GET['scate'])){
            $this->db->like('products.sub_category_id',$_GET['scate']);
        }
        $this->db->where('products.status',1);
        $this->db->from('products');
        $this->db->join('product_colors','product_colors.product_id=products.id');
        if($offset>=0 && $per_page>0){
            $this->db->limit($per_page,$offset);
            $this->db->order_by('products.order','ASC');
            $query = $this->db->get();
            if($query->num_rows()>0)
            {    
                return $query->result();
            }else
                return FALSE;
        }else{
            return $this->db->count_all_results();
        }
    }



    public function check_product_availables($cat,$col){
        
        $this->db->select('id');
        $this->db->where('status',1);
        $where_store_vise="(product_type LIKE '%#1#%')";
        $this->db->where($where_store_vise);
        $this->db->where($col,$cat);
        //$where_store_vise="(".$col." LIKE '%".$cat."%')";
        //$this->db->where($where_store_vise);
        $query=$this->db->get('products');
        if($query->num_rows()>0)
        {

            return $query->result();
        }
        else
            return FALSE;
    }



    public function check_bulk_product_availables($cat,$col){
        
        $this->db->select('id');
        $this->db->where('status',1);
        $where_store_vise="(product_type LIKE '%#3#%')";
        $this->db->where($where_store_vise);
        $this->db->where($col,$cat);
        //$where_store_vise="(".$col." LIKE '%".$cat."%')";
        //$this->db->where($where_store_vise);
        $query=$this->db->get('products');
        if($query->num_rows()>0)
        {

            return $query->result();
        }
        else
            return FALSE;
    }



    public function get_random_product_color($table_name='', $id_array='',$columns=array(),$order_by=array(),$where_in=array()){
        //echo $table_name;
        //print_r($where_in);die;
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            }
        endif;
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            } 
        endif;
        /*if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        */
        $this->db->order_by('rand()');
        $query=$this->db->get($table_name);
        //echo '<pre>';$this->db->last_query();die;
        if($query->num_rows()>0)
        {
            return $query->row();
        }else
            return FALSE;
    }
    


    public function get_design_by_slider($design_id=''){
    
        $this->db->select('id','design_file_thumbnail_small','design_title');
        if(!empty($design_id)){
            $where_in=explode(",",$design_id);
            $this->db->where_in('id',$where_in);
        }
        
        //$this->db->where('status',1);
        $query=$this->db->get('designs');
        $this->db->limit(4);
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_user_commission_total($store_id='',$startdate='',$end_date='')
    {   
        if($store_id!=''){
            $this->db->like('sc.store_id',trim($store_id));
        }
        if($startdate!='' && $end_date!=''){        
            $start_date='';
            $end_date=$end_date;  

            $end_d=date('Y-m-d',strtotime($end_date . "+1 days"));        
                
            $start_date=date('Y-m-d',strtotime($startdate));
            $end_date=date('Y-m-d',strtotime($end_date));        
            $this->db->where('sc.date_time >=', $start_date);
            $this->db->where('sc.date_time <=', $end_d);
        }
        $this->db->select('sc.*, SUM(sc.balance_recevied) as balance_recevied');
        $this->db->where('sc.user_id',store_admin_id()); 
        $this->db->group_by('sc.order_id');
        $this->db->from('store_commissions as sc');
        $this->db->order_by('sc.id','DESC');
        $query=$this->db->get();
        if($query->num_rows()>0) {
                return $query->result();
            }
            else
                return FALSE;
    }



    public function get_sale_ordre_total($store_id='',$startdate='',$end_date='')
    {   
        if($store_id!=''){
            $this->db->like('oi.store_id',trim($store_id));
        }
        if($startdate!='' && $end_date!=''){        
            $start_date='';
            $end_date=$end_date;  

            $end_d=date('Y-m-d',strtotime($end_date . "+1 days"));        
                
            $start_date=date('Y-m-d',strtotime($startdate));
            $end_date=date('Y-m-d',strtotime($end_date));        
            $this->db->where('oi.created >=', $start_date);
            $this->db->where('oi.created <=', $end_d);
        }
        $this->db->select('oi.*, SUM(oi.sub_total_discount) as total');
        $this->db->group_by('oi.store_id');
        $this->db->from('order_items as oi');
        $this->db->join('orders as or','oi.order_id=or.order_id');
        $this->db->where('or.order_status !=',9);
        $this->db->order_by('oi.id','DESC');
        $query=$this->db->get();
        
        if($query->num_rows()>0) {
                return $query->result();
            }
            else
                return FALSE;

    }



    public function get_result_state($table_name='', $id_array='',$columns=array(),$order_by=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            } 
        endif;    
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            }
        endif;

        $query=$this->db->get($table_name);
        
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_sale_ordre_store($order_id='',$store_id='')
    {   
        if($store_id!=''){
            $this->db->like('oi.store_id',trim($store_id));
        }
        if($order_id!=''){
            $this->db->like('oi.order_id',trim($order_id));
        }
        $this->db->select('SUM(oi.sub_total_discount) as total');
        $this->db->group_by('oi.order_id');
        $this->db->from('order_items as oi');
        $this->db->order_by('oi.id','DESC');
        $query=$this->db->get();
        
        if($query->num_rows()>0) {
                $result=$query->row();
                return $result->total;
            }
            else
                return '0.00';

    }



    public function taxfetch($province){
        $this->db->from('tax');
        $this->db->where('tax_id',$province);
        $this->db->where('status','1');
        $query = $this->db->get();
        if($query->num_rows()>0)
        {    
            $result=$query->row();
            $this->db->from('tax');
            $this->db->where('province',$result->province);
            $this->db->where('status','1');
            $query = $this->db->get();
            if($query->num_rows()>0)
                return $query->result();
            else 
                return false;
        }
        else
            return FALSE;
      }



    public function province($provice_name=''){
        $this->db->order_by('province','asc');
        $this->db->distinct();
        $this->db->select('province,tax_id');
        $this->db->from('tax');
        $this->db->where('parent_id','0');
        $this->db->where('status','1'); 
        if($provice_name!='')
            $this->db->where('province',$provice_name);
        $query = $this->db->get();
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_result_store($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            } 
        endif;    
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            }
        endif;
        if(!empty($limit) && $limit!=''):    
            $this->db->limit($limit);
        endif;    
        $this->db->where('old_store_id is',NULL);
        $this->db->where('id !=','504447');
        $query=$this->db->get($table_name);
    
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    public function get_result_design($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$where_in=array()){
        
        if(!empty($columns)):
            $all_columns = implode(",", $columns);
            $this->db->select($all_columns);
        endif;
        if(!empty($order_by)):            
            $this->db->order_by($order_by[0], $order_by[1]);
        endif; 
        if(!empty($id_array)):        
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
            } 
        endif;    
        if(!empty($where_in)):        
            foreach ($where_in as $key => $value){
                $this->db->where_in($key, $value);
            }
        endif;
        if(!empty($limit) && $limit!=''):    
            $this->db->limit($limit);
        endif;    
        $this->db->where('old_design_id is',NULL);
        $query=$this->db->get($table_name);
    
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }



    function getorderdetails($id)
    {
        $this->db->select('*');
        $this->db->where('orders.order_id',$id);
        $this->db->join('buyers','orders.buyer_id=buyers.id'); 
        $query=$this->db->get('orders');
        if($query->num_rows()>0)
        {    
            return $query->row();
            
        }else
            return false;
    }

    function get_track_order_report($id)
    {
        $this->db->select('orders.order_id,orders.created,orders.order_status,orders.order_note,b.billing_first_name,b.billing_last_name,b.billing_email,b.billing_contact_no');
        $this->db->where_not_in('orders.order_status',array(3,5,9,11));
        $this->db->where_in('orders.order_id',explode(',',$id));
        $this->db->join('buyers as b','orders.buyer_id=b.id'); 
        $query=$this->db->get('orders');
        if($query->num_rows()>0)
        {    
            return $query->result();
            
        }else
            return false;
    }

    function getorderItemId($id)
    {
        $this->db->select('order_items.id,orders.order_id');
        $this->db->where('orders.old_order_id is',NULL);
        $this->db->where('orders.old_order_id',$id);
        $this->db->join('order_items','order_items.order_table_id=orders.id'); 
        $query=$this->db->get('orders');
        if($query->num_rows()>0)
        {    
            return $query->row();
            
        }else
            return false;
    }
    


    function totalEarncommission($store_id)
    {
        $this->db->select('sum(commission_amt) as amt');
        $this->db->from('commission_bal_paid_history');
        $this->db->where('store_id',$store_id);
        $this->db->where('status',1);
        $query=$this->db->get()->row();
        return $query->amt;
    }


    function totalPaidcommission($store_id)
    {
        $this->db->select('sum(paid_amt) as amt');
        $this->db->from('commission_bal_paid_history');
        $this->db->where('store_id',$store_id);
        $this->db->where('status',2);
        $query=$this->db->get()->row();
        return $query->amt;
    }


    public function total_affiliate_earn_commissions($affiliate_user_id=''){
        
        $this->db->select('SUM(store_commissions.balance_recevied) AS total_affiliate_store_commission, SUM(store_commissions.affiliate_balance_recevied) AS total_affiliate_my_commission');
        $this->db->from('store_commissions');
        $this->db->join('users', 'store_commissions.user_id = users.id', 'inner');
        $this->db->where('users.affiliate_user_id', $affiliate_user_id);
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            return $query->row();
        }
        else{
            return '0.00';
        }
    }


    public function get_affiliate_user(){
        
        $this->db->select('count(*) as total_affiliate_user');
        $this->db->from('users');   
        $this->db->where('user_role', '3');
        $this->db->where('status', '1');            
        $query = $this->db->get();

        if($query->num_rows()>0){
            $row = $query->row();
            return $row->total_affiliate_user;
        }else{
            return FALSE;
        }
    }


    public function get_affiliate_store_category(){
        
        $this->db->select('count(*) as total_affiliate_store_category');
        $this->db->from('store_category');   
        $this->db->where('registration_subscriber', '3');
        $this->db->where('status', '1');            
        $query = $this->db->get();

        if($query->num_rows()>0){
            $row = $query->row();
            return $row->total_affiliate_store_category;
        }else{
            return FALSE;
        }
    }

    public function total_affiliated_my_commissions(){
        $sum = 0;

        $this->db->select('SUM(store_commissions.affiliate_balance_recevied) AS total_affiliate_my_commission');
        $this->db->from('store_commissions');
        $this->db->join('users', 'store_commissions.user_id = users.id', 'inner');
        $this->db->group_by('users.affiliate_user_id');
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            $result = $query->result();
            foreach ($result as $row) {
                $sum = $sum + $row->total_affiliate_my_commission;
            }
            return $sum;
        }
        else{
            return '0.00';
        }
    }


    public function total_affiliate_store_commissions(){
        $sum = 0;

        $this->db->select('SUM(store_commissions.balance_recevied) AS total_affiliate_store_commission');
        $this->db->from('store_commissions');
        $this->db->join('users', 'store_commissions.user_id = users.id', 'inner');
        $this->db->group_by('store_commissions.affiliate_balance_recevied');
       $this->db->where('store_commissions.affiliate_balance_recevied >',0);
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            $result = $query->result();
            foreach ($result as $row) {
                $sum = $sum + $row->total_affiliate_store_commission;
            }
            return $sum;
        }
        else{
            return '0.00';
        }
    }
    function get_designId($store_cat_id,$design)
    {
        $this->db->where_in('id',$design);
        $this->db->where('store_category_id',$store_cat_id);
        $query=$this->db->get('designs');
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return FALSE;
        }
    } 
    function get_productId($id,$productColor)
    {
        $this->db->where_in('id',$productColor);
        $this->db->where('product_id',$id);
        $query=$this->db->get('product_colors');
        
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return FALSE;
        }
    }
    function get_uniform_product_exit($cate_id)
    {
    
        $this->db->from('bulk_product_price as bp');
        $this->db->where('bp.status',1);
        $this->db->where('bp.store_category_id',$cate_id);
        $this->db->join('bulk_store_category as sc','sc.id=bp.product_category');
        $this->db->where('sc.status',1);
        $query=$this->db->get();
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return FALSE;
        }
    }
    function get_uniform_main_category($cate_id)
    {
        $this->db->select('su.product_main_category_id,sc.*');
        $this->db->distinct('su.product_main_category_id');
        $this->db->from('store_uniform as su');
        $this->db->where('su.status',1);
        $this->db->where('su.store_category_id',$cate_id);
        $this->db->join('product_main_category as sc','sc.id=su.product_main_category_id');
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return FALSE;
        }
    }
    function get_uniform_sub_category($cate_id,$pcategory_id)
    {
        $this->db->select('su.product_category_id,sc.*');
        $this->db->distinct('su.product_category_id');
        $this->db->from('store_uniform as su');
        $this->db->where('su.store_category_id',$cate_id);
        $this->db->where('su.product_main_category_id',$pcategory_id);
        $this->db->join('product_category as sc','sc.id=su.product_category_id');
        $query=$this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return FALSE;
        }
    }
    public function get_unifrom_price($product_id,$store_category_id='')
    {
        $this->db->select('p.discount_price,p.title,p.id,si.base_price,p.back_printing,p.left_printing,p.right_printing,p.top_printing');  
        $this->db->where("si.store_category_id",$store_category_id);
        $this->db->where("si.product_id",$product_id);
        $this->db->where('p.status',1);
        $this->db->from('store_uniform as si');
        $this->db->where('si.status',1);
        $this->db->join('products as p','p.id=si.product_id');
        $query = $this->db->get();  
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    
    }
    public function stores_product_uniform($offset,$per_page,$store_category_id='')
    {
        
        if(!empty($_GET['pc2']) && empty($_GET['pc3'])){
            $this->db->where_in('si.product_category_id',$_GET['pc2']);
        }
        if(!empty($_GET['pc1']) && empty($_GET['pc2']) && empty($_GET['pc3'])){
            $this->db->where_in('si.product_main_category_id',$_GET['pc1']);
        }
        $this->db->select('products.*,si.id as si_id,si.product_color_ids,si.product_design_id,si.base_price as base_price_uniform');  
        $this->db->where("FIND_IN_SET('#4#',products.product_type) !=", 0);
        $this->db->or_where("FIND_IN_SET('#1#',products.product_type) !=", 0);
        $this->db->where("si.store_category_id",$store_category_id);
        $this->db->where('products.status',1);
        $this->db->from('store_uniform as si');
        $this->db->where('si.status',1);
        $this->db->join('products','products.id=si.product_id');
        
        if($offset>=0 && $per_page>0){
            $this->db->limit($per_page,$offset);
            $this->db->order_by('products.order','ASC');
            $query = $this->db->get();
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
        }else{
            return $this->db->count_all_results();
        }
    }
    public function get_revalent_product_uniform_image($product_id='',$color_array='',$block_id='',$color_id=''){
        $this->db->where('product_id',$product_id);
         if($color_array)
         { 
          $this->db->where_in('color_name',$color_array);
         }
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        $this->db->select('id,product_color_additional_price');

        $this->db->order_by('id', 'desc');
        //$this->db->order_by('rand()');
        if(!empty($color_id))
        {
            $product_color_ids=explode(',',$color_id);
            $this->db->where_in('id',$product_color_ids);
        }
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
    //    echo $this->db->last_query().'<br>';
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    public function get_revalent_product_uniform_image_rand($product_id='',$block_id='',$color_id=''){
        
        $this->db->where('product_id',$product_id);
         if($block_id){
             $block_id=explode(',', str_replace('#','',$block_id));
             $this->db->where_not_in('id',$block_id);
         }
        if(!empty($color_id))
        {
            $product_color_ids=explode(',',$color_id);
            $this->db->where_in('id',$product_color_ids);
        }     
        $this->db->order_by('order_by', 'asc');
        //$this->db->order_by('rand()');
        $this->db->where('status',1);
        $query=$this->db->get('product_colors');
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    function get_total_gift_balance($user_id)
    {
        $this->db->select('sum(amount) as amt');
        $this->db->where_in('used_user_id',$user_id);
        $query=$this->db->get('gift_order_detail');
        if($query->num_rows()>0){
            $result=$query->row();
            return $result->amt;
        }else{
            return '0.00';
        }
    }
    function get_total_gift_used_balance($user_id)
    {
        $this->db->select('sum(amount) as amt');
        $this->db->where_in('user_id',$user_id);
        $query=$this->db->get('gift_card_used_history');
        if($query->num_rows()>0){
            $result=$query->row();
            return $result->amt;
        }else{
            return '0.00';
        }
    }
    function get_order_comment($order_id)
    {
        $this->db->select('comment');
        $this->db->where_in('order_id',$order_id);
        $query=$this->db->get('order_comments');
        $comment='';
        if($query->num_rows()>0){
            $result=$query->result();
            foreach($result as $row)
            {
                $comment.=$row->comment.', ';
            }
            return $comment;
        }else{
            return $comment;
        }
    }

    function get_PromoCode_of_itemDetails($item_id)
    {
        $this->db->select('promo_code, used_status');
        $this->db->where_in('gift_item_id',$item_id);
        $query=$this->db->get('gift_order_detail');
        if($query->num_rows()>0){

            $result=$query->result();
            $numItems = count($result);
            $i = 0;

            foreach ($result as $row) {
                echo $row->promo_code." / ";
                if($row->used_status==1){
                    echo "<b>Applied</b>";
                }else{
                    echo "<b>Unused</b>";
                }
                if(++$i != $numItems) {
                    echo "<b> , </b>";
                }
            }
        }else{
            return false;
        }
    }
    public function all_design_disable_fields($design=array())
    {
        $this->db->select('id,limittoset_line1,limittoset_line2,enable_line1,enable_line2,enable_string,enable_year,enable_number,no_design_on_product');
        $this->db->where_in('id',$design);
        $this->db->order_by('order_by', 'asc'); 
        $this->db->where('status',1);
        $query=$this->db->get('designs');
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
    }


    public function get_product_disccount($product_id='')
    {
        
        $this->db->select('pc.price as product_category_dis,psc.price as product_sub_category_dis');
        $this->db->where('products.status',1);
        $this->db->from('products');
        $this->db->where('products.id',$product_id);
        $this->db->join('product_category as pc','products.category_id=pc.id');
        $this->db->join('product_sub_category as psc','products.sub_category_id=psc.id');
        $query = $this->db->get();
        if($query->num_rows()>0){
            $result=$query->row();
            if($result->product_sub_category_dis>0)
                return $result->product_sub_category_dis;
            else if($result->product_category_dis>0)
                return $result->product_category_dis;
            else 
                return FALSE;
        }
        else
            return FALSE;
        
    }
    public function get_result_count($table_name='', $store_id='')
    {
        $this->db->select('*');        
        $this->db->from($table_name);
        $this->db->where('store_id',$store_id);    
        $query = $this->db->get();
        if($query->num_rows()>0){
            $result=$query->num_rows();            
                return $result;
        }
        else
            return FALSE;        
    }
}
