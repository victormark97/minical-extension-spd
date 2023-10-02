<?php
//file name bookings_model.php
class Bookings_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    

    function get_bookings_for_today()
    {
        $company_id = $this->session->userdata('current_company_id');

        $today = date('Y-m-d'); // Get today's date
        
        $sql_query ="SELECT b.rate,b.booking_id,bb.room_id,bb.check_in_date, bb.check_out_date, r.room_name, c.customer_name, c.email
                from booking b, booking_block bb, room r, customer c
                where b.booking_id=bb.booking_id 
                and bb.room_id=r.room_id
                and b.booking_customer_id=c.customer_id
                and b.company_id=$company_id order by b.booking_id DESC LIMIT 20" ;

        $sql_query ="SELECT b.rate, b.booking_id, bb.room_id, bb.check_in_date, bb.check_out_date, r.room_name, c.customer_name, c.email
                FROM booking b
                JOIN booking_block bb ON b.booking_id = bb.booking_id
                JOIN room r ON bb.room_id = r.room_id
                JOIN customer c ON b.booking_customer_id = c.customer_id
                WHERE b.company_id = $company_id
                AND bb.check_out_date >= '$today'";
        
        $booking_data = $this->db->query($sql_query);    
            if ($this->db->_error_message()) 
            {
                show_error($this->db->_error_message());
            }
            

        $result = $booking_data->result_array();       
        return $result;
    }

    function get_customer_list()
    {
        $company_id = $this->session->userdata('current_company_id');
        $query = "SELECT customer_name, email, address,phone FROM customer where company_id = $company_id order by customer_id DESC LIMIT 20";
        $customer = $this->db->query($query);    
        if ($this->db->_error_message()) 
        {
            show_error($this->db->_error_message());
        }
        
        $result = $customer->result_array();       
        return $result;
    }

    
}