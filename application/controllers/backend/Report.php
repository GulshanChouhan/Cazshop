<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("seller_model");
        $this->load->model("Common_model");
        
    }
    private function _check_login() {
        if (superadmin_logged_in() === FALSE) redirect('behindthescreen');
    }
    public function orders($offset = 0) {
        $this->_check_login(); //check login authentication
        $data['title'] = "Orders Report";
        $search = array();
        if (!empty($_GET)) {
            if (!empty($_GET['title'])) $search[] = ' od.product_details like "%' . trim($_GET['title']) . '%"';
            if (!empty($_GET['order_id'])) $search[] = ' o.order_id = "' . trim($_GET['order_id']) . '"';
            if (!empty($_GET['user_name'])) $search[] = ' (o.shipping_address like "%' . trim($_GET['user_name']) . '%")';
            if (!empty($_GET['getstatus'])) $search[] = ' (od.order_status like "%' . trim($_GET['getstatus']) . '%")';
            if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) $search[] = 'DATE_FORMAT(o.created, "%Y-%m-%d")>="' . trim($_GET['start_date']) . '" and DATE_FORMAT(o.created, "%Y-%m-%d")<="' .trim($_GET['end_date']) . '"';
            if (!empty($_GET['seller_id'])) $search[] = 'od.seller_id ="' . trim($_GET['seller_id']) . '"';
        }
        $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, "", "", 0);
        $config = backend_pagination(); 
        $config['base_url'] = base_url() . 'backend/report/orders';
        $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, "", "", 0);
        $config['per_page'] = PER_PAGE;
        $config['uri_segment'] = 4;
        if (!empty($_SERVER['QUERY_STRING'])) $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        else $config['suffix'] = '';

        $config['first_url'] = $config['base_url'].$config['suffix'];
        if ((int)$offset < 0) {
            $this->session->set_flashdata('msg_warning', 'Something Went Wrong. Please try again');
            redirect($config['base_url']);
        } else if ($config['total_rows'] < $offset) {
            $this->session->set_flashdata('msg_warning', 'Something Went Wrong. Please try again');
            redirect($config['base_url']);
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['template'] = 'backend/Report/orders';
        $data['offset'] = $offset;
        $data['status'] = ''; //$status;
        $this->load->view('templates/superadmin_template', $data);
    }


    public function inventory($offset = 0) {
        $this->_check_login(); //check login authentication
        $data['title'] = "Inventory Report";
        $search = array();
        if (!empty($_GET)) {
            if (!empty($_GET['title'])) $search[] = ' pi.title like "%' . trim($_GET['title']) . '%"';
            if (!empty($_GET['category_id'])) $search[] = ' pi.category_id like "%' .trim($_GET['category_id']) . '%"';
            if (!empty($_GET['product_type'])) $search[] = ' pv.type_of_product = "' . trim($_GET['product_type']) . '"';
            if (!empty($_GET['status'])) $search[] = ' pv.status = "' . trim($_GET['status']) . '"';
            if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) $search[] = 'DATE_FORMAT(pi.created_at, "%Y-%m-%d")>="' . trim($_GET['start_date']) . '" and DATE_FORMAT(pi.created_at, "%Y-%m-%d")<="' . trim($_GET['end_date']) . '"';
            if (!empty($_GET['minquantity']) && !empty($_GET['maxquantity'])) $search[] = 'pv.quantity BETWEEN "' . trim($_GET['minquantity']) . '" and "' . trim($_GET['maxquantity']) . '"';
            if (!empty($_GET['seller_id'])) $search[] = ' pv.seller_id like "%' . trim($_GET['seller_id']) . '%"';
        }
        $data['products'] = $this->common_model->get_productresult($offset, PER_PAGE, $search);
        $config = backend_pagination();
        $config['base_url'] = base_url() . 'backend/Report/inventory';
        $config['total_rows'] = $this->common_model->get_productresult(0, 0, $search);
        $config['per_page'] = PER_PAGE;
        $config['uri_segment'] = 4;
        if (!empty($_SERVER['QUERY_STRING'])) $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        else $config['suffix'] = '';

        $config['first_url'] = $config['base_url'].$config['suffix'];
        if ((int)$offset < 0) {
            $this->session->set_flashdata('msg_warning', 'Something Went Wrong. Please try again');
            redirect($config['base_url']);
        } else if ($config['total_rows'] < $offset) {
            $this->session->set_flashdata('msg_warning', 'Something Went Wrong. Please try again');
            redirect($config['base_url']);
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['template'] = 'backend/Report/inventory';
        $data['offset'] = $offset;
        $this->load->view('templates/superadmin_template', $data);
    }
    public function exportCSV($offset = 0) {
       // $this->_check_login(); //check login authentication
        $search = array();
        // get data
        if (!empty($_GET)) {
            if (!empty($_GET['title'])) $search[] = ' od.product_details like "%' . trim($_GET['title'] ). '%"';
            if (!empty($_GET['order_id'])) $search[] = ' o.order_id = "' . trim($_GET['order_id']) . '"';
            if (!empty($_GET['user_name'])) $search[] = ' (o.shipping_address like "%' . trim($_GET['user_name']) . '%")';
            if (!empty($_GET['getstatus'])) $search[] = ' (od.order_status like "%' . trim($_GET['getstatus']) . '%")';
            if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) $search[] = 'DATE_FORMAT(o.created, "%Y-%m-%d")>="' . trim($_GET['start_date']) . '" and DATE_FORMAT(o.created, "%Y-%m-%d")<="' .trim($_GET['end_date']). '"';
        }
        $usersData = $this->common_model->get_orderInfo(0, 10000000000, $search, "", "", 0, "export");
        if ($usersData) {
            $hedare = array("Order ID", "Product Title", "Buyer Information", "Grand Total", "Method", "Order Date", "Status");
            //load our new PHPExcel library
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Order Export');
            // To set password for sheet
            // $this->excel->getActiveSheet()->getProtection()->setPassword(EXCELPASSWORD);
            // To make sheet protected
            $this->excel->getActiveSheet()->getProtection()->setSheet(true);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle('A1', 'B1')->getFont()->setBold(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
            $letters = range('A', 'Z');
            $count = 0;
            $cell_name = "";
            foreach ($hedare as $tittle) {
                $cell_name = $letters[$count] . "1";
                $column_name = $letters[$count];
                $count++;
                $value = $tittle;
                //$objPHPExcel->getActiveSheet()->SetCellValue($cell_name, $value);
                // Make bold cells
                $this->excel->getActiveSheet()->getStyle($cell_name)->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle($cell_name)->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getColumnDimension($column_name)->setWidth(20);
                if ($count > 1) {
                    // To set the column of the sheet editable ex: all I and J column are editable here
                    $this->excel->getActiveSheet()->getStyle("I$count:J$count")->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }
            }
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(22);
            $data = array();
            foreach ($usersData as $getvalue) {
                if (isset($getvalue['order_id'])) {

                    if($getvalue['currency_type']==1){
                      $totalsubtotalGross = $getvalue['subtotal'] * $getvalue['currency_amount_in_ethereum'];
                    }else if($getvalue['currency_type']==2){
                      $totalsubtotalGross = $getvalue['subtotal'] * $getvalue['currency_amount_in_bitcoin'];
                    }else{
                      $totalsubtotalGross = $getvalue['subtotal'] * $getvalue['currency_amount_in_dollor'];
                    }

                    $method = ucfirst(getCurrency($getvalue['currency_type']));
                    $shipping_address = json_decode($getvalue['shipping_address']);
                    $shipping_address_array = (array)$shipping_address;
                    $product_details = json_decode($getvalue['product_details']);
                    $product_details_array = (array)$product_details;
                    $order_status = orderStatusDD($getvalue['order_status']);
                    $data[] = array($getvalue['order_id'],$product_details_array['title'],$shipping_address_array['first_name'].' '.$shipping_address_array['last_name'],$totalsubtotalGross,$method,$getvalue['created'],$order_status);
                }
            }
            array_unshift($data, $hedare);
            $this->excel->getActiveSheet()->fromArray($data);
            // read data to active sheet
            // file name for download
            $filename = "Order_Report" . date('Y-m-d') . ".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function inventoryExportCSV($offset = 0) {        
       // $this->_check_login(); //check login authentication
        $search = array();
        if (!empty($_GET)) {            
            if (!empty($_GET['title'])) $search[] = ' pi.title like "%' . trim($_GET['title']) . '%"';
            if (!empty($_GET['category_id'])) $search[] = ' pi.category_id like "%' . trim($_GET['category_id']) . '%"';
            if (!empty($_GET['product_type'])) $search[] = ' pv.type_of_product = "' .trim($_GET['product_type']). '"';
            if (!empty($_GET['status'])) $search[] = ' pv.status = "' . trim($_GET['status']) . '"';
        }


        if ($usersData = $this->Common_model->get_productresult_export($offset, 10000000000, $search, "inventoryExport")) {            
            $header = array("SNo.", "Product Title", "SKU", "Sell Price", "Base Price", "Quantity", "Fee Preview");
            //load our new PHPExcel library
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Order Inventory Export');
            // To set password for sheet
            // $this->excel->getActiveSheet()->getProtection()->setPassword(EXCELPASSWORD);
            // To make sheet protected
            $this->excel->getActiveSheet()->getProtection()->setSheet(true);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle('A1', 'B1')->getFont()->setBold(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
            $letters = range('A', 'Z');
            $count = 0;
            $cell_name = "";
            foreach ($header as $tittle) {
                $cell_name = $letters[$count] . "1";
                $column_name = $letters[$count];
                $count++;
                $value = $tittle;
                //$objPHPExcel->getActiveSheet()->SetCellValue($cell_name, $value);
                // Make bold cells
                $this->excel->getActiveSheet()->getStyle($cell_name)->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle($cell_name)->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getColumnDimension($column_name)->setWidth(20);
                if ($count > 1) {
                    // To set the column of the sheet editable ex: all I and J column are editable here
                    $this->excel->getActiveSheet()->getStyle("I$count:J$count")->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }
            }
            // $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
            // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(22);
            $data = array();
            $resultData = array();
            //p($usersData); die;
            $i = 0;
            foreach ($usersData as $getvalue) {
                $i++;
                if (!empty($getvalue['type_of_product'] == 1)) {
                    if (!empty($getvalue['seller_SKU'])) {
                        $seller_SKU = $getvalue['seller_SKU'];
                    } else {
                        $seller_SKU = "-";
                    }
                } else {
                    $seller_SKU = "-";
                }
                if (!empty($getvalue['type_of_product'] == 1)) {
                    if (!empty($getvalue['sell_price'])) {
                        $sell_price = '$' . number_format($getvalue['sell_price'], 2);
                    } else {
                        $sell_price = '$0.00';
                    }
                } else {
                    $sell_price = "-";
                }
                if (!empty($getvalue['type_of_product'] == 1)) {
                    if (!empty($getvalue['base_price'])) {
                        $base_price = '$' . number_format($getvalue['base_price'], 2);
                    } else {
                        $base_price = '$0.00';
                    }
                } else {
                    $base_price = "-";
                }
                if (!empty($getvalue['type_of_product'] == 1)) {
                    if (!empty($getvalue['quantity'])) {
                        $quantity = $getvalue['quantity'];
                    } else {
                        $quantity = '0';
                    }
                } else {
                    $quantity = "-";
                }
                if (!empty($getvalue['type_of_product'] == 1)) {
                    if (!empty($getvalue['commision_fee']) && !empty($getvalue['sell_price'])) {
                        $feePreview = $getvalue['commision_fee'] * $getvalue['sell_price'] / 100;
                        $feePreviewdetail = '$' . number_format($feePreview, 2);
                    } else {
                        $feePreviewdetail = "-";
                    }
                } else {
                    $feePreviewdetail = "-";
                }
                $data[] = array($i, $getvalue['title'], $seller_SKU, $sell_price, $base_price, $quantity, $feePreviewdetail);
                if ($getvalue['type_of_product'] == 2) {
                    $variationdatalist = $this->getVariationProducts($getvalue['product_info_id'], 1, "exportInventory");
                    if (!empty($variationdatalist)) {
                        $ii = 0;
                        foreach ($variationdatalist as $rowofvariation) {
                            $ii++;
                            $data[] = array($i . '.' . $ii, $rowofvariation[0], $rowofvariation[1], $rowofvariation[2], $rowofvariation[3], $rowofvariation[4], $rowofvariation[5]);
                        }
                    }
                }
            }
            array_unshift($data, $header);
            $this->excel->getActiveSheet()->fromArray($data);
            // read data to active sheet
            // file name for download
            $filename = "Inventory_Report" . date('Y-m-d') . ".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function getVariationProducts($product_info_id, $statusProduct, $pageType) {
        $resultdata = "";
        $variationInfo = "";
        if (!empty($product_info_id)) {
            $dataresult = $this->seller_model->getVariationProducts($product_info_id, $statusProduct, $pageType);
            if ($dataresult) {
                $variationData = array();
                foreach ($dataresult as $row) {
                    $sellerSKU = ($row['seller_SKU']) ? $row['seller_SKU'] : "-";
                    $sellerbase_price = ($row['base_price']) ? number_format($row['base_price'], 2) : "0.00";
                    $sellersell_price = ($row['sell_price']) ? number_format($row['sell_price'], 2) : "0.00";
                    $sellerquantity = ($row['quantity']) ? $row['quantity'] : "0";
                    if (!empty($row['commision_fee']) && !empty($row['sell_price'])) {
                        $fee = $row['commision_fee'] * $row['sell_price'] / 100;
                        $feePreview = '$' . number_format($fee, 2);
                    } else {
                        $feePreview = "-";
                    }
                    $product_variation_info = json_decode($row['product_variation_info']);
                    foreach ($product_variation_info as $key => $value) {
                        $variationInfo.= ucfirst($key) . ' - ' . $value . ",  ";
                    }
                    $variationData[] = array(rtrim($variationInfo, ','), $sellerSKU, $sellersell_price, $sellerbase_price, $sellerquantity, $feePreview);
                }
                return $variationData;
            }
        }
    }
}
