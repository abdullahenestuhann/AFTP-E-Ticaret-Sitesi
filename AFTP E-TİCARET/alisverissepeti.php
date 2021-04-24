<?php
if ( isset( $_SESSION[ "Kullanici" ] ) ) {

  $StokIcinSepettekiUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "Select * from sepet where UyeId=? order by id desc" );
  $StokIcinSepettekiUrunlerSorgusu->execute( [ $KullaniciId ] );
  $StokIcinSepettekiUrunSayisi = $StokIcinSepettekiUrunlerSorgusu->rowCount();
  $StokIcinSepettekiKayitlar = $StokIcinSepettekiUrunlerSorgusu->fetchAll( PDO::FETCH_ASSOC );

  if ( $StokIcinSepettekiUrunSayisi > 0 ) {

    foreach ( $StokIcinSepettekiKayitlar as $StokIcinSepettekiSatirlar ) {

      $StokIcinSepetIdsi = $StokIcinSepettekiSatirlar[ "id" ];
      $StokIcinSepetUrunId = $StokIcinSepettekiSatirlar[ "UrunId" ];
      $StokIcinSepettekiUrununVaryantIdsi = $StokIcinSepettekiSatirlar[ "VaryantId" ];
      $StokIcinSepettekiUrununAdedi = $StokIcinSepettekiSatirlar[ "UrunAdedi" ];


      $StokIcinUrunVaryantBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunvaryanlari where UrunId=? LIMIT 1" );
      $StokIcinUrunVaryantBilgileriSorgusu->execute( [ $StokIcinSepetUrunId ] );
      $StokIcinVaryanKaydi = $StokIcinUrunVaryantBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

      $StokIcinUrununStokAdedi = $StokIcinVaryanKaydi[ "StokAdedi" ];
      if ( $StokIcinUrununStokAdedi == 0 ) {
        $SepetSilSorgusu = $VeritabaniBaglantisi->prepare( "DELETE FROM sepet WHERE id = ? AND UyeId = ? LIMIT 1" );
        $SepetSilSorgusu->execute( [ $StokIcinSepetIdsi, $KullaniciId ] );
      } elseif ( $StokIcinSepettekiUrununAdedi > $StokIcinUrununStokAdedi ) {
        $SepetGuncellemeSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE sepet SET UrunAdedi= ? WHERE id = ? AND UyeId = ? LIMIT 1" );
        $SepetGuncellemeSorgusu->execute( [ $StokIcinUrununStokAdedi, $StokIcinSepetIdsi, $KullaniciId ] );
      }

    }

  }
  $SepetSifirlamaSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE sepet SET AdresId= ?, KargoId = ?, OdemeSecimi = ?, TaksitSecimi = ? WHERE UyeId = ?" );
  $SepetSifirlamaSorgusu->execute( [ 0, 0, "", 0, $KullaniciId ] )

  ?>
<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="800" valign="top"><table width="800"   align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="50">
          <td  style="color: #FF9900"><h3>Alışveriş Sepeti</h3></td>
        </tr>
        <tr height="30">
          <td  valign="top" style="border-bottom: 1px dashed #CCCCCC;">Alışveriş Sepetine Eklemiş Olduğunuz Ürünler Aşağıdadır.</td>
        </tr>
        <?php
        $SepettekiUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "Select * from sepet where UyeId=? order by id desc" );
        $SepettekiUrunlerSorgusu->execute( [ $KullaniciId ] );
        $SepettekiUrunSayisi = $SepettekiUrunlerSorgusu->rowCount();
        $SepettekiKayitlar = $SepettekiUrunlerSorgusu->fetchAll( PDO::FETCH_ASSOC );

        if ( $SepettekiUrunSayisi > 0 ) {
          $SepettekiToplamUrunSayisi = 0;
          $SepettekiToplamFiyat = 0;

          foreach ( $SepettekiKayitlar as $SepetSatirlari ) {
            $SepetIdsi = $SepetSatirlari[ "id" ];
            $SepettekiUrununIdsi = $SepetSatirlari[ "UrunId" ];
            $SepettekiUrununVaryantIdsi = $SepetSatirlari[ "VaryantId" ];
            $SepettekiUrununAdedi = $SepetSatirlari[ "UrunAdedi" ];

            $UrunBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunler where id=? LIMIT 1" );
            $UrunBilgileriSorgusu->execute( [ $SepettekiUrununIdsi ] );
            $UrunKaydi = $UrunBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

            $UrununTuru = $UrunKaydi[ "UrunTuru" ];

            $UrununResmi = $UrunKaydi[ "UrunResmiBir" ];
            $UrununAdi = $UrunKaydi[ "UrunAdi" ];
            $UrununFiyati = $UrunKaydi[ "UrunFiyati" ];
            $UrununParaBirimi = $UrunKaydi[ "ParaBirimi" ];

            $UrunVaryantBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunvaryanlari where id=? LIMIT 1" );
            $UrunVaryantBilgileriSorgusu->execute( [ $SepettekiUrununVaryantIdsi ] );
            $VaryanKaydi = $UrunVaryantBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );
            $UrununStokAdedi = $VaryanKaydi[ "StokAdedi" ];


            if ( $UrununTuru == "Kuruyemis" ) {
              $UrunResimleriKlasoru = "kuruyemis";
            } elseif ( $UrununTuru == "Kayisi" ) {
              $UrunResimleriKlasoru = "kayisi";
            } else {
              $UrunResimleriKlasoru = "bos";
            }

            if ( $UrununParaBirimi == "USD" ) {
              $UrunFiyatiHesapla = $UrununFiyati * $DolarKuru;
              $UrunFiyatiBicimlendir = FiyatBicimlendir( $UrunFiyatiHesapla );
            } elseif ( $UrununParaBirimi == "EUR" ) {
              $UrunFiyatiHesapla = $UrununFiyati * $EuroKuru;
              $UrunFiyatiBicimlendir = FiyatBicimlendir( $UrunFiyatiHesapla );
            } else {
              $UrunFiyatiHesapla = $UrununFiyati;
              $UrunFiyatiBicimlendir = FiyatBicimlendir( $UrunFiyatiHesapla );
            }
            $UrunToplamFiyatiHesapla = ( $UrunFiyatiHesapla * $SepettekiUrununAdedi );
            $UrunToplamFiyatiBicimlendir = FiyatBicimlendir( $UrunToplamFiyatiHesapla );

            $SepettekiToplamUrunSayisi += $SepettekiUrununAdedi;
            $SepettekiToplamFiyat += ( $UrunFiyatiHesapla * $SepettekiUrununAdedi );
            ?>
        <tr height="100">
          <td  valign="bottom" align="left"><table width="800"   align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="80" style="border-bottom: 1px dashed #CCCCCC; "align="left"><img src="Resimler/UrunResimleri/<?php echo $UrunResimleriKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrununResmi) ; ?>" border="0" width="60" height="80"></td>
                <td width="40" style="border-bottom: 1px dashed #CCCCCC;"align="left"><a href="index.php?SK=95&ID=<?php echo DonusumleriGeriDondur($SepetIdsi);?>"><img src="Resimler/SilDaireli20x20.png" border ="0"></a></td>
                <td width="540" style="border-bottom: 1px dashed #CCCCCC;"align="left"><?php echo DonusumleriGeriDondur($UrununAdi); ?></td>
                <td width="90" style="border-bottom: 1px dashed #CCCCCC;"align="left"><table width="90"   align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="30" align="center"><?php if($SepettekiUrununAdedi>1){?>
                        <a href="index.php?SK=96&ID=<?php echo DonusumleriGeriDondur($SepetIdsi);?>"style="text-decoration: none; color: #646464"> <img src="Resimler/AzaltDaireli20x20.png" border ="0" style="margin-top: 5px;"></a>
                        <?php }else{?>
                        &nbsp;
                        <?php } ?></td>
                      <td width="30" align="center"><?php echo DonusumleriGeriDondur($SepettekiUrununAdedi);?></td>
                      <td width="30" align="center"><a href="index.php?SK=97&ID=<?php echo DonusumleriGeriDondur($SepetIdsi);?>"><img src="Resimler/ArttirDaireli20x20.png" border ="0" style="margin-top: 5px;" ></a></td>
                    </tr>
                  </table></td>
                <td width="150" style="border-bottom: 1px dashed #CCCCCC;"align="right"><?php echo $UrunFiyatiBicimlendir;?> TL<br />
                  Toplam Ürün Fiyati: <?php echo $UrunToplamFiyatiBicimlendir;?> TL </td>
              </tr>
            </table></td>
        </tr>
        <?php
        }
        } else {
          $SepettekiToplamUrunSayisi = 0;
          $SepettekiToplamFiyat = 0;
          ?>
        <tr height="30">
          <td  valign="bottom" align="left">Alışveriş Sepetinizde Ürün Bulunmamaktadır</td>
        </tr>
        <?php
        }
        ?>
      </table></td>
    <td width="15">&nbsp;</td>
    <td valign="top" width="250"><table width="250"   align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="50">
          <td  style="color: #FF9900" align="right" ><h3>Sipariş Özeti</h3></td>
        </tr>
        <tr height="30">
          <td c valign="top" style="border-bottom: 1px dashed #CCCCCC; "align="right">Toplam <b style="color:#ED701B;"><?php echo $SepettekiToplamUrunSayisi; ?></b> Adet Ürün</td>
        </tr>
        <tr height="5">
          <td  height="5" style="font-size: 5px;">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">Ödenecek Tutar(KDV DAHİL)</td>
        </tr>
        <tr>
          <td  align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?></td>
        </tr>
        <tr>
          <td><a href="index.php?SK=98" style="color: white; font-size: 20px; font-weight: bold;text-decoration: none;">
            <div class="SepetIciDevamEtVeAlisverisiTamamlaButonu"><img src="Resimler/SepetBeyaz21x20.png" border="0" style="margin-top: 5px; "> DEVAM ET</div>
            </a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
} else {
  header( "Location:index.php" );
  exit();
}
?>
