<?php
require_once("Ayarlar/ayar.php");	
require_once("Ayarlar/fonksiyonlar.php");
require_once("Ayarlar/SiteSayfalari.php");
if(isset($_REQUEST["SK"])){
	$SayfaKoduDegeri =  SayiliIcerikleriFiltrele($_REQUEST["SK"]);
}else{
	$SayfaKoduDegeri=0;
}
?>
	 


<!doctype html>
<html lang="tr-TR">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<meta http-equiv="Content-Language" content="tr">
<meta charset="utf-8">
<meta name="Robots"	       content="index ,follow">
<meta name="googlebot"     content="index ,follow">
<meta name="revisit-after" content="7 Days">

<title><?php echo  DonusumleriGeriDondur($SiteTitle); ?></title>
<link type="image/png" rel="icon" href="Resimler/fav-icon.png">
<meta name="Description" content="<?php echo  DonusumleriGeriDondur($SiteDescription)?>">
<meta name="Keywords" content="<?php echo     DonusumleriGeriDondur($SiteKeywords)?>">
<script type="text/javascript" src="Frameworks/JQuery/jquery-3.6.0.min.js" language="javascript"></script>
<link type="text/css" rel="stylesheet" href="Ayarlar/still.css">
<script type="text/javascript" src="Ayarlar/fonksiyonlar.js" language="javascript"></script>

</head>

<body>	
	 <table width="1065" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="40" bgcolor="#353745">
		 <td><img src="Resimler/HeaderMesajResmi.png" border="0"></td>
		 </tr>
		 <tr height="110">
		 <td>
			 <table width="1065" height="30%"  align="center" border="0" cellpadding="0" cellspacing="0">
			 
			 	<tr bgcolor="#0088CC">
				 	<td>&nbsp;</td>
					<td width="20"><a href="xxxxx"><img src="Resimler/KullaniciBeyaz16x16.png" border="0" style="margin-top:5px;"></a></td>
					<td width="70" class="MaviAlanMenusu"><a href="xxxxx">Giriş Yap</a></td>
					<td width="20"><a href="xxxxx"><img src="Resimler/KullaniciEkleBeyaz16x16.png" border="0" style="margin-top:5px;"></a></td>
					<td width="85" class="MaviAlanMenusu"><a href="xxxxx">Yeni Üye Ol</a></td>
					<td width="20"><a href="xxxxx"><img src="Resimler/SepetBeyaz16x16.png"border=0 style="margin-top:5px;"></a></td>
					<td width="103" class="MaviAlanMenusu"><a href="xxxxx">Alışveriş Sepeti</a></td>		
				 </tr>
			 </table>
			 
			 <table width="1065" height="80%"  align="center" border="0" cellpadding="0" cellspacing="0">
			 	<tr>
				 	<td width="192"><a href="index.php?"><img src="Resimler/<?php echo DonusumleriGeriDondur($SiteLogosu)?>"border="0"><a/></td>
					<td>
					
						<table width="873" height="30%"  align="center" border="0" cellpadding="0" cellspacing="0">
			 	<tr>
					<td width="523" class="AnaMenu">&nbsp;</td>
				 	<td width="100" class="AnaMenu"><a href="index.php?">Anasayfa<a/></td>
					<td width="130" class="AnaMenu"><a href="xxxxx">Kayısı Çeşitleri<a/></td>
					<td width="120" class="AnaMenu"><a href="xxxxx">Kuruyemiş<a/></td>
					<td></td>
							
				 </tr>
			 </table>			
					</td>	
		
				 </tr>
			 </table></td>
		 
		 
		 
		 </tr>
		  <tr>
		 <td valign="top"><table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0"> 
			 	<tr >
					<td align="center"><?php
					if((!$SayfaKoduDegeri) or($SayfaKoduDegeri=="") or ($SayfaKoduDegeri==0)){
						include($Sayfa[0]);
						
					}else{
						include($Sayfa[$SayfaKoduDegeri]);

					}
					
					
					?><br /></td>
							
				 </tr>
			 
			 </table></td>
		 </tr>
		 
		 
		 
		<tr height="210">

		<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F9F9"> 
			 	<tr height="30">
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;"><b>&nbsp;Kurumsal</b></td>
					<td width="22">&nbsp;</td>
					<td width="250"  style="border-bottom: 1px dashed #CCCCCC;"><b>Üyelik & Hizmetler</b></td>
					<td width="22">&nbsp;</td>
					<td width="250"  style="border-bottom: 1px dashed #CCCCCC;"><b>Sözleşmeler</b></td>
					<td width="21">&nbsp;</td><b>
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;"><b>Bizi Takip Edin</b></td>					
							
				 </tr>
			 
			 <tr height="30">
					<td class="AltMenu">&nbsp;<a href="index.php?SK=1">Hakkımızda<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">Giriş Yap<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=2">Üyelik Sözleşmesi<a/></td>
					<td>&nbsp;</td>
					<td ><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						
						
						
						
						
						
						

						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/Facebook16x16.png" border="0" style="margin-top:5px;"<a/></td>
							<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkFacebook)?>"target="_blank">Facebook<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
			  <tr height="30">
					<td class="AltMenu">&nbsp;<a href="xxxxx">Banka Hesapları<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">Yeni Üye Ol<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=3">Kullanım Koşulları<a/></td>
					<td>&nbsp;</td>
					<td><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/Twitter16x16.png" border="0" style="margin-top:5px;"<a/></td>
							<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkTwitter)?>"target="_blank">Twitter<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
			  <tr height="30">
					<td class="AltMenu"><a href="xxxxx">&nbsp;Havale Bildirim Fonu<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">Sık Sorulan Sorular<a/></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=4">Gizlilik Sözleşmesi<a/></td>
					<td>&nbsp;</td>
					<td><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/Instagram16x16.png" border="0" style="margin-top:5px;"<a/></td>
							<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkInstagram)?>"target="_blank">İnstagram<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
			  <tr height="30">
					<td class="AltMenu">&nbsp;<a href="xxxxx">Kargom Nerede<a/></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=5">Mesafeli Satış Sözleşmesi<a/></td>
					<td>&nbsp;</td>
					<td><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/LinkedIn16x16.png" border="0" style="margin-top:5px;"<a/></td>
							<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkLinkedin)?>"target="_blank">Linkedin<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
			 <tr height="30" >
					<td class="AltMenu">&nbsp;<a href="xxxxx">İletişim<a/></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=6">Teslimat<a/></td>
					<td>&nbsp;</td>
					<td><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/Pinterest16x16.png" border="0"<a/></td>
							<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkPinterest)?>"target="_blank">Pinterest<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
			  <tr  height="30">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php?SK=7">İptal & İade & Değişim<a/></td>
					<td>&nbsp;</td>
					<td><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td width="20"><a href="xxxxx"><img src="Resimler/YouTube16x16.png" border="0" style="margin-top:5px;"<a/></td>
						<td width="230" class="AltMenu"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkYoutube)?>"target="_blank">Youtube<a/></td>
						</tr>
	</table></td>					
							
				 </tr>
	</table> </td>
		 </tr>
		 
		 
		 
		 <tr height="30">
		 <td><table width="1065" height="30"   align="center" border="0" cellpadding="0" cellspacing="0"> 
			 	<tr>
					<td align="center"><?php echo  DonusumleriGeriDondur($SiteCopyrightMetni)?></td>
							
				 </tr>
			 
			</table> </td>
		 </tr>
		 		
		 <tr height="30">
		 <td><table width="1065" height="30"   align="center" border="0" cellpadding="0" cellspacing="0"> 
			 	<tr >
					<td align="center"><img src="Resimler/RapidSSL32x12.png" border=0 style="margin-right: 5px"><img src="Resimler/InternetteGuvenliAlisveris28x12.png" border=0 style="margin-right: 5px"><img src ="Resimler/3DSecure14x12.png" border=0 style="margin-right: 5px"><img src="Resimler/BonusCard41x12.png" border=0 style="margin-right: 5px"><img src="Resimler/WorldCard48x12.png" border=0 style="margin-right: 5px"><img src="Resimler/CardFinans78x12.png" border=0 style="margin-right: 5px"><img src="Resimler/AxessCard46x12.png" border=0 style="margin-right: 5px"><img src="Resimler/ParafCard19x12.png" border=0 style="margin-right: 5px"><img src="Resimler/VisaCard37x12.png" border=0 style="margin-right: 5px"><img src="Resimler/MasterCard21x12.png" border=0 style="margin-right: 5px"><img src="Resimler/AmericanExpiress20x12.png" border=0></td>
							
				 </tr>
			 
			</table> </td>
		 </tr>

		 
	</table>	 
 </body>	
</html>
<?php
	$VeritabaniBaglantisi = null;
	?>