<?php
if ( isset( $_SESSION[ "Yonetici" ] ) ) {
  ?>
dashbord  / pano sayfası
<?php
} else {
  header( "Location:index.php?SKD=1" );
  exit();
}
?>
