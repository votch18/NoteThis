<?php
    if(Session::hasFlash()) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Oh Snap!</h4>

                <p>You don't have permission to view this note.</p>
                <hr>
                <p class="mb-0">Please contact the owner.</p>
            </div>
        </div>
    <?php
    }else {
        ?>
    <div class="container">
        <div class="card bordered" style="max-width: 350px; margin: 100px auto;">
            <div class="card-header">
                Password Protected!
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Enter Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                               placeholder="Password">
                    </div>
                    <hr/>
                    <button type="submit" class="btn btn-success "><i class="fas fa-unlock-alt"></i> Unlock</button>
                </form>

            </div>
        </div>
    </div>


    <?php
    }
?>