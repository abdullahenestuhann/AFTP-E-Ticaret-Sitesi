<?php
if(isset($_SESSION["Kullanici"])){
if(isset($_GET["ID"])){
	$GelenID =  Guvenlik($_GET["ID"]);
}else{
	$GelenID = "";
}
if($GelenID!=""){
			$SepetSilSorgusu= $VeritabaniBaglantisi -> prepare("Delete from sepet where id= ? and UyeId=? LIMIT 1");
			$SepetSilSorgusu -> execute([$GelenID,$KullaniciId]);
			$SepetSilmeSayisi     = $SepetSilSorgusu->rowCount();
	if($SepetSilmeSayisi>0){
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