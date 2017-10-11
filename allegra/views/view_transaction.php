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
<?php if (count($transactions) > 0): 
	foreach($transactions as $transaction)
	{	
?>
<div class="moduleHeader">
	<a href="https://allegra.global/plataforma/index.html"><img src="https://allegra.global/plataforma/images/logo-alegra.png" alt="allegra platform enterprises" width="160"/></a><br>
</div>
<table class="mainTable" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr class="even">
		<th><?=$transaction['title']?></th>
		<th style="text-align:right;"><?=(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : '<a href="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl='.$transaction['allegra_checkout_id'].'&choe=UTF-8" target="_blank"><img src="https://chart.googleapis.com/chart?chs=75x75&cht=qr&chl='.$transaction['allegra_checkout_id'].'&choe=UTF-8" alt="QR Code" /></a>'?></th>
	</tr>
	</thead>
	<tbody>
		<tr class="odd">
			<td><h4>Fecha de Compra</h4></td>
			<td><?=$transaction['allegra_date']?></td>
		</tr>
		<tr class="even">
			<td><h4>Comprador</h4></td>
			<td><a href="<?=$transaction['screen_name_url']?>" target="_blank"><?=$transaction['screen_name']?></a></td>
		</tr>
		<tr class="odd">
			<td><h4>Tiquetes</h4></td>
			<td><?=$transaction['allegra_quantity']?></td>
		</tr>
		<tr class="even">
			<td><h4>Valor cancelado en la pasarela de pago</h4></td>
			<td><?=(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : '$ '.$transaction['allegra_price_reported']?></td>
		</tr>
		<tr class="odd">
			<td><h4>Transacción a nombre de</h4></td>
			<td><?=(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : $transaction['req_bill_to_forename'].' '.$transaction['req_bill_to_surname']?></td>
		</tr>
		<tr class="even">
			<td><h4>Número de teléfono</h4></td>
			<td><?=(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : $transaction['req_bill_to_phone']?></td>
		</tr>
		<tr class="odd">
			<td><h4>Dirección Registrada</h4></td>
			<td><?=(is_null ($transaction['allegra_price_reported']) == TRUE) ? lang('allegra_price_reported_null') : $transaction['req_bill_to_address_line']?></td>
		</tr>
	</tbody>
</table>



<?php 
	}
	else: ?>
<?=lang('no_matching_transactions')?>
<?php endif; ?> 

<div class="tableFooter">
	<span class="button"><a href="javascript:history.back()" class="submit" style="color:#fff;"><?=lang('allegra_back')?></a></span>
</div>
