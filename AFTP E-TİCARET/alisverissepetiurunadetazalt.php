<?php
if(isset($_SESSION["Kullanici"])){
if(isset($_GET["ID"])){
	$GelenID =  Guvenlik($_GET["ID"]);
}else{
	$GelenID = "";
}
	
if($GelenID!=""){	
	

			$SepetGuncellemeSorgusu= $VeritabaniBaglantisi -> prepare("UPDATE sepet set UrunAdedi = UrunAdedi-1 where id= ? and UyeId=? LIMIT 1");
			$SepetGuncellemeSorgusu -> execute([$GelenID,$KullaniciId]);
			$SepetGuncellemeSayisi     = $SepetGuncellemeSorgusu->rowCount();
	if($SepetGuncellemeSayisi>0){
		header("Location:index.php?SK=94");
		exit();
	}else{
		header("Location:index.php?SK=94");
		exit();
	}
}else{
	header("Location:index.php?SK=94");
	exit();
}

}else{
	header("Location:index.php");
	exit();
}
?>