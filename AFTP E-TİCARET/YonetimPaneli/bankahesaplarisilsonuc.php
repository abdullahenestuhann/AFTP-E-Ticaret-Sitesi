<?php
if ( isset( $_SESSION[ "Yonetici" ] ) ) {

  if ( isset( $_GET[ "ID" ] ) ) {
    $GelenID = Guvenlik( $_GET[ "ID" ] );
  } else {
    $GelenID = "";
  }


  if ( ( $GelenID != "" ) ) {

    $HavaleBildirimSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM havalebildirimleri where BankaId =?" );
    $HavaleBildirimSorgusu->execute( [ $GelenID ] );
    $HavaleBildirimSayisi = $HavaleBildirimSorgusu->rowCount();

    if ( $HavaleBildirimSayisi > 0 ) {
      header( "Location:index.php?SKD=0&SKI=20" );
      exit();
    } else {
      $HesapSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM bankahesaplarimiz where id =?" );
      $HesapSorgusu->execute( [ $GelenID ] );
      $HesapSayisi = $HesapSorgusu->rowCount();
      $HesapKaydi = $HesapSorgusu->fetch( PDO::FETCH_ASSOC );

      $SilinecekDosyaYolu = "../Resimler/" . $HesapKaydi[ "BankaLogosu" ];

      $HesapSilmeSorgusu = $VeritabaniBaglantisi->prepare( "DELETE FROM bankahesaplarimiz where id =? LIMIT 1" );
      $HesapSilmeSorgusu->execute( [ $GelenID ] );
      $HesapSilmeKontrol = $HesapSilmeSorgusu->rowCount();

      if ( $HesapSilmeKontrol > 0 ) {
        unlink( $SilinecekDosyaYolu );
        header( "Location:index.php?SKD=0&SKI=19" );
        exit();
      } else {
        header( "Location:index.php?SKD=0&SKI=20" );
        exit();
      }

    }


  } else {
    header( "Location:index.php?SKD=0&SKI=20" );
    exit();
  }
} else {
  header( "Location:index.php?SKD=1" );
  exit();
}
?>