function confirmDelete(msg){
    if ( confirm(msg)){
        return true;
    }else {
        return false;
    }
}


$(document).ready(function(){

(function($) {

	//declare elements
    var editor = $("#editor");
	var id = $("#id");


	//add change event
    $('body').on('focus', '[contenteditable]', function() {
        var $this = $(this);
        $this.data('before', $this.html());
        return $this;
    }).on('blur keyup paste input', '[contenteditable]', function() {
        var $this = $(this);
        if ($this.data('before') !== $this.html()) {
            $this.data('before', $this.html());
            $this.trigger('change');
        }
        return $this;
    });



    editor.click(function(e){

        if ($(e.target).is('a')) {
            window.open(e.target);
        }

    });

    editor.on('change', function(e){

        var title = document.getElementById("t_" + id.val());
        $(title).text(editor.text() != "" ? editor.text().substring(0, 20) : "New note");
		save();

    });

    //new tab
    $('#new').on('click', function (e) {

        createNote();
    });




	/*nav-link*/
	$('.nav-link').on('click', function (e) {
        //alert($(this).attr('id'));
		$('.nav-link').attr('class', 'nav-link');
		$(this).attr('class', 'nav-link active')

		//change selected tab
		id.val($(this).attr('id'));

		//set editor value
		display();
    });


	/*	close button click
	*	if no notes found delete else close note
	*/
	$('.close').on('click', function (e) {
       //alert($(this).attr('id'));

		if (editor.html() == "" || editor.html() == null){

			deleteNote($(this).attr('id'));
		}else {
			closeNote($(this).attr('id'));
		}

    });


    /*
     * delete note
     */
    $('a.btn.btn-danger.delete').on('click', function (e) {

        if (confirmDelete("Delete this note?")){
            deleteNote($(this).attr('id').split("-")[1]);
            $('#notesModal').modal("toggle");
        }

    });


    /*
     * delete note
     */
    $('a.btn.btn-success.open').on('click', function (e) {

       setNoteOpen($(this).attr('id').split("-")[1]);

    });



    //save data to the database
	function save(){
		$.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				content: editor.html(),
				id: id.val(),
				action: "save"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					console.log("saved");

                } else {

                    console.log("error");
                }
            }
        });
	}


    //save data to the database
    function setNoteOpen(id){
        $.ajax({
            type:'GET',
            url: "/ajax/notes/",
            data:{
                id: id,
                action: "setNoteOpen"
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {

                    reload();
                    console.log("saved");

                } else {

                    console.log("error");
                }
            }
        });
    }

	//create new note
	function createNote(){
		$.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				action: "create"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {

					reload();

                } else {

                    console.log("error");
                }
            }
        });
	}

	//display notes when tab is click
	function display(){
		$.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				id: id.val(),
				action: "display"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					var datas = [];
                    datas = response;
					editor.html(datas['notes']);

                } else {

                    console.log("error");
                }
            }
        });
	}

	//delete note
	function deleteNote(note_id){
		$.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				id: note_id,
				action: "delete"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					console.log(response);
					if (response == true) {
                        reload();
					}else {

					}
                } else {
                    if ( confirm("Close window?")){
							//close window
							window.close();
						}
                }
            }
        });
	}

	//delete note
	function closeNote(note_id){
		$.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				id: note_id,
				action: "close"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {

					if (response == true) {
						reload();
					}else {
						createNote();
					}

                } else {

                    console.log("Error closing this note");
                }
            }
        });
	}

    function reload(){
        window.location = "/";
    }


})(jQuery);

//end of document ready

});