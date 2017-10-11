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
<?php if (count($transactions) > 0): ?>

<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		lang('allegra_id'),
		lang('allegra_event'),
		lang('allegra_screen_name'),
		lang('allegra_date'),
		lang('allegra_quantity'),
		lang('allegra_price'),
		lang('allegra_price_reported'),		
		lang('allegra_desicion'),
		lang('allegra_default')
			);

	foreach($transactions as $transaction)
	{
		$this->table->add_row(
				$transaction['allegra_id'],
				'<a href="'.$transaction['url_title'].'" target="_blank">'.$transaction['title'].'</a>',
				'<a href="'.$transaction['screen_name_url'].'" target="_blank">'.$transaction['screen_name'].'</a>',
				$transaction['allegra_date'],
				$transaction['allegra_quantity'],
				'$ '.$transaction['allegra_price'],
				(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : '$ '.$transaction['allegra_price_reported'],
				lang('allegra_code_'.$transaction['desicion']),
				'<span class="button"><a href="'.$transaction['edit_link'].'" class="submit" style="color:#fff;">'.lang('view_transaction').'</a></span>'
			);
	}

echo $this->table->generate();

?>

<div class="tableFooter">
	<span class="js-hide"><?=$pagination?></span>	
	<span class="pagination" id="filter_pagination"></span>
</div>

<?php else: ?>
<?=lang('no_matching_transactions')?>
<?php endif; ?>

