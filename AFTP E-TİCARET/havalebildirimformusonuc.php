<?php
if ( isset( $_POST[ "AdiSoyadi" ] ) ) {
  $GelenIsimSoyisim = Guvenlik( $_POST[ "AdiSoyadi" ] );
} else {
  $GelenIsimSoyisim = "";
}
if ( isset( $_POST[ "E-MailAdresi" ] ) ) {
  $GelenEMailAdresi = Guvenlik( $_POST[ "E-MailAdresi" ] );
} else {
  $GelenEMailAdresi = "";
}
if ( isset( $_POST[ "TelefonNumarasi" ] ) ) {
  $GelenTelefonNumarasi = Guvenlik( $_POST[ "TelefonNumarasi" ] );
} else {
  $GelenTelefonNumarasi = "";
}
if ( isset( $_POST[ "BankaSecimi" ] ) ) {
  $GelenBankaSecimi = Guvenlik( $_POST[ "BankaSecimi" ] );
} else {
  $GelenBankaSecimi = "";
}
if ( isset( $_POST[ "Aciklama" ] ) ) {
  $GelenAciklama = Guvenlik( $_POST[ "Aciklama" ] );
} else {
  $GelenAciklama = "";
}
if ( ( $GelenIsimSoyisim != "" )and( $GelenEMailAdresi != "" )and( $GelenTelefonNumarasi != "" )and( $GelenBankaSecimi != "" ) ) {
  $HavaleBildirimleriKaydet = $VeritabaniBaglantisi->prepare( "INSERT INTO havalebildirimleri(BankaId,AdiSoyadi,EmailAdresi,TelefonNumarasi,Aciklama,IslemTarihi,Durum) values(?,?,?,?,?,?,?)" );

  $HavaleBildirimleriKaydet->execute( [ $GelenBankaSecimi, $GelenIsimSoyisim, $GelenEMailAdresi, $GelenTelefonNumarasi, $GelenAciklama, $ZamanDamgasi, 0 ] );
  $HavaleBildirimleriKaydetKontrol = $AyarlarSorgusu->rowCount();
  if ( $HavaleBildirimleriKaydetKontrol > 0 ) {
    header( "Location:index.php?SK=11" );
    exit();
  } else {
    header( "Location:index.php?SK=12" );
    exit();
  }

} else {
  header( "Location:index.php?SK=13" );
  exit();

}


?>