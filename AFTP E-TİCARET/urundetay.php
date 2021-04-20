<?php
if ( isset( $_GET[ "ID" ] ) ) {
  $GelenId = SayiliIcerikleriFiltrele( Guvenlik( $_GET[ "ID" ] ) );

  $UrunHitiGuncellemeSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE urunler SET  GoruntulenmeSayisi=GoruntulenmeSayisi+1 where id=? and Durumu=? LIMIT 1 " );
  $UrunHitiGuncellemeSorgusu->execute( [ $GelenId, 1 ] );


  $UrunSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM urunler  WHERE id=? and Durumu=? LIMIT 1 " );
  $UrunSorgusu->execute( [ $GelenId, 1 ] );
  $UrunSayisi = $UrunSorgusu->rowCount();
  $UrunSorgusuKaydi = $UrunSorgusu->fetch( PDO::FETCH_ASSOC );

  if ( $UrunSayisi > 0 ) {
    $UrunTuru = $UrunSorgusuKaydi[ "UrunTuru" ];
    if ( $UrunTuru == "Kuruyemis" ) {
      $ResimKlasoru = "kuruyemis";
    } elseif ( $UrunTuru == "Kayisi" ) {
      $ResimKlasoru = "kayisi";
    } else {
      $ResimKlasoru = "bos";
    }
    $UrununFiyati = DonusumleriGeriDondur( $UrunSorgusuKaydi[ "UrunFiyati" ] );
    $UrununParaBirimi = DonusumleriGeriDondur( $UrunSorgusuKaydi[ "ParaBirimi" ] );

    if ( $UrununParaBirimi == "USD" ) {
      $UrunFiyatiHesapla = $UrununFiyati * $DolarKuru;
    } elseif ( $UrununParaBirimi == "EUR" ) {
      $UrunFiyatiHesapla = $UrununFiyati * $EuroKuru;
    } else {
      $UrunFiyatiHesapla = $UrununFiyati;
    }
    ?>
<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="350"  valign="top"><table width="350"   align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  style="border: 1px solid #CCCCCC;" align="center"><img id="BuyukResim" src="Resimler/UrunResimleri/<?php echo $ResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiBir"]);?>" width="330" height="440" border="0"></td>
        </tr>
        <tr>
          <td style="font-size: 5px;">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="350"   align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="78" style="border: 1px solid #CCCCCC;"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiBir"]);?>" width="78" height="104" border="0" onClick="$.UrunDetayResmiDegistir('<?php echo $ResimKlasoru; ?>','<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiBir"]);?>');"></td>
                <td width="10">&nbsp;</td>
                <?php if( DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiIki"])!=""){?>
                <td width="78" style="border: 1px solid #CCCCCC;"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiIki"]);?>" width="78" height="104" border="0" onClick="$.UrunDetayResmiDegistir('<?php echo $ResimKlasoru; ?>','<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiIki"]);?>');"></td>
                <?php }else{?>
                <td width="78">&nbsp;</td>
                <?php } ?>
                <td width="10">&nbsp;</td>
                <?php if( DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiUc"])!=""){?>
                <td width="78" style="border: 1px solid #CCCCCC;"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiUc"]);?>" width="78" height="104" border="0" onClick="$.UrunDetayResmiDegistir('<?php echo $ResimKlasoru; ?>','<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiUc"]);?>');"></td>
                <?php }else{?>
                <td width="78">&nbsp;</td>
                <?php } ?>
                <td width="10">&nbsp;</td>
                <?php if( DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiDort"])!=""){?>
                <td width="78" style="border: 1px solid #CCCCCC;"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiDort"]);?>" width="78" height="104" border="0" onClick="$.UrunDetayResmiDegistir('<?php echo $ResimKlasoru; ?>','<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiDort"]);?>');"></td>
                <?php }else{?>
                <td width="78">&nbsp;</td>
                <?php } ?>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="350"   align="center" border="0" cellpadding="0" cellspacing="0">
              <tr height="45">
                <td bgcolor="#F1F1F1"><b>&nbsp;REKLAMLAR</b></td>
              </tr>
              <?php
              $BannerSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM bannerlar WHERE BannerAlani = 'Ürün Detay' ORDER BY GosterimSayisi ASC LIMIT 1" );
              $BannerSorgusu->execute();
              $BannerSayisi = $BannerSorgusu->rowCount();
              $BannerKaydi = $BannerSorgusu->fetch( PDO::FETCH_ASSOC );

              ?>
              <tr height="350">
                <td><img src="Oluşumlar/BannerOrnekleri/<?php echo DonusumleriGeriDondur($BannerKaydi["BannerResmi"]);?>" border="0" </td>
              </tr>
              <?php
              $BannerGuncelle = $VeritabaniBaglantisi->prepare( "UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id= ? LIMIT 1 " );
              $BannerGuncelle->execute( [ DonusumleriGeriDondur( $BannerKaydi[ "id" ] ) ] );


              ?>
            </table></td>
        </tr>
      </table></td>
    <td width="10" valign="top">&nbsp;</td>
    <td width="705" valign="top"><table width="705"   align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="50" bgcolor="#F1F1F1">
          <td style="text-align: left; font-size: 18px;font-weight:bold;">&nbsp;<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunAdi"]); ?></td>
        </tr>
        <tr>
          <td><form action="index.php?SK=91&ID=<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["id"]); ?>" method="post">
              <table width="705"   align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="45">
                  <td width="30"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkFacebook)?>"target="_blank"><img src="Resimler/Facebook24x24.png" border="0" style="margin-top:5px;"><a/></td>
                  <td width="30"><a href="<?php echo  DonusumleriGeriDondur($SosyalLinkTwitter)?>"target="_blank"><img src="Resimler/Twitter24x24.png" border="0" style="margin-top:5px;"><a/></td>
                  <td width="30"><?php
                  if ( isset( $_SESSION[ "Kullanici" ] ) ) {
                    ?>
                    <a href="index.php?SK=87&ID=<?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["id"]); ?>"><img src="Resimler/KalpKirmiziDaireliBeyaz24x24.png" border="0" style="margin-top:5px;"><a/>
                    <?php } else{?>
                    <img src="Resimler/KalpKirmiziDaireliBeyaz24x24.png" border="0" style="margin-top:5px;">
                    <?php } ?></td>
                  <td width="10">&nbsp;</td>
                  <td width="605"><input type="submit" value="SEPETE EKLE" class="SepeteEkleButonu"</td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr>
          <td><hr /></td>
        </tr>
        <tr>
          <td><table width="705"   align="center" border="0" cellpadding="0" cellspacing="0">
              <tr height="30">
                <td><img src="Resimler/SaatEsnetikGri20x20.png" border="0" style="margin-top: 5px; "</td>
                <td><b>Siparişiniz <?php echo UcGunİleriTarihBul();?> tarihine kadar kargoya verilecektir.</b></td>
              </tr>
              <tr height="30">
                <td><img src="Resimler/SaatHizCizgiliLacivert20x20.png" border="0" style="margin-top: 5px; "</td>
                <td><b>İlgili Ürün İstanbul (Avrupa Yakası) ve Malatya Şehirleri için aynı gün elden teslim edilir.</b></td>
              </tr>
              <tr height="30">
                <td><img src="Resimler/KrediKarti20x20.png" border="0" style="margin-top: 5px; "</td>
                <td><b>Tüm Bankaların Kredi Kartları ile Peşin veya Taksitle Ödeme Seçeneği.</b></td>
              </tr>
              <tr height="30">
                <td><img src="Resimler/KrediKarti20x20.png" border="0" style="margin-top: 5px; "</td>
                <td><b>Tüm Bankalardan Havale veya EFT ile Ödeme Seçeneği.</b></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><hr /></td>
        </tr>
        <tr height="30">
          <td style="background:#FF9900; color: white;">&nbsp;Ürün Açıklaması</td>
        </tr>
        <tr>
          <td><?php echo DonusumleriGeriDondur($UrunSorgusuKaydi["UrunAciklamasi"]); ?></td>
        </tr>
        <tr height="30">
          <td style="background:#FF9900; color: white;">&nbsp;Ürün Yorumları</td>
        </tr>
        <tr>
          <td><div style="width: 705px; max-width: 705px; height: 300px; max-height: 300px overflow-y: scroll;">
              <table width="685"   align="left" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <?php
                  $YorumlarSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM yorumlar WHERE UrunId = ? ORDER BY YorumTarihi DESC" );
                  $YorumlarSorgusu->execute( [ DonusumleriGeriDondur( $UrunSorgusuKaydi[ "id" ] ) ] );
                  $YorumSayisi = $YorumlarSorgusu->rowCount();
                  $YorumKayitlari = $YorumlarSorgusu->fetchAll( PDO::FETCH_ASSOC );

                  if ( $YorumSayisi > 0 ) {
                    foreach ( $YorumKayitlari as $YorumSatirleri ) {
                      $YorumPuani = DonusumleriGeriDondur( $YorumSatirleri[ "Puan" ] );
                      if ( $YorumPuani == 1 ) {
                        $YorumPuanResmi = "YildizBirDolu.png";
                      } elseif ( $YorumPuani == 2 ) {
                        $YorumPuanResmi = "YildizIkiDolu.png";
                      } elseif ( $YorumPuani == 3 ) {
                        $YorumPuanResmi = "YildizUcDolu.png";
                      } elseif ( $YorumPuani == 4 ) {
                        $YorumPuanResmi = "YildizDortDolu.png";
                      } elseif ( $YorumPuani == 5 ) {
                        $YorumPuanResmi = "YildizBesDolu.png";
                      }

                      $YorumIcinUyeSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM uyeler WHERE id = ? LIMIT 1 " );
                      $YorumIcinUyeSorgusu->execute( [ DonusumleriGeriDondur( $YorumSatirleri[ "UyeId" ] ) ] );
                      $YorumIcinUyeKaydi = $YorumIcinUyeSorgusu->fetch( PDO::FETCH_ASSOC );
                      ?>
                <tr height="30">
                  <td width="64"><img src="Resimler/<?php echo $YorumPuanResmi;?>" border="0"></td>
                  <td width="10">&nbsp;</td>
                  <td width="451"><?php echo DonusumleriGeriDondur($YorumIcinUyeKaydi["IsimSoyism"])?></td>
                  <td width="10">&nbsp;</td>
                  <td width="150" align="right"><?php echo TarihBul(DonusumleriGeriDondur($YorumSatirleri["YorumTarihi"])); ?></td>
                </tr>
                <tr>
                  <td colspan="5" style="border-bottom:1px dashed #CCCCCC;"><?php echo DonusumleriGeriDondur($YorumSatirleri["YorumMetni"]); ?></td>
                </tr>
                <?php
                }
                } else {
                  ?>
                <tr height="30">
                  <td> Ürün İçin Henüz Yorum Eklenmemiş</td>
                </tr>
                <?php
                }
                ?>
              </table>
            </div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
} else {
  header( "Location:index.php" );
  exit();
}
} else {
  header( "Location:index.php" );
  exit();
}
?>
