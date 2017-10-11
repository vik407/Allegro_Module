<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Copyright (C) 2008 - 2017 Nullun, SAS.

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
in this Software without prior written authorization from Nullun, SAS.
*/

class Allegra_upd {

    var $version = '0.1';
	
	function install()
	{
	    ee()->load->dbforge();

	    $data = array(
	        'module_name' => 'Allegra' ,
	        'module_version' => $this->version,
	        'has_cp_backend' => 'y',
	        'has_publish_fields' => 'y'
	    );

	    ee()->db->insert('modules', $data);
		
		// Action ID
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_form'
		);

		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_create_transaction'
		);

		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_edit_transaction'
		);

		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_search_transaction'
		);

		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_create_profile'
		);
		
		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_edit_profile'
		);

		ee()->db->insert('actions', $data);
		
		$data = array(
		    'class'     => 'Allegra' ,
		    'method'    => 'allegra_response'
		);

		ee()->db->insert('actions', $data);
		
		// Init Database	
		
		$fields = array(
		        'allegra_id' => array(
		                'type' => 'INT',
		                'unsigned' => TRUE,
						'null' => FALSE,
		                'auto_increment' => TRUE
		        ),
		        'allegra_date' => array(
		                'type' => 'DATETIME',
		                'null' => FALSE,
		        ),
		        'allegra_checkout_id' => array(
		                'type' =>'VARCHAR',
		                'constraint' => '15',
		                'default' => '',
		        ),
		        'allegra_event' => array(
		                'type' => 'INT',
						'null' => FALSE,
		        ),
		        'allegra_quantity' => array(
		                'type' => 'INT',
						'constraint' => '5',
						'null' => FALSE,
		        ),
		        'allegra_price' => array(
		                'type' => 'NUMERIC',
						'constraint' => '10',
						'null' => FALSE,
						'default' => '0',
		        ),
		        'member_id' => array(
		                'type' => 'INT',
						'null' => FALSE,
		        ),
		        'member_email' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => FALSE,
		        ),
		);

		ee()->dbforge->add_field($fields);
		ee()->dbforge->add_key('allegra_id', TRUE);

		ee()->dbforge->create_table('allegra_transaction');

		unset($fields);

		$fields = array(
		        'response_id' => array(
		                'type' => 'INT',
		                'unsigned' => TRUE,
						'null' => FALSE,
		                'auto_increment' => TRUE
		        ),
		        'auth_code' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => FALSE,
		        ),
		        'desicion' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => TRUE,
		        ),
		        'msessage' => array(
		                'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => TRUE,
		        ),
		        'payment_token' => array(
		                'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => TRUE,
		        ),
		        'reason_code' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => TRUE,
		        ),
		        'req_amount' => array(
		                'type' => 'NUMERIC',
						'constraint' => '10',
						'default' => '0',
						'null' => TRUE,
		        ),
		        'req_bill_to_address_city' => array(
		                'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => TRUE,
		        ),
		        'req_bill_to_address_country' => array(
		                'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => TRUE,
		        ),
		        'req_bill_to_address_line1' => array(
		                'type' => 'VARCHAR',
						'constraint' => '150',
						'null' => TRUE,
		        ),
		        'req_bill_to_email' => array(
		                'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => TRUE,
		        ),
		        'req_bill_to_forename' => array(
		                'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => TRUE,
		        ),
		        'req_bill_to_surname' => array(
		                'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => TRUE,
		        ),
		        'req_bill_to_phone' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => TRUE,
		        ),
		        'req_card_number' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => TRUE,
		        ),
		        'req_currency' => array(
		                'type' => 'VARCHAR',
						'constraint' => '5',
						'null' => TRUE,
		        ),
		        'req_device_fingerprint_id' => array(
		                'type' => 'VARCHAR',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_locale' => array(
		                'type' => 'VARCHAR',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data1' => array(
		                'type' => 'VARCHAR',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data2' => array(
		                'type' => 'VARCHAR',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data3' => array(
		                'type' => 'NUMERIC',
						'constraint' => '5',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data4' => array(
		                'type' => 'NUMERIC',
						'constraint' => '5',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data5' => array(
		                'type' => 'NUMERIC',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_merchant_defined_data6' => array(
		                'type' => 'NUMERIC',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_payment_method' => array(
		                'type' => 'VARCHAR',
						'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_profile_id' => array(
		                'type' => 'VARCHAR',
						'constraint' => '50',
						'null' => TRUE,
		        ),
		        'req_reference_number' => array(
		                'type' => 'INT',
		                'constraint' => '50',
						'null' => FALSE,
		        ),
		        'req_transaction_uuid' => array(
		                'type' => 'VARCHAR',
		                'constraint' => '50',
						'null' => TRUE,
		        ),
		        'signature' => array(
		                'type' => 'VARCHAR',
		                'constraint' => '50',
						'null' => TRUE,
		        ),
		        'signed_date_time' => array(
		                'type' => 'VARCHAR',
		                'constraint' => '50',
						'null' => TRUE,
		        ),
		        'signed_field_names' => array(
		                'type' => 'VARCHAR',
		                'constraint' => '250',
						'null' => TRUE,
		        ),
		        'transaction_id' => array(
		                'type' => 'VARCHAR',
		                'constraint' => '50',
						'null' => FALSE,
		        ),
		        'req_item_#_code' => array(
		                'type' => 'INT',
						'null' => TRUE,
		        ),
		        'req_item_#_name' => array(
	                	'type' => 'VARCHAR',
	                	'constraint' => '250',
						'null' => TRUE,
		        ),
		        'req_item_#_quantity' => array(
	                	'type' => 'NUMERIC',
	                	'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_item_#_sku' => array(
	                	'type' => 'NUMERIC',
	                	'constraint' => '10',
						'null' => TRUE,
		        ),
		        'req_item_#_unit_price' => array(
	                	'type' => 'NUMERIC',
	                	'constraint' => '10',
						'null' => TRUE,
		        ),	
		);

		ee()->dbforge->add_field($fields);
		ee()->dbforge->add_key('response_id', TRUE);
		ee()->dbforge->add_key('transaction_id', TRUE);

		ee()->dbforge->create_table('allegra_response');
		
		ee()->load->library('layout');
		    ee()->layout->add_layout_tabs($this->tabs(), 'allegra');

		    return TRUE;
	}
	function uninstall()
	{
		ee()->load->dbforge();

		ee()->db->select('module_id');
		$query = ee()->db->get_where('modules', array('module_name' => 'Allegra'));

		ee()->db->where('module_id', $query->row('module_id'));
		ee()->db->delete('module_member_groups');

		ee()->db->where('module_name', 'Allegra');
		ee()->db->delete('modules');

		ee()->db->where('class', 'Allegra');
		ee()->db->delete('actions');

		ee()->dbforge->drop_table('allegra_transaction');
		ee()->dbforge->drop_table('allegra_response');
		ee()->dbforge->drop_table('allegra_profile');

		// Required if your module includes fields on the publish page
		ee()->load->library('layout');
		ee()->layout->delete_layout_tabs($this->tabs(), 'allegra');

		return TRUE;
	}
	function update($current ='')
	{
		return FALSE;
	}
	function tabs()
	{
	    $tabs['allegra'] = array(
	        'allegra_field_ids'    => array(
	            'visible'   => 'true',
	            'collapse'  => 'false',
	            'htmlbuttons'   => 'false',
	            'width'     => '100%',
	        )
	    );

	    return $tabs;
	}
}
/* END Class */