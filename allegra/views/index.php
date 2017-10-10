<?php
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
?>
<div class="moduleHeader">
	<a href="https://allegra.global/plataforma/index.html"><img src="https://allegra.global/plataforma/images/logo-alegra.png" alt="allegra platform enterprises" width="160"/></a>
</div>

<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		lang('allegra_checkout_id'),
		lang('allegra_date'),
		lang('allegra_event'),
		form_checkbox('select_all', 'true', FALSE, 'class="toggle_all" id="select_all"'));

	foreach($transactions as $transaction)
	{
		$this->table->add_row(
				'<a href="'.$transaction['edit_link'].'">'.$transaction['allegra_checkout_id'].'</a>',
				$transaction['allegra_date'],
				'<a href="'.$transaction['allegra_event'].'" target="_blank">'.$transaction['allegra_event'].'</a>',
				form_checkbox($transaction['toggle'])
			);
	}

echo $this->table->generate();

?>