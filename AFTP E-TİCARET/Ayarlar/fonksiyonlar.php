<?php
$IPAdresi     		= $_SERVER["REMOTE_ADDR"];
$ZamanDamgasi 		= time();
$TarihSaat    		= date("d.m.Y H:i:s",$ZamanDamgasi);

function RakamlarHaricTumKarekterleriSil($Deger){
	$Islem			= preg_replace("/[^0-9]/","",$Deger);
	$Sonuc 			= $Islem;
	return $Sonuc;
}
function TumBosluklariiSil($Deger){
	$Islem			= preg_replace("/[\|s&nbsp;]/","",$Deger);
	$Sonuc 			= $Islem;
	return $Sonuc;
}
function DonusumleriGeriDondur($Deger){
	$GeriDondur     = htmlspecialchars_decode($Deger,ENT_QUOTES);
	$Sonuc 			= $GeriDondur;
	return 			$Sonuc;

}


function Guvenlik($Deger){
	$BoslukSil      = trim($Deger);
	$TaglariTemizle = strip_tags($BoslukSil);
	$EtkisizYap     = htmlspecialchars($TaglariTemizle);
	$Sonuc          = $EtkisizYap ;
	
	return $Sonuc;
}


function SayiliIcerikleriFiltrele($Deger){
	$BoslukSil      = trim($Deger);
	$TaglariTemizle = strip_tags($BoslukSil);
	$EtkisizYap     = htmlspecialchars($TaglariTemizle);
	$Temizle		= RakamlarHaricTumKarekterleriSil($EtkisizYap);
	$Sonuc          = $Temizle ;
	
	return $Sonuc;
}
function IbanBicimlendir($Deger){
	$BoslukSil      = trim($Deger);
	$TumBoslukSil   =TumBosluklariiSil($Deger);
	$BirinciBlok	= substr($TumBoslukSil,0,4);
	$IkicinciBlok 	= substr($TumBoslukSil,4,4);
	$UcuncuBlok 	= substr($TumBoslukSil,8,4);
	$DorduncuBlok 	= substr($TumBoslukSil,12,4);
	$BesinciBlok 	= substr($TumBoslukSil,16,4);
	$AltinciBlok 	= substr($TumBoslukSil,20,4);
	$YedinciBlok 	= substr($TumBoslukSil,24,2);
	$Duzenle 		= $BirinciBlok." ".$IkicinciBlok." ".$UcuncuBlok." ".$DorduncuBlok." ".$BesinciBlok." ".$AltinciBlok." ".$YedinciBlok;
	$Sonuc          = $Duzenle;
	
	return $Sonuc;
}



















?>