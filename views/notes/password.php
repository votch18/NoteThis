<?php
if (Session::hasFlash()) {
    ?>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Oh Snap!</h4>

            <p>You don't have permission to view this note.</p>
            <hr>
            <p class="mb-0">Please contact the owner.</p>
        </div>
    </div>
<?php
} else {
    ?>
    <!-- Option Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="unlock" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Password Protected</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $this->data['id'] ?>"/>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Enter Password</label>
                            <input type="password" class="form-control" name="password" id="pass"
                                   placeholder="Password">
                            <br/>
                            <button type="button" class="btn btn-primary" id="unlockNotes"><i class="fa fa-unlock"></i>
                                Unlock
                            </button>

                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("#passwordModal").modal("toggle");

            $("#unlockNotes").on('click', function (e) {
                $("#unlock").submit();
            });

        });
    </script>


<?php
}
?>