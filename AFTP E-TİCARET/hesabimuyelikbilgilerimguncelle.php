<?php
if(isset($_SESSION["Kullanici"])){
	?>
	<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr>
		<td width="500" valign="top">
			<form action="index.php?SK=52" method="post">
			<table width="500"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr height="50">
		<td  style="color: #FF9900"><h3>Hesabım > Üyelik Bilgileri > Güncelle</h3></td>	
		 </tr>
			<tr height="30">
		<td  valign="top" style="border-bottom: 1px dashed #CCCCCC;">Aşağıdan Üyelik Bilgilerinizi güncelleyebilirsin.</td>	
		 </tr>
				<tr height="30">
		<td  valign="bottom" align="left">E-Mail Adresi </td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="text"name="E-MailAdresi"class="InputAlanlari" value="<?php echo $EmailAdresi ;?>"</td>	
		 </tr>
				<tr height="30">
		<td  valign="bottom" align="left">Şifre </td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="password"name="Sifre"class="InputAlanlari"value="EskiSifre"</td>	
		 </tr>
				<tr height="30">
		<td   valign="bottom" align="left">Şifre Tekrar </td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="password"name="SifreTekrar"class="InputAlanlari"value="EskiSifre"</td>	
		 </tr>
	 
			<tr height="30">
		<td  valign="bottom" align="left">İsim Soyisim </td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="text"name="AdiSoyadi" class="InputAlanlari"value="<?php echo $IsimSoyism ;?>"</td>	
		 </tr>
			
			<tr height="30">
		<td  valign="bottom" align="left">Telefon Numarası </td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="text"name="TelefonNumarasi" maxlength="11" class="InputAlanlari" value="<?php echo $TelefonNumarasi;?>"></td>	
		 </tr>
				
				<tr height="30">
		<td  valign="bottom" align="left">Adres</td>	
		 </tr>
			<tr height="30">
		<td  valign="top" align="left"><input type="text"name="Adres"  class="InputAlanlari" value="<?php echo $Adres;?>"></td>	
		 </tr>
				
				<tr height="40">
		<td colspan="2" align="center"><input type="submit" value="Bilgilerimi Guncelle" class="KirmiziButon"></td>	
		 </tr>
				
				
				
				
				
				
				

</table>
			</form>
		</td>
	<td width="20">&nbsp;</td>
		
		
	<td valign="top" width="545"><table width="545"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr height="50">
		<td  style="color: #FF9900" ><h3>Reklam</h3></td>	
		 </tr>
			<tr height="30">
		<td c valign="top" style="border-bottom: 1px dashed #CCCCCC;"></td>	
		 </tr>
		
		<tr height="5">
		<td  height="5" style="font-size: 5px;">&nbsp;</td>	
		 </tr>
	 <tr>
		<td align="left"><b><img src="Resimler/bu-alana-reklam-ver.jpg"</b></td>	
		 </tr>
		

		
		
		</table>
		</td>

	
	</tr>
	 
</table>

<?php
}else{
	header("Location:index.php");
	exit();
}
?>