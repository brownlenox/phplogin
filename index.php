<?php
    include "header.php";
    ?>


<?php
session_start();
if(!isset($_SESSION["user"])) {
    header("Loaction: login.php");
}
?>
<!-- <div class="container">
<label for="image">Image:</label>
<input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value="">
</div> -->


<?php
    include "footer.php";
    ?>

    