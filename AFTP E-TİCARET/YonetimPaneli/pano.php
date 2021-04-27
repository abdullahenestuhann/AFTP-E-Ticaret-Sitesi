<?php
if ( isset( $_SESSION[ "Yonetici" ] ) ) {
  ?>
<?php
} else {
  header( "Location:index.php?SKD=1" );
  exit();
}
?>
