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
	function __construct()
	{
	    ee()->cp->set_right_nav(array(
	        'Transactions'  => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'
	            .AMP.'module=allegra'.AMP.'method=allegra_browse',
	        'Configuration'  => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'
	            .AMP.'module=allegra'.AMP.'method=allegra_config',
	        'Allegra Platform'  => 'https://allegra.global/plataforma/index.html',
	    ));
	}
	
	function index()
	{
	    ee()->load->library('javascript');
	    ee()->load->library('table');
	    ee()->load->helper('form');

	    ee()->view->cp_page_title = lang('allegra_module_name');

	    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=allegra'.AMP.'method=allegra_browse';
	    $vars['form_hidden'] = NULL;
	    $vars['transactions'] = array();

	    $vars['options'] = array(
	        'edit'  => lang('edit_transaction'),
	        'delete'    => lang('delete_transaction')
	    );
		
		// Add javascript

		ee()->cp->add_js_script(array('plugin' => 'dataTables'));


		ee()->javascript->output(array(
				'$(".toggle_all").toggle(
					function(){
						$("input.toggle").each(function() {
							this.checked = true;
						});
					}, function (){
						var checked_status = this.checked;
						$("input.toggle").each(function() {
							this.checked = false;
						});
					}
				);'
			)
		);
			
		ee()->javascript->compile();
		
		
		
		
		return ee()->load->view('index', $vars, TRUE);
	}

}
// END CLASS