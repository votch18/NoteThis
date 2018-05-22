

<div class="container">

    <div class="card p-4 w-50 mx-auto" style="max-width: 350px;">
        <h3>Sign-up</h3>
        <hr/>
        <?php
        if (Session::hasFlash()) {
            ?>
            <div class="alert alert-danger" role="alert">
                Email is already taken!
            </div>
        <?php
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
           <br/>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>