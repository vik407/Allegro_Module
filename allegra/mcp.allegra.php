<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2010 - 2011 EllisLab, Inc.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
ELLISLAB, INC. BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Except as contained in this notice, the name of EllisLab, Inc. shall not be
used in advertising or otherwise to promote the sale, use or other dealings
in this Software without prior written authorization from EllisLab, Inc.
*/
class Allegra_mcp {
	var $perpage = 30;
		
	function __construct()
	{
	    ee()->cp->set_right_nav(array(
	        'Transactions'  => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'
	            .AMP.'module=allegra'.AMP.'method=index',
	        'Allegra Platform'  => 'https://allegraplatform.com/AllegraPlatform/faces/login.xhtml',
	    ));
	}
	
	function index()
	{
		ee()->load->config('allegra');
	    ee()->load->library('javascript');
	    ee()->load->library('table');
	    ee()->load->helper('form');
		ee()->load->library('pagination');

	    ee()->view->cp_page_title = lang('allegra_module_name');

	    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=allegra'.AMP.'method=edit_transaction';
	    $vars['form_hidden'] = NULL;
	    $vars['transactions'] = array();

	    $vars['options'] = array(
	        'view'    => lang('view_transaction'),
			'edit'  => lang('edit_transaction')
	    );
		
		//  Check for pagination
		$total = ee()->db->count_all('allegra_transaction');
		
		if ( ! $rownum = ee()->input->get_post('rownum'))
		{
		    $rownum = 0;
		}
		
		$query = ee()->db->select('t.allegra_id, t.allegra_date, t.allegra_quantity, t.allegra_price, c.title,	c.url_title, m.member_id, m.screen_name, m.email, r.desicion, r.req_amount')
		    ->from('allegra_response r')
			->join('allegra_transaction t', 'r.req_reference_number = t.allegra_id', 'right')
			->join('channel_titles c', 't.allegra_event = c.entry_id', 'left')
			->join('members m', 't.member_id = m.member_id', 'left')
		    ->limit($this->perpage)
			->offset($rownum)
		    ->order_by('t.allegra_id', 'desc')
		    ->get();
		
		foreach($query->result_array() as $row)
		{
			$vars['transactions'][$row['allegra_id']]['allegra_id'] = $row['allegra_id'];
			$vars['transactions'][$row['allegra_id']]['screen_name_url'] = ee()->config->item('site_url').'member/'.$row['member_id'];
			$vars['transactions'][$row['allegra_id']]['screen_name'] = $row['screen_name'];
			$vars['transactions'][$row['allegra_id']]['title'] = $row['title'];
			$vars['transactions'][$row['allegra_id']]['allegra_price'] = $row['allegra_price'];
			$vars['transactions'][$row['allegra_id']]['allegra_price_reported'] = $row['req_amount'];
			$vars['transactions'][$row['allegra_id']]['allegra_quantity'] = $row['allegra_quantity'];
			$vars['transactions'][$row['allegra_id']]['allegra_date'] = $row['allegra_date'];
			$vars['transactions'][$row['allegra_id']]['title'] = $row['title'];
			$vars['transactions'][$row['allegra_id']]['desicion'] = $row['desicion'];
			$vars['transactions'][$row['allegra_id']]['url_title'] = ee()->config->item('site_url').ee()->config->item('product_template').'/'.$row['url_title'];
			$vars['transactions'][$row['allegra_id']]['edit_link'] = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=allegra'.AMP.'method=view_transaction'.AMP.'transaction_id='.$row['allegra_id'];
			
		}
		
	    // Pass the relevant data to the paginate class so it can display the "next page" links
	    $p_config = $this->pagination_config('index', $total);

	    ee()->pagination->initialize($p_config);

	    $vars['pagination'] = ee()->pagination->create_links();
		
		return ee()->load->view('index', $vars, TRUE);
	}
	
	function pagination_config($method, $total_rows)
	{
	    // Pass the relevant data to the paginate class
	    $config['base_url'] = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=allegra'.AMP.'method='.$method;
	    $config['total_rows'] = $total_rows;
	    $config['per_page'] = $this->perpage;
	    $config['page_query_string'] = TRUE;
	    $config['query_string_segment'] = 'rownum';
	    $config['full_tag_open'] = '<p id="paginationLinks">';
	    $config['full_tag_close'] = '</p>';
	    $config['prev_link'] = '<img src="'.ee()->cp->cp_theme_url.'images/pagination_prev_button.gif" width="13" height="13" alt="<" />';
	    $config['next_link'] = '<img src="'.ee()->cp->cp_theme_url.'images/pagination_next_button.gif" width="13" height="13" alt=">" />';
	    $config['first_link'] = '<img src="'.ee()->cp->cp_theme_url.'images/pagination_first_button.gif" width="13" height="13" alt="< <" />';
	    $config['last_link'] = '<img src="'.ee()->cp->cp_theme_url.'images/pagination_last_button.gif" width="13" height="13" alt="> >" />';

	    return $config;
	}
	
	function view_transaction()
	{
		ee()->load->config('allegra');
	    ee()->load->library('javascript');
	    ee()->load->library('table');
		ee()->load->helper('form');
		if (ee()->input->get('transaction_id') !== FALSE){
			$transaction_id = ee()->input->get('transaction_id');
				
				$query = ee()->db->select('t.allegra_id, t.allegra_checkout_id, t.allegra_date, t.allegra_quantity, c.title, m.member_id, m.screen_name, m.email, r.desicion, r.req_amount, r.req_bill_to_forename, r.req_bill_to_surname, r.req_merchant_defined_data1, r.req_bill_to_phone, r.req_bill_to_address_line1')
				    ->from('allegra_response r')
					->join('allegra_transaction t', 'r.req_reference_number = t.allegra_id', 'right')
					->join('channel_titles c', 't.allegra_event = c.entry_id', 'left')
					->join('members m', 't.member_id = m.member_id', 'left')
					->where(array(
				        't.allegra_id' => $transaction_id,
				    	))
				    ->limit('1')
				    ->order_by('t.allegra_id', 'desc')
				    ->get();
		
				foreach($query->result_array() as $row)
				{
					ee()->view->cp_page_title = lang('allegra_detail_transaction_title');
					
					$vars['transactions'][$row['allegra_id']]['allegra_id'] = $row['allegra_id'];
					$vars['transactions'][$row['allegra_id']]['screen_name_url'] = ee()->config->item('site_url').'member/'.$row['member_id'];
					$vars['transactions'][$row['allegra_id']]['allegra_checkout_id'] = $row['allegra_checkout_id'];
					$vars['transactions'][$row['allegra_id']]['screen_name'] = $row['screen_name'];
					$vars['transactions'][$row['allegra_id']]['title'] = $row['title'];
					$vars['transactions'][$row['allegra_id']]['req_bill_to_forename'] = $row['req_bill_to_forename'];
					$vars['transactions'][$row['allegra_id']]['req_bill_to_surname'] = $row['req_bill_to_surname'];
					$vars['transactions'][$row['allegra_id']]['req_bill_to_phone'] = $row['req_bill_to_phone'];
					$vars['transactions'][$row['allegra_id']]['allegra_price_reported'] = $row['req_amount'];
					$vars['transactions'][$row['allegra_id']]['allegra_quantity'] = $row['allegra_quantity'];
					$vars['transactions'][$row['allegra_id']]['allegra_date'] = $row['allegra_date'];
					$vars['transactions'][$row['allegra_id']]['title'] = $row['title'];
					$vars['transactions'][$row['allegra_id']]['desicion'] = $row['desicion'];	
					$vars['transactions'][$row['allegra_id']]['req_bill_to_address_line'] = $row['req_bill_to_address_line1'];				
			
				}
		
				$vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=download'.AMP.'method=add_downloads';
		
		
				$vars['form_hidden'] = NULL;
		
				return ee()->load->view('view_transaction', $vars, TRUE);
		}else{
			ee()->view->cp_page_title = 'ERROR NO ENTRY ID';
			$vars['form_hidden'] = NULL;
			return ee()->load->view('view_transaction', $vars, TRUE);
		}
	}

}
// END CLASS