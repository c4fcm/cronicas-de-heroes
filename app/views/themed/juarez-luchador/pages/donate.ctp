<?php 
$pageTitle = __("page.donate",true);
$this->set('title_for_layout', $pageTitle);
?>

<style type="text/css">
table {
    margin-left: auto;
    margin-right: auto;
    padding-bottom: 50px;
    margin-top: 10px;
}
tr {
    vertical-align:top;
}
td {
    width: 270px;
    padding: 0px 30px;
    border-right: 1px solid #AAAAAA;
}
td.hr-last-in-row {
    border-right: 0px;
}
</style>

<table>
<tr><td>

<h2>Donar con PayPal</h2>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="yesica@cronicasdeheroes.mx">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Crónicas de Héroes">
<input type="hidden" name="item_number" value="juarez-website">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/es_XC/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</td>
<td>

<h2>Compra una Camisa</h2>
<p>Tenemos una tienda de ropa en <a href="http://www.printfection.com/cronicasdeheroes-juarez/">Printfection</a>.</p>
<a href="http://www.printfection.com/cronicasdeheroes-juarez/"><?=$html->image("tshirt.jpg")?></a>

</td><td class="hr-last-in-row">

<h2>Ayúdanos en Spot.us</h2>
<p>Tenemos una <a href="http://spot.us/pitches/987-chronicles-of-heroes-cronicas-de-heroes">campaña en Spot.us</a>.</p>
<a href="http://spot.us/pitches/987-chronicles-of-heroes-cronicas-de-heroes"><?=$html->image("spotus.jpg")?></a>
</td></tr>

</table>
