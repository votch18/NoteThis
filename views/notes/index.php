<div class="card" id="notes">
    <div class="card-header" id="notes">
		<div class="navhead">
			<ul class="nav justify-content-center" id="notes_header">
				<li class='mr-auto'>
					<a class='nav-link text-truncate' href='javascript:void(0);' id='prevTab2' >
						<i class='fa fa-chevron-left fa-lg'></i>
						</a>
				</li>
				
					
					<li style="padding: 10px; font-weight: bold;">
						NOTETHIS
					</li>
					<li class='ml-auto'>
						<a class='nav-link text-truncate' href='javascript:void(0);' id='nextTab2' >
							<i class='fa fa-chevron-right fa-lg'></i>
							</a>
					</li>
			</ul>
		</div>
        <ul class="nav nav-tabs card-header-tabs" id="tabs_con">

            <?php
				//tabs
            ?>

        </ul>
    </div>

    <div class="card-body">
        <input id="id" type="hidden" value=""/>

        <div id="mytoolbar" class="height:100px;"></div>
        <div id='editor' placeholder="Start typing..." style="border: none;">
        </div>

        <form enctype="multipart/form-data" id="form_file" style="width:0px; height:0px; overflow:hidden">
            <input id="file_name" name="file" type="file"/>
        </form>
        <input type="hidden" id="field_name" value=""/>

		 <a href="#" id="newTab2">
                <i class="fa fa-plus fa-lg"></i>
			</a>
								
        <footer>

            <ul class="nav justify-content-center">
                <li class="icon-menu mr-auto">
                    <a href="javascript:void(0);" role="button"  id="archiveNoteList">
                        <span data-toggle="tooltip" data-placement="top" title="Archive"><i
                                class="fa fa-archive fa-lg"></i></span></a>
                </li>
                <li class="icon-menu">
                    <a href="javascript:void(0);" role="button"  id="upload">
                        <span data-toggle="tooltip" data-placement="top" title="Upload Image"><i
                                class="fa fa-arrow-up fa-lg"></i></span></a>
                </li>
                <li class="icon-menu">
                    <a href="javascript:void(0);" role="button"  id="options">
                        <span data-toggle="tooltip" data-placement="top" title="Note Options"><i
                                class="fa fa-cog fa-lg"></i></span></a>
                </li>
                <li class="icon-menu">
                    <a href="javascript:void(0);" role="button"  id="notesList">
                        <span data-toggle="tooltip" data-placement="top" title="Note List"><i
                                class="fa fa-file fa-lg"></i></span></a>
                </li>
                <li class="icon-menu ml-auto">

                    <a href="javascript:void(0);" role="button"  onclick="javascript:logout();">
                        <span data-toggle="tooltip" data-placement="top" title="Log-out"><i
                                class="fa fa-sign-out fa-lg"></i></span></a>

                </li>

            </ul>

        </footer>

    </div>
</div>

<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 24px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #fcbb01;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #fcbb01;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(16px);
        -ms-transform: translateX(16px);
        transform: translateX(16px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 24px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>


<!-- Option Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="option" action="" method="GET" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div>
                            <span>Dark Theme: </span><span class="theme-value"><?=Session::get('theme') == "1" ? 'On' : 'Off'?></span>
                            <label class="switch" style="float: right">
                                <input type="checkbox" id="changetheme" <?=Session::get('theme') == "1" ? 'checked' : ''?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
						
						<small id="copied" class="form-text text-muted">&nbsp;</small>
                        <label for="inputLink"><i class="fa fa-link"></i> Share Note</label>
                        <input type="text" class="form-control" id="inputLink" aria-describedby="genLink" placeholder=""
                               readonly>
                        <small id="passText" class="form-text text-muted"></small>
                        <small id="genLink" class="form-text text-muted"><a href="javascript:void(0);">Create link to share this note.</a>
                        </small>
                    </div>
                    <hr/>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-1">
                                <input type="radio" name="mode" id="private" value="1" checked>
                            </div>
                            <div class="col-1">
                                <i class="fa fa-unlock-alt fa-2x text-muted ico"></i>
                            </div>
                            <div class="col">
                                <label class="form-text">Private</label>
                                <small class="text-muted">You choose who can view this note.</small>

                                <div class="form-group" id="passwordCon">

                                    <label for="exampleInputPassword1">Set Password</label>
                                    <input type="password" class="form-control" id="pass" placeholder="Password">
                                    <br/>
                                    <button type="button" class="btn btn-primary" id="savePass">Save Password</button>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-1">
                                <input type="radio" name="mode" id="public" value="2">
                            </div>
                            <div class="col-1">
                                <i class="fa fa-book fa-2x text-muted ico"></i>
                            </div>
                            <div class="col">
                                <label class="form-text">Public</label>
                                <small class="text-muted">Anybody can view this note.</small>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>


<!-- Notes Modal -->
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: scroll;">
                <table class="table table-light" id="notesTable">
                   
                </table>
            </div>

        </div>
    </div>

</div>


<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" enforceFocus="false">
    <div class="modal-dialog" role="document">
        <form id="uploadIMG" action="" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Insert Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div id="progressBar" class="progress-bar bg-warning" role="progressbar"
                             style="width: 0% height: 3px;" aria-valuenow="100" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                    <div id="message"></div>
                    <div id="image_preview">
                        <center><img id="previewing" class="mx-auto" src="/assets/img/img.svg"
                                     style="width: 100%; min-height: 150px; height: auto; max-height: 200px; background: #e9ecef;; "
                                     alt="Upload Image"/>
                    </div>
                    </center>
                    <hr/>
                    <div id="selectImage">
                        <label>Select Your Image</label><br/>
                        <input type="hidden" name="action" value="upload" id="action">
                        <input type="file" name="file" id="file" required class="form-control"/>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Insert Image"/>

                </div>
            </div>
        </form>
    </div>
</div>


<!-- Archive Notes Modal -->
<div class="modal fade" id="archivedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Archived Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: scroll;">
                <table class="table table-light" id="archiveTable">
                   

                </table>
            </div>

        </div>
    </div>

</div>


<!-- Message Box Modal -->
<div class="modal" tabindex="-1" role="dialog" id="msgModal" aria-labelledby="msgModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>What do you want to do with this note? Close, Delete or Archive?</p>
                <input type="hidden" id="actionid" value=""/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="actionclose"><i class="fa fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-danger" id="actiondelete"><i class="fa fa-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-secondary" id="actionarchive"><i class="fa fa-archive"></i> Archive
                </button>
            </div>
        </div>
    </div>
</div>