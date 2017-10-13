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

	public function __construct($params)
    {
     	// Load Configuration
     	ee()->load->config('allegra');
     	ee()->config->item('allegra_profileid');
     	ee()->config->item('allegra_secretkey');     	
     	// $params array: type, data, 

    }

	// --------------------------------------------------------------------

	/**
	 * Setup forms
	 *
	 * @param 	string 	$tagdata
	 * @param 	string 	$recipients
	 * @param 	string 	$form_id
	 * @param 	boolean
	 * @return 	string
	 */
	private function _setup_form($tagdata, $recipients, $form_id = NULL, $allow_html = FALSE)
	{
		$charset = ee()->TMPL->fetch_param('charset', '');

		$recipients = $this->_encrypt_recipients($recipients);

		$data = array(
			'id'			=> (ee()->TMPL->form_id == '') ? $form_id : ee()->TMPL->form_id,
			'class'			=> ee()->TMPL->form_class,
			'hidden_fields'	=> array(
				'ACT'				=> ee()->functions->fetch_action_id('Email', 'send_email'),
				'RET'				=> ee()->TMPL->fetch_param('return', ''),
				'URI'				=> (ee()->uri->uri_string == '') ? 'index' : ee()->uri->uri_string,
				'recipients'		=> base64_encode($recipients),
				'user_recipients'	=> ($this->_user_recipients == 'yes') ? md5(ee()->db->username.ee()->db->password.'y') : md5(ee()->db->username.ee()->db->password.'n'),
				'charset'			=> $charset,
				'redirect'			=> ee()->TMPL->fetch_param('redirect', ''),
				'replyto'			=> ee()->TMPL->fetch_param('replyto', '')
			)
		);

		if ($allow_html)
		{
			$data['hidden_fields']['allow_html'] = 'y';
		}

		$name = ee()->TMPL->fetch_param('name', FALSE);

 		if ($name && preg_match("#^[a-zA-Z0-9_\-]+$#i", $name, $match))
		{
			$data['name'] = $name;
		}

		$res  = ee()->functions->form_declaration($data);
		$res .= stripslashes($tagdata);
		$res .= "</form>";//echo $res; exit;
		return $res;
	}

}

// EOF