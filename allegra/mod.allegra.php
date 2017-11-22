<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

Except as contained in this notice, the name of Nullun, SAS. shall not be
used in advertising or otherwise to promote the sale, use or other dealings
in this Software without prior written authorization from Nullun, SAS.
*/

class Allegra {
	// Variable to output the module Data
	var $return_data    = '';

	public function __construct()
    {
        // Make a local reference to the ExpressionEngine super object
        $this->EE =& get_instance();
    }

    // Construct the form
    function form_transaction(){
        // Load resources
        ee()->load->config('allegra');
		ee()->load->helper('form');
		// Parse the inherit data
		$tagdata = ee()->TMPL->tagdata;
		// Parse "single" variables
		foreach (ee()->TMPL->var_single as $key => $val)
		{
			// parse {member_name}
			if ($key == 'member_name')
			{
				$name = (ee()->session->userdata['screen_name'] != '') ? ee()->session->userdata['screen_name'] : ee()->session->userdata['username'];
				$tagdata = ee()->TMPL->swap_var_single($key, form_prep($name), $tagdata);
			}
			// {member_email}
			if ($key == 'member_email')
			{
				$email = (ee()->session->userdata['email'] == '') ? '' : ee()->session->userdata['email'];
				$tagdata = ee()->TMPL->swap_var_single($key, form_prep($email), $tagdata);
			}
		}
		// Create form
		return $this->_setup_form($tagdata, 'checkout_form');
	}
	
	function create_transaction(){
		ee()->load->config('allegra');
		/**
	 	* Store the transaction to EE and send to Allegra
	 	*/
		 $data = array(
			'allegra_date'			=> ee()->input->post('allegra_date'),
			'allegra_checkout_id'	=> ee()->input->post('transaction_uuid'),
			'allegra_event'			=> ee()->input->post('allegra_event'),
			'allegra_quantity'		=> ee()->input->post('ticket_number'),
			'allegra_price'			=> ee()->input->post('event_amount'),
			'member_id'				=> ee()->input->post('member_id'),
			'member_email'			=> ee()->input->post('member_email')
		);

		ee()->db->query(ee()->db->insert_string('exp_allegra_transaction', $data));
		/**
		 * Send Emails to the buyer and to the person in charge
		 */
		// Message
		$message = ee()->config->item('allegra_mail_transaction_start');
		// Send email
		ee()->load->library('email');
		ee()->email->wordwrap = true;
		ee()->email->mailtype = 'html';
		ee()->email->priority = '3';
		ee()->email->EE_initialize();
		ee()->email->to(ee()->input->post('member_email'));
		ee()->email->bcc(ee()->config->item('allegra_notify'));
		ee()->email->from(ee()->config->item('webmaster_email'), ee()->config->item('webmaster_name'));
		ee()->email->reply_to(ee()->config->item('allegra_notify'));
		ee()->email->subject('CENTRO DE CONOCIMIENTO SOCIAL COLECTIVO - Se ha enviado una solicitud de compra');
		ee()->email->message($message);
		ee()->email->send();

		// Send the transaction to Allegra
		// GET All the post fields
		foreach($_POST as $name => $value) {
            $params[$name] = $value;
		}
		// Don't looking good but works! forward the post data to the Gateway
		$res ="<!DOCTYPE html>\n";
		$res .= "<form action=".ee()->config->item('allegra_transaction_url')." id=\"allegra\" method=\"post\">\n";
		foreach($params as $name => $value) {
			$res .= "<input type=\"hidden\" name=". $name . " value=". $value ." >\n";
		}
		$res .= "</form>\n";
		$res .="<script type=\"text/javascript\">\ndocument.getElementById(\"allegra\").submit();\n</script>\n";
		echo ($res);
	}

	/**
	 * Setup forms
	 */
	private function _setup_form($tagdata, $form_id = NULL)
	{
		$charset = ee()->TMPL->fetch_param('charset', '');

		// Create the UUID
		$uuid = uniqid();
        // Prepare the form
        $data = array(
			'id'			=> (ee()->TMPL->form_id == '') ? $form_id : ee()->TMPL->form_id,
			'class'			=> ee()->TMPL->form_class,
			//'action'		=> '/iatai/payment_confirmation.php',
			'hidden_fields'	=> array(
				'ACT'				    => ee()->functions->fetch_action_id('Allegra', 'create_transaction'),
				'RET'                   => ee()->TMPL->fetch_param('return', ''),
				'URI'				    => (ee()->uri->uri_string == '') ? 'index' : ee()->uri->uri_string,
                'redirect'			    => ee()->TMPL->fetch_param('redirect', ''),
				'allegra_date'          => ee()->localize->format_date('%Y-%m-%d %H:%i:%s'),
				'transaction_type'		=> "authorization",
				'profile_id'			=> ee()->config->item('allegra_profileid'),
				'reference_number'		=> ee()->TMPL->fetch_param('reference_number', ''),
				'access_key'			=> ee()->config->item('allegra_accesskey'),
				'currency'				=> ee()->config->item('allegra_currency'),
                'allegra_event'         => ee()->TMPL->fetch_param('entry_id'),
				'transaction_uuid'		=> $uuid,
				'signed_date_time'		=> gmdate("Y-m-d\TH:i:s\Z"),
				'locale'				=> ee()->config->item('allegra_locale'),
                'member_id'             => (ee()->session->userdata['member_id'] == '') ? '' : ee()->session->userdata['member_id'],
                'member_email'          => (ee()->session->userdata['email'] == '') ? '' : ee()->session->userdata['email'],
			)
		);

		$res  = ee()->functions->form_declaration($data);
		$res .= stripslashes($tagdata);
		$res .= "</form>";//echo $res; exit;
		return $res;
	}

}//END CLASS