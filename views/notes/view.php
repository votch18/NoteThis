<?php

if (count($this->data) > 0) {
    $notes = Util::encrypt_decrypt("decrypt", $this->data['notes']);
    $notes = stripcslashes($notes);
    //TODO:get title and remove title from body
    $title = Util::encrypt_decrypt("decrypt", $this->data['title']);
    $title = stripcslashes($title);

    /*
    $document = new DOMDocument();
      // Ensure UTF-8 is respected by using 'mb_convert_encoding'
      $document->loadHTML(mb_convert_encoding($notes , 'HTML-ENTITIES', 'UTF-8'));
        $x = $document->documentElement;

        var_dump$x->first_child);

        foreach ($x->childNodes AS $item) {
          print $item->first_child . " = " . $item->nodeValue . "<br>";
        }
  //return $document->saveHTML();
  */

    ?>

    <script>
        document.title = "<?=$title?> | NoteThis";
    </script>


    <div class="container view p-3 mt-md-3 mb-md-3" style="background: url(/assets/img/bg.jpg);">
		<h1><?= $title ?></h1>
		<br/>

		<div><?= str_replace("../", "/", $notes) ?></div>
    </div>

<?php

} else {
    ?>


    <?php
    if (Session::hasFlash()) {
        ?>
        <div class="container pt-5" style="max-width: 968px;">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Oh Snap!</h4>

                <p>You don't have permission to view this note.</p>
                <hr>
                <p class="mb-0">Please contact the owner.</p>
            </div>
        </div>
    <?php
    }
}
?>




 