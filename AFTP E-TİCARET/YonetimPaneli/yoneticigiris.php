<?php
if ( empty( $_SESSION[ "Yonetici" ] ) ) {
?>
<form action="index.php?SKD=2" method="post">
    
	<table width="1065"  align="center" border="0" cellpadding="0" cellspacing="0"style="border: 1px solid #000000; padding:  30px;">
    <tr height="10">
		<td colspan="4"  align="center" width="110"class="InputAlanlari"><img src="../Resimler/yoneticigrisi.png"</td>

	</tr>
    <tr height="85">
        <td  colspan="4" align="center" width="250" style="color: #FD6E00; font-size: 30px;">YÖNETİCİ GİRİŞ SAYFASI</td>  
	</tr>

	<tr height="35">
		<td align="left" width="150">Yönetici Kullanıcı Adı</td>
		<td align="left" width="50">:</td>
		<td align="left" width="260"><input type="text" name="YKullanici" class="InputAlanlari"></td>
		<td align="left" width="20">&nbsp;</td>
	</tr>
	<tr height="35">
		<td align="left">Yönetici Sifresi</td>
		<td align="left">:</td>
		<td align="left"><input type="password" name="YSifre" class="InputAlanlari"></td>
		<td align="left">&nbsp;</td>

	</tr>
	
	<tr height="35">
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
		<td align="left"><input type="submit" value="Giriş Yap" class="KirmiziButon" ></td>
		<td align="left">&nbsp;</td>
	</tr>
	
	</table>
</form>
<?php
}
	?>