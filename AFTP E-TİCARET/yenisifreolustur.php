<?php


if(isset($_GET["AktivasyonKodu"])){
	$AktivasyonKodu =  Guvenlik($_GET["AktivasyonKodu"]);
}else{
	$AktivasyonKodu = "";
}

if(isset($_GET["Email"])){
	$GelenEmail =  Guvenlik($_GET["Email"]);
}else{
	$GelenEmail = "";
}

if(($AktivasyonKodu!="") and ($GelenEmail!="")){
				$KontrolSorgusu = $VeritabaniBaglantisi -> prepare("Select * from uyeler where EmailAdresi=? and Aktivasyon =?");
				$KontrolSorgusu -> execute([$GelenEmail,$AktivasyonKodu]);
				$KullaniciSayisi= $KontrolSorgusu->rowCount();
				$KullaniciKaydi = $KontrolSorgusu->fetch(PDO::FETCH_ASSOC);
				if($KullaniciSayisi>0){
					?>

<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr>
		<td width="500" valign="top">
			<form action="index.php?SK=44&EmailAdresi=<?php echo $GelenEmail;?>&AktivasyonKodu=<?php echo $AktivasyonKodu;?>" method="post">
			<table width="500"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr height="50">
		<td colspan="2" style="color: #FF9900"><h3>Şifre Sıfırlama</h3></td>	
		 </tr>
			<tr height="30">
		<td colspan="2" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Aşağıdan Hesabına Giriş Şifreni Değiştirebilirsin.</td>	
		 </tr>
				
				<tr height="30">
		<td colspan="2" valign="bottom" align="left">Yeni Şifre (*)</td>	
		 </tr>
			<tr height="30">
		<td colspan="2" valign="top" align="left"><input type="password"name="YeniSifre"class="InputAlanlari"</td>	
		 </tr>
				<tr height="30">
		<td colspan="2" valign="bottom" align="left">Yeni Şifre Tekrarı(*)</td>
		
			<tr height="30">
		<td colspan="2" valign="top" align="left"><input type="password"name="SifreTekrari"class="InputAlanlari"</td>	
		 </tr>
			
			<tr height="40">
		<td colspan="2" align="center"><input type="submit" value="Şifremi Güncelle" class="KirmiziButon"></td>	
		 </tr>
		<tr height="30">
		<td colspan="2"><a>Yıldızlı Alanları Doldurmak (*) Zorunludur.</a></td>	
		 </tr>
	
</table>
			</form>
		</td>
	<td width="20">&nbsp;</td>
		
		
	<td valign="top" width="545"><table width="545"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr height="50">
		<td colspan="2" style="color: #FF9900" ><h3>Yeni Şifre Oluşturma</h3></td>	
		 </tr>
			<tr height="30">
		<td colspan="2" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Çalıştırma ve İşleyiş Açıklaması.</td>	
		 </tr>
		
		<tr height="5">
		<td colspan="2" height="5" style="font-size: 5px;">&nbsp;</td>	
		 </tr>
		
		
	 <tr height="30">
		<td align="left" width="30"><img src="Resimler/CarklarSiyah20x20.png" border="0" style="margin-top: 3px;"</td>
		<td align="left"><b>Bilgi Kontrolü</b></td>	
		 </tr>
		
		<tr height="30">
		<td colspan="2" align="left">Kullanıcının form alanına girmiş olduğu değer veya değerler veritabanımızda tam detaylı olarak filtrelenerek kontrol edilir.</td>	
		 </tr>
		<tr>
		<td  colspan="2">&nbsp;</td>
		</tr>
		
	 <tr height="30">
		<td align="left" width="30"><img src="Resimler/CarklarSiyah20x20.png" border="0" style="margin-top: 3px;"</td>
		<td align="left"><b>E-Mail Gönderimi  & İçerik</b></td>	
		 </tr>
		
		<tr height="30">
		<td colspan="2" align="left">Bilgi kontrolü başarılı olur ise, kullanıcının veritabanımızda kayıtlı olan e-mail adresine yeni şifre oluşturma içerikli bir mail gönderilir.</td>	
		 </tr>
		
		<tr>
		<td  colspan="2">&nbsp;</td>
		</tr>
		
	 <tr height="30">
		<td align="left" width="30"><img src="Resimler/CarklarSiyah20x20.png" border="0" style="margin-top: 3px;"</td>
		<td align="left"><b>Şifre Sıfırlama & Oluşturma</b></td>	
		 </tr>
		
		<tr height="30">
		<td colspan="2" align="left">Kullanıcı, kendisine iletilen mail içerisindeki "Yeni Şifre Oluştur" metnine tıklayacak olur ise, site yeni şifre oluşturma sayfası açılır ve kullanıcıdan,yeni hesap şifresini oluşturması istenir </td>	
		 </tr>
		
		<tr>
		<td  colspan="2">&nbsp;</td>
		</tr>
		
		<tr height="30">
		<td align="left" width="30"><img src="Resimler/CarklarSiyah20x20.png" border="0" style="margin-top: 3px;"</td>
		<td align="left"><b>Sonuç</b></td>	
		 </tr>
		
		<tr height="30">
		<td colspan="2" align="left">Kullanıcı yeni oluşturmuş olduğu hesap şifresi ile siteye giriş yapmaya hazrıdır.</td>	
		 </tr>
		

		
		</table>
		</td>

	
	</tr>
</table>
<?php
				}
					else{ 
					header("Location:index.php");
					exit();
				}
}else{
					header("Location:index.php");
					exit();
				}
					?>