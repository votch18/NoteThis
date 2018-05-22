<?php
if(Session::hasFlash()) {
    ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Oh Snap!</h4>

        <p>You don't have permission to view this note.</p>
        <hr>
        <p class="mb-0">Please contact the owner.</p>
    </div>

<?php
}
?>

<?php

if (count($this->data) > 0) {

    ?>
    <div class="card bordered" style="height: 100%;">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="notes">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"">
                            <span class="pr-2"><?=$this->data['notes'] == "" ? "New Note": substr(strip_tags($this->data['notes']), 0, 20)?></span>
                        </a>
                    </li>
            </ul>
        </div>
        <div class="card-body mh-100" >
            <div id='editor' contenteditable="true" placeholder="Start typing..."><?=$this->data['notes']?></div>



        </div>
    </div>

<?php

}else{

}