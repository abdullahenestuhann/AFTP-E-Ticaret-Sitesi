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
<form action="index.php?SK=99" method="post">
  <table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="800" valign="top"><table width="800"   align="center" border="0" cellpadding="0" cellspacing="0">
          <tr height="50">
            <td  style="color: #FF9900"><h3>Alışveriş Sepeti</h3></td>
          </tr>
          <tr height="30">
            <td  valign="top" style="border-bottom: 1px dashed #CCCCCC;">Adres ve Kargo Seçimini Aşağıdan Belirtebilirsiniz.</td>
          </tr>
          <tr height="10">
            <td style="font-size: 10px">&nbsp;</td>
          </tr>
          <tr height="40">
            <td align="left" style="background: #CCCCCC; font-weight: bold;">&nbsp;Adres Seçimi</td>
            <td align="right" style="background: #CCCCCC; font-weight: bold;"><a href="index.php?SK=70" style="color: #646464; text-decoration: none; font-weight: bold;">+ Yeni Adres Ekle&nbsp;</a></td>
          </tr>
          <?php


          $SepettekiUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "Select * from sepet where UyeId=? order by id desc" );
          $SepettekiUrunlerSorgusu->execute( [ $KullaniciId ] );
          $SepettekiUrunSayisi = $SepettekiUrunlerSorgusu->rowCount();
          $SepettekiKayitlar = $SepettekiUrunlerSorgusu->fetchAll( PDO::FETCH_ASSOC );

          if ( $SepettekiUrunSayisi > 0 ) {
            $SepettekiToplamUrunSayisi = 0;
            $SepettekiToplamFiyat = 0;
            $SepettekiToplamKargoFiyati = 0;

            foreach ( $SepettekiKayitlar as $SepetSatirlari ) {
              $SepetIdsi = $SepetSatirlari[ "id" ];
              $SepettekiUrununIdsi = $SepetSatirlari[ "UrunId" ];
              $SepettekiUrununVaryantIdsi = $SepetSatirlari[ "VaryantId" ];
              $SepettekiUrununAdedi = $SepetSatirlari[ "UrunAdedi" ];

              $UrunBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunler where id=? LIMIT 1" );
              $UrunBilgileriSorgusu->execute( [ $SepettekiUrununIdsi ] );
              $UrunKaydi = $UrunBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

              $UrununFiyati = $UrunKaydi[ "UrunFiyati" ];
              $UrununParaBirimi = $UrunKaydi[ "ParaBirimi" ];
              $UrununKargoUcreti = $UrunKaydi[ "KargoUcreti" ];


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

              $SepettekiToplamKargoFiyatiHesapla = $UrununKargoUcreti;
              $SepettekiToplamKargoFiyatiBicimlendir = FiyatBicimlendir( $SepettekiToplamKargoFiyatiHesapla );
            }

            if ( $SepettekiToplamFiyat >= $UcretsizKargoBaraji ) {
              $SepettekiToplamKargoFiyatiHesapla = 0;
              $SepettekiToplamKargoFiyatiBicimlendir = FiyatBicimlendir( $SepettekiToplamKargoFiyatiHesapla );

              $OdenecekToplamTutariBicimlendir = FiyatBicimlendir( $SepettekiToplamFiyat );
            } else {
              $OdenecekToplamTutariHesapla = ( $SepettekiToplamFiyat + $SepettekiToplamKargoFiyatiHesapla );
              $OdenecekToplamTutariBicimlendir = FiyatBicimlendir( $OdenecekToplamTutariHesapla );
            }


            $AdreslerSorgusu = $VeritabaniBaglantisi->prepare( "Select * from adresler where UyeId=? order by id desc" );
            $AdreslerSorgusu->execute( [ $KullaniciId ] );
            $AdresSayisi = $AdreslerSorgusu->rowCount();
            $AdresKayitlari = $AdreslerSorgusu->fetchAll( PDO::FETCH_ASSOC );

            if ( $AdresSayisi > 0 ) {
              foreach ( $AdresKayitlari as $AdresSatirlari ) {


                ?>
          <tr>
            <td colspan="2" align="left"><table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                  <td width="25" style="border-bottom: 1px dashed #CCCCCC;" align="left"><input type="radio" name="AdresSecimi" checked="checked" value="<?php echo DonusumleriGeriDondur($AdresSatirlari["id"]); ?>"></td>
                  <td width="775" style="border-bottom: 1px dashed #CCCCCC;" align="left"><?php echo DonusumleriGeriDondur($AdresSatirlari["AdiSoyadi"]); ?> - <?php echo DonusumleriGeriDondur($AdresSatirlari["Adres"]); ?> <?php echo DonusumleriGeriDondur($AdresSatirlari["Ilce"]); ?> / <?php echo DonusumleriGeriDondur($AdresSatirlari["Sehir"]); ?> - <?php echo DonusumleriGeriDondur($AdresSatirlari["TelefonNumarasi"]); ?></td>
                </tr>
              </table></td>
          </tr>
          <?php

          }
          } else {
            ?>
          <tr height="50">
            <td colspan="2" align="left">Sisteme kayıtlı adresiniz bulunmamaktadır. Lütfen öncelikle "Hesabım" alanından "Adres" ekleyiniz. Adres eklemek için lütfen <a href="index.php?SK=70" style="color: #646464; text-decoration: none; font-weight: bold;">buraya tıklayınız</a>.</td>
          </tr>
          <?php
          }
          ?>
          <tr height="10">
            <td style="font-size: 10px">&nbsp;</td>
          </tr>
          <tr height="50">
            <td colspan="2" align="left" style="background:#CCCCCC; font-weight: bold;"  >&nbsp;Kargo Firması Seçimi</td>
          </tr>
          <tr height="10">
            <td style="font-size: 10px">&nbsp;</td>
          </tr>
          <tr height="40">
            <td colspan="2" align="left" ><table width="800"align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <?php
                  $KargolarSorgusu = $VeritabaniBaglantisi->prepare( "select * from kargofirmalari" );
                  $KargolarSorgusu->execute();
                  $KargoSayisi = $KargolarSorgusu->rowCount();
                  $KargoKayitlari = $KargolarSorgusu->fetchALL( PDO::FETCH_ASSOC );

                  $DonguSayisi = 1;
                  $SutunAdetSayisi = 3;

                  foreach ( $KargoKayitlari as $KargoKaydi ) {

                    ?>
                  <td  width="260" ><table  width="260"  align="center"  border="0"  cellpadding="0" cellspacing="0" style="border: 1px solid #CCCCCC; margin-bottom:10px">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr height="40">
                        <td  align="center"><img src="Resimler/<?php echo DonusumleriGeriDondur($KargoKaydi["KargoFirmasiLogosu"]);?>" border="0"></td>
                      </tr>
                      <tr height="25">
                        <td align="center"><input type="radio" name="KargoSecimi" value="<?php echo DonusumleriGeriDondur($KargoKaydi["id"]);?>"</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  <?php

                  if ( $DonguSayisi > $SutunAdetSayisi ) {
                    ?>
                  <td width="10">&nbsp;</td>
                  <?php
                  }

                  ?>
                  <?php
                  $DonguSayisi++;
                  if ( $DonguSayisi > $SutunAdetSayisi ) {
                    echo "</tr><tr>";
                    $DonguSayisi = 1;
                  }
                  }
                  ?>
                </tr>
              </table></td>
          </tr>
          <?php
          } else {
            header( "Location:index.php?SK=94" );
            exit();
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
            <td align="right">Ürünler Tutar</td>
          </tr>
          <tr>
            <td  align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?></td>
          </tr>
          <tr>
            <td align="right">Toplam Kargo Ücreti</td>
          </tr>
          <tr>
            <td  align="right" style="font-size: 25px; font-weight: bold;"><?php echo  $SepettekiToplamKargoFiyatiBicimlendir; ?></td>
          </tr>
          <tr>
            <td align="right">Ödenecek Tutar(KDV DAHİL)</td>
          </tr>
          <tr>
            <td  align="right" style="font-size: 25px; font-weight: bold;"><?php echo  $OdenecekToplamTutariBicimlendir; ?></td>
          </tr>
          <tr>
            <td align="right"><input type="submit" value="ALIŞVERİŞİ TAMAMLA" class="AlisverisiTamamlaButonu">

          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
} else {
  header( "Location:index.php" );
  exit();
}
?>
