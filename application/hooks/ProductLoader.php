<?php
class ProductLoader
{
    function initialize() {

        $ci =& get_instance();
        $seg1 = $ci->uri->segment(1);
        $seg2 = $ci->uri->segment(2);
        $seg3 = $ci->uri->segment(3);

        
        if(($seg1=='p') || ($seg1=='page') || ($seg1=='account') || ($seg1=='cart') || ($seg1=='category') || ($seg1=='order') || ($seg1=='products') || ($seg1=='support') || ($seg1=='seller' && $seg2=='orders') || ($seg1=='seller' && $seg2=='report') || ($seg1=='behindthescreen') || ($seg1=='backend')){

            if($seg1!='backend' && $seg2!='common'){
                if(site_access()===FALSE){
                    $ci->session->set_flashdata('msg_warningsss','You will able to <b>access the whole website as soon</b>, Sorry for inconvience'); 
                    redirect(base_url());
                }
            }
        }

        /*check proiduct category session data*/
        if (($seg2!='products' || $seg2!='seller') && ($seg3!='product_category' || $seg3!='edit_product_category' || $seg3!='product_basic_info' || $seg3!='edit_product_basic_info' || $seg3!='product_variations' || $seg3!='product_offer' || $seg3!='product_other_info' || $seg3!='product_images' || $seg3!='product_descriptions' || $seg3!='product_keywords' || $seg3!='product_seo')) {
            $ci->session->unset_userdata('productcat_info');
        }
    }
}