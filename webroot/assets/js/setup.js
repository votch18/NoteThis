$(document).ready(function(){
	
	//{ #region tinyMCE
	/**
	* Init tinyMCE
	*/
	tinymce.init({
				
		selector: '#editor',
		
		branding: false,
		
		menubar: false,
		
		statusbar: false,
		
		body_class: 'my_class',
		
		auto_focus: 'editor',
		
		fixed_toolbar_container: '#mytoolbar',

		content_css : theme + new Date().getTime(),

		force_br_newlines : true,
		
		force_p_newlines : false,
		  
		forced_root_block : '',
		
		toolbar: false,
		
		plugins: [
		'advlist autolink lists link image charmap print preview anchor textcolor imagetools',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table paste autoresize'
		],
		
		autoresize_bottom_margin: 50,

		autoresize_min_height: 320,
		
		default_link_target:"_blank",
		
		
		init_instance_callback: function (editor) {
			
			/**Open link in new window */
			/*
			editor.on('click', function (e) {
				if(e.target.nodeName == "A"){
					// open the origin link by a new created "a" element
					var aEle = document.createElement('a');
					aEle.href = e.target.href;
					aEle.target = '_blank';	// should open a new window
					// fire a new mouse click event
					var evt = document.createEvent("MouseEvents");
					evt.initEvent("click",true,true);
					aEle.dispatchEvent(evt);
				
				}
			});
			*/
			
			editor.on('change keyup paste input keypress', function(e){
				var _id = id.val();
				var title = $("#t_" + id.val());
				var _content = tinyMCE.activeEditor.getContent();
				
				if (tinyMCE.activeEditor.getContent() != "") {
					var html = $.parseHTML( tinyMCE.activeEditor.getContent() );
					var nodeNames = [];
				 
					/**
					* Append the parsed HTML
					* Gather the parsed HTML's node names
					* Add title to tab base on editor's first element
					*/
					$.each( html, function( i, el ) {
					
						if (i == 0){
							
							if( el.nodeType == 1 && $(el).children().length > 0) {
								
								if (el.nodeName.toLowerCase() == "p") {
									$(el).children("p").each(function( index ) {
										if (index == 0){
											$(title).text($( this ).text());
										}
									});
								}else if (el.nodeName.toLowerCase() == "div"){
									$(el).children("div").each(function( index ) {
										$(title).text($( this ).text());
									});
									
								}else if (el.nodeName.toLowerCase() == "img"){
									$(el).children("img").each(function( index ) {
										//TODO: add title using image attributes
										//$(title).text($( this ).text());
									});
								}
							}else {
								$(title).text($( el ).text());
							}
						}
					});
				}
				/**save the document */
				save(_id, $(title).text(), _content );
				
			});
		},
		elementpath: false
	});
	
	/**Prevent bootstrap dialog from blocking tinyMCE's focusin */
	$(document).on('focusin', function(e) {
		if ($(e.target).closest(".mce-window").length) {
			e.stopImmediatePropagation();
		}
	});

	/**Prevent bootstrap dialog from blocking tinyMCE's focusin */
	$(document).on('focusin', function(e) {
		if ($(e.target).closest(".mce-last").length) {
			e.stopImmediatePropagation();
		}
	});	
	
	//} #endregion tinyMCE

	//{ #region Variables
	/**Initiate variables */
	var id = $("#id");
	var editor = $("#editor");
	var header = $('nav.nav-tabs.card-header-tabs');
	var tabs = $('.nav-item'); 
	var con = $('#tabs_con');
	var notesTable = $('#notesTable');
	var archiveTable = $('#archiveTable');
	var actionid = $('#actionid');
	var activeIndex = 0;
	var pages = 0;
	var current = 0;
	var wrap = header;
	var el = $("ul").width();
	var activeNote = "";
	var loader = $('.loader');
	
	/**Initialize newtab and overflow button */
	var newTab = "<li>" +
						"<a class='nav-link text-truncate' href='javascript:void(0);' id='new'><i class='fa fa-plus fa-lg'></i>" +
						"</a>" +
					"</li>";
	
	
	var nextTab = "<li class='ml-auto'>" +
						"<a class='nav-link text-truncate' href='javascript:void(0);' id='nextTab' >" +
							"<i class='fa fa-chevron-right fa-lg'></i>" +
							"</a>" +
					"</li>";
					
	var prevTab = "<li class=''>" +
					"<a class='nav-link text-truncate' href='javascript:void(0);' id='prevTab' >" +
						"<i class='fa fa-chevron-left fa-lg'></i>" +
						"</a>" +
				"</li>";

				
	/**mobile mode*/
	
	var notesHeader = $('#notes_header');
	
	var nextTab2 = $('#nextTab2');
					
	var prevTab2 = $('#prevTab2');
					
	var newTab2 = $('#newTab2');
	
	//} #endregion Variables

	//{ #region Events
	/**Handle tab click event and display notes based on active tab. */
	$('body').on('click', '.tabs', function(e) {
		e.preventDefault();
		$('.tabs').attr('class', 'tabs nav-link text-truncate');
		$(this).attr('class', 'tabs nav-link text-truncate active')

		/**Change input for id */
		id.val($(this).attr('id'));
		
		showLoader();
		tinyMCE.activeEditor.setContent('');
		display().done(function(value) {
			hideLoader();
			tinyMCE.activeEditor.setContent(value.content);			
		});
		hideLoader();
	});

	/**	close button click,if no notes found or empty delete else close note */
	$('body').on('click', '.close.d-inline', function() {
		actionid.val($(this).attr('id').split("-")[1]);
		$('#msgModal').modal("toggle");
    });
	
	$('body').on('click', '#actionclose', function() {
		showLoader();
		closeNote(actionid.val()).done(function(value) {
			hideLoader();
			actionid.val("");
			navigate();
			$('#msgModal').modal("toggle");
		});
    });
	
	$('body').on('click', '#actionarchive', function() {
		showLoader();
		archiveNote(actionid.val()).done(function(value) {
			hideLoader();
			actionid.val("");
			navigate();
			$('#msgModal').modal("toggle");
		});
    });
	
	$('body').on('click', '#actiondelete', function() {
		showLoader();
		deleteNote(actionid.val()).done(function(value) {
			hideLoader();
			actionid.val("");
			navigate();
			$('#msgModal').modal("toggle");
		});
    });

	/**Delete note */
	$('body').on('click', 'a.btn.btn-danger.delete', function(e) {
		swal( {
			text: "Delete this note?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((confirm) => {
			if (confirm){
				deleteNote($(this).attr('id').split("-")[1]).done(function(value) {
					reloadNotes();
					navigate();
				});
			}
		});

    });

    /**Open note */
	$('body').on('click', 'a.btn.btn-primary.open', function(e) {
		var $id = $(this).attr('id').split("-")[1];
		showLoader();
		setNoteOpen($id).done(function(value) {
			
			getOpenNotes().done(function(value) {
			
				var windowWith = $(window).width();		
				var nums = 0;
				
				if (windowWith <= 321)  {
					nums = 2;
				}else if (windowWith >= 321 && windowWith <= 575) {
					nums = 3;
				}else {
					nums = (windowWith - 144) / 120;
				}
				nums = Math.floor(nums);
				
				var index = value.findIndex((item) => item.note_id === $id);
				//alert(index);
				activeIndex = index;
				activeNote = $id;
				index = index + 1;
				index = index != 0 ? (index / nums) : index;
				
				index = index % 1 != 0 ? (Math.floor(index) + 1) : (index == 0) ? 1 : index;
				//alert(activeNote+ ' - '+ nums + ' - ' +index + ' - ' +activeIndex);
				current = index;
				
				navigate();
				hideLoader();
			});	
			
			if ( ($("#notesModal").data('bs.modal') || {})._isShown == true){
				$("#notesModal").modal("toggle");
			}else {
				$("#archivedModal").modal("toggle");
			}
		});
	   
		
    });	
	
	/**Add note to archive */
	$('body').on('click', 'a.btn.btn-secondary.archived', function(e) {
		swal( {
			text: "Archive this note?",
			icon: "info",
			buttons: true,
			dangerMode: true,
		})
			.then((confirm) => {
				if (confirm){
					archiveNote($(this).attr('id').split("-")[1]).done(function(value) {
						reloadNotes();
						navigate();
					});
				}
			});

    });	
	
	
	/** Create new tab */
	$('body').on('click', '#new, #newTab2', function() {
		showLoader();
		createNote().done(function(value) {
			current = 0;
			navigate();	
			hideLoader();
		});
		
		tinyMCE.activeEditor.focus();
    });	
	
	/** next tab */
	$('body').on('click', '#nextTab, #nextTab2', function() {
		current = current + 1;
		current = current > pages ? pages : current;
		navigate();
    });	
	
	/** previous tab */
	$('body').on('click', '#prevTab, #prevTab2', function() {
		current = current - 1;
		current = current > pages ? pages : current;
		navigate();
    });	
	
	
	/**Add note to archive */
    $('#options').on('click', function (e) {
		
		getData().done(function($data) {
			displayLink($data);
		});
        $('#optionModal').modal("toggle");
       
    });
	
	/**Add note to archive */
    $('#notesList').on('click', function (e) {
		
		reloadNotes();
        $('#notesModal').modal("toggle");
       
    });
	
	
	/**Add note to archive */
    $('#archiveNoteList').on('click', function (e) {
		reloadArchiveNotes();
        $('#archivedModal').modal("toggle");
       
    });
	
	
	/**Upload Images */
    $('#upload').on('click', function (e) {
		$('#previewing').attr('src','/assets/img/img.svg');
        $('#uploadModal').modal("toggle");
       
    });
	
	
	//} #endregion Events
	
	function navigate(){
		getOpenNotes().done(function(value) {
		
			var windowWith = $(window).width();		
			var nums = 0;
			
			if (windowWith <= 400)  {
				nums = 2;
			}else if (windowWith >= 400 && windowWith <= 575) {
				nums = 3;
			}else {
				nums = (windowWith - 144) / 160;
			}
			
			nums = Math.floor(nums);
		
			/**Get pages */
			pages 	=  	(value.length) / nums;
			//console.log(pages);
			pages 	= 	pages % 1 != 0 ? (pages + 1) : pages;
			pages = Math.floor(pages);
			
			current = current > pages ? pages : current;
			current = current == 0 ? ((pages > 1) ? pages : 1) : current;
			
			var start = (nums * (current - 1));
			var end = (nums * (current - 1)) + nums
			
			var $arrTab = value.slice(start, end);
			var next = (current != pages) ? 1 : 0;
			var prev = (current > 1) ? 1 : 0;
			
			//console.log(value.length + " " + pages + " " + current);
			
			loadTabs($arrTab, prev, next, nums); 
			
			showLoader();
			tinyMCE.activeEditor.setContent('');
			display().done(function(value) {
				hideLoader();
				tinyMCE.activeEditor.setContent(value.content);				
			});
		});	
	}
	
	//{ #region AJAX 
	/**Beginning of AJAX Functions */
	/**create new note */
	function createNote(){
		return $.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				action: "create"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					console.log("Notes created!");		
                } else {
                    console.log("Error creating notes!");
                }
            }
        });
	}	

	/**Save data to the database */
	function save(_id, _title, _content){
		/**Don't save if editor is empty. */
		if (_content != "") {
			$.ajax({
				type:'GET',
				url: "/ajax/notes/",
				data:{
					title: _title,
					content: _content,
					id: _id,
					action: "save",
					time: uniqueId()
				},
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function (response) {
					//console.log(response);
					if (response) {
						/**Saved! */
					} else {
						console.log("An error occured while saving the document!");
					}
				},
				error: function (x, status, error) {
					if (x.status == 403) {
						//alert("Sorry, your session has expired. Please login again to continue");
					}
					else {
						//alert("An error occurred: " + status + "nError: " + error);
					}
				}
			});
		}
		
	}
	
	/** display notes when tab is click */
	function display(){
		return $.ajax({
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
					
				} else {
					/**An error occured then empty the tinyMCE Editor */
					tinyMCE.activeEditor.setContent('');
					console.log("Empty Note!");
				}
			},
			error: function (x, status, error) {
				tinyMCE.activeEditor.setContent('An error occured while retrieving your information!');
			}
		});
	
	}
	
	
    /**set note is_open to 1 (1=>Open, 2=>Close) */
    function setNoteOpen(id){
        return $.ajax({
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
					/**TODO: don't reload instead add to tabs without reloading */
                    //reload();
                } else {
                    console.log("An error occured while opening this note!");
                }
            }
        });
    }

	/**Delete note */
	function deleteNote(note_id){
		return $.ajax({
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
					//console.log(response);
					if (response == true) {
						/**TODO: Remove tabs without reloading */
                        //reload();
					}
                } else {
                    //alert("Cannot delete this note. It is recommended that you have at least one active note!");
					swal( {
						text: "Cannot delete this note. It is recommended that you have at least one active note!",
						icon: "info"
					})
                }
            }
        });
	}

	/**Close note (Set database status to close) */
	function closeNote(note_id){
		return $.ajax({
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
					
					}else {
						createNote();
					}

                } else {
					creatNote();
                }
            }
        });
	}

	/**Add note to archives */
	function archiveNote(note_id){
		return $.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				id: note_id,
				action: "archive"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					if (response == true) {
						//reload();
					}else {
						createNote();
					}

                } else {
					creatNote();
                }
            }
        });
	}
	
	
	/**Get open notes */
	function getOpenNotes(){
		return $.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				action: "getOpenNotes"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {
					if (response == true) {
                       //action here
					}
                } else {
					console.log("An error occured while retrieving open notes!");
                }
            }
        });
	}
	
	/**Get all notes */
	function getArchiveNotes(){
		return $.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				action: "getArchiveNotes"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
								
                if (response) {	
					if (response == true) {
                       
						
					}
                } else {
					console.log("An error occured while retrieving archive notes!");
                }
            }
        });
	}
	
	/**Get all notes */
	function getAllNotes(){
		return $.ajax({
			type:'GET',
            url: "/ajax/notes/",
			data:{
				action: "getAllNotes"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if (response) {					
					if (response == true) {
                       //action here
					}
                } else {
					console.log("An error occured while retrieving your notes!");
                }
            }
        });
	}
	
	//} #endregion AJAX
		
	//{ #region Tabs
	/**Reload note list*/
	function reloadNotes(){
		getAllNotes().done(function($data) {
			notesTable.html("");
			$.each($data, function(i){
				
				var openBut = $data[i].is_open != 2 ? "" : "<a href='javascript:void(0);' id='open-" + $data[i].note_id + "'  class='btn btn-primary open btn-sm'><span data-toggle='tooltip' data-placement='top' title='Open' ><i class='fa fa-link'></i></span></a>";
				var $title = !$data[i].title ? "Empty note" : $data[i].title;
				
				var tableRow = "<tr class='row-hover'>" +
									"<td>" +
										$title + 
									"</td>" +
									"<td style='width: 160px; text-align: right;'>" +
										openBut +
										"<a href='javascript:void(0);' id='delete-" + $data[i].note_id + "' class='btn btn-danger delete btn-sm' style='width: 30px;'>" +
											"<span data-toggle='tooltip' data-placement='top' title='Delete' ><i class='fa fa-trash'></i></span>" +
										"</a>" +
										"<a href='javascript:void(0);' id='archived-" + $data[i].note_id + "' class='btn btn-secondary archived btn-sm' style='width: 30px;'>" +
											"<span data-toggle='tooltip' data-placement='top' title='Archive' ><i class='fa fa-archive'></i></span>" +
										"</a>" +
									"</td>" +
								"</tr>";
								
				notesTable.append(tableRow);
			
			});	
			
			if($data.length < 1){
				var tableRow = "<tr>" +
									"<td colspan='2'>" +
										"No notes found!"
									"</td>" +
								"</tr>";
								
				notesTable.append(tableRow);
			}
		});
	}
	
	
	/**Reload archive note list*/
	function reloadArchiveNotes(){
		getArchiveNotes().done(function($data) {
			archiveTable.html("");
			$.each($data, function(i){
				
				var openBut = $data[i].is_open != 2 ? "" : "<a href='javascript:void(0);' id='open-" + $data[i].note_id + "'  class='btn btn-primary open btn-sm'><span data-toggle='tooltip' data-placement='top' title='Open' ><i class='fa fa-link'></i></span></a>";
				var $title = !$data[i].title ? "Empty note" : $data[i].title;
				var tableRow = "<tr class='row-hover'>" +
									"<td>" +
										$title + 
									"</td>" +
									"<td style='width: 160px; text-align: right;'>" +
										"<a href='javascript:void(0);' id='delete-" + $data[i].note_id + "' class='btn btn-danger delete btn-sm' style='width: 30px;'>" +
											"<span data-toggle='tooltip' data-placement='top' title='Delete' ><i class='fa fa-trash'></i></span>" +
										"</a>" +
										"<a href='javascript:void(0);' id='open-" + $data[i].note_id + "' class='btn btn-primary open btn-sm' style='width: 30px;'>" +
											"<span data-toggle='tooltip' data-placement='top' title='Restore' ><i class='fa fa-reply'></i></span>" +
										"</a>" +
									"</td>" +
								"</tr>";
								
				archiveTable.append(tableRow);
			
			});	
			
			if($data.length < 1){
				var tableRow = "<tr>" +
									"<td colspan='2'>" +
										"No archived notes found!"
									"</td>" +
								"</tr>";
								
				archiveTable.append(tableRow);
			}
		});
	}
	
	

	/**If window is resize reload the page to setup tabs */
	var resizeTimer;
	

	
	
	$(window).resize(function() {
		
		if(window.location.pathname == "/notes/"){
			navigate();
			//clearTimeout(resizeTimer);
			//resizeTimer = setTimeout(reload(), 100);
		}
	});
	
	
	
	
	
	/**Set up tabs */
	function loadTabs($data, $prev, $next, nums){
		var $class = "";
		var $notes = "";
		var $id = "";
		var $title = "";
		

		$('ul.nav-tabs').html("");
		
		if ( $prev > 0) {
			
			con.append(prevTab);
			prevTab2.css("display", "block");
		}else {
			prevTab2.css("display", "none");
		}
	
		$.each($data, function(i){
			var $x = nums <= ($data.length - 1) ? (nums -1 ) : ($data.length - 1) ;
			if ( i < nums){
				if ( activeNote != ""){
					
					if (activeNote === $data[i].note_id){
						$class = "active";
						//console.log($data[i].note_id);
					}else {
						$class = "";
					}
					
				}else{
					$class = $x == i ? "active" : "";
				}
				
				
								
				$notes =  $x == i ? $data[i].notes : "";
				
				$id =  $data[i].note_id;
				
				$title = !$data[i].title ? "New note" : $data[i].title;
				
				
				var tab = 	"<li class='nav-item  d-inline'>" + 
								"<a class='tabs nav-link text-truncate " + $class + "' href='#' id='" + $data[i].note_id + "'>" +
									"<button class='close d-inline' id='x-" + $data[i].note_id + "'>" +
										"<span aria-hidden='true'>&times;</span>" + 
									"</button><span id='t_" +  $data[i].note_id + "'>"  + $title + "</span>" +
								"</a>" +
							"</li>";
				
				id.val($id);	
				
				con.append(tab);
				
				
			}
		
		});	
		
		editor.html($notes);
		/**Append new tab button to the end of tabs */
		con.append(newTab);
		
		/**Append overflow button after new tab button if tabs will not fit in the screen */
		if ( $next > 0) {
			
			con.append(nextTab);
			nextTab2.css("display", "block");
		}else {
			nextTab2.css("display", "none");
		}
		
		activeNote = "";
		
	}
	
	
	
	

	/**Move array index to new index */
	function array_move(arr, old_index, new_index) {
		while (old_index < 0) {
			old_index += arr.length;
		}
		while (new_index < 0) {
			new_index += arr.length;
		}
		if (new_index >= arr.length) {
			var k = new_index - arr.length + 1;
			while (k--) {
				arr.push(undefined);
			}
		}
		arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
		return arr; 	// for testing purposes
	}
	//} #endregion Tabs

	//{ #region Upload Image
	
	/**Upload image form */
	$( '#uploadIMG' )
		.submit( function( e ) {
			
			$.ajax( {
					xhr: function() {
				var xhr = new window.XMLHttpRequest();

				xhr.upload.addEventListener("progress", function(evt) {
				  if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					percentComplete = parseInt(percentComplete * 100);
				
						$('#progressBar').css('width', percentComplete + '%');
					if (percentComplete === 100) {
						$('#progressBar').css('width', '0%');
						$(function () {
						   $('#uploadModal').modal('toggle');
						});
					}

				  }
				}, false);

				return xhr;
				},
				url: '/ajax/notes/uploads/',
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				success: function (response) {
					if (response) {
						
						tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="' + '/assets/img/' + getFileName() + '">'); 

					} else {

						console.log("Error adding image to this note!");
					}
				}
			} );
			e.preventDefault();
		} );

	
	/**Input file change then preview image */
	$("#file").change(function() {
		$("#message").empty(); 		// To remove the previous error message
		
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
			$('#previewing').attr('src','noimage.png');
			$("#message").html("<p id='error' class='alert alert-danger'>Please Select A valid Image File</p><span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
	});
	
	function imageIsLoaded(e) {
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	}

	function getFileName(){
		var fullPath = document.getElementById('file').value;
		if (fullPath) {
			var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
			var filename = fullPath.substring(startIndex);
			if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
				filename = filename.substring(1);
			}
			return filename;
		}
	}
	
	//}#endregion Upload Image

	
	
	/**Option*/
	//{#region Option 
		
	var pub = $("#public");
	var priv = $("#private");
	var pass = $("#pass");
	var savePass = $("#savePass");
	var passwordCon =  $("#passwordCon");
	var genLink = $("#genLink");
	var inputLink = $("#inputLink");
	var passText = $("#passText");
	var optionBut = $("#optionBut");


	pub.click(function(e){
		passwordCon.attr('style', 'display: none;');
		setMode(2);
		generateLink();
		passText.html("");
		pass.val("");
		setPass();
		setLink();

	});
	
	inputLink.click(function(e){
		var copyText =$(this);
		copyText.disabled = false;

		/* Select the text field */
		copyText.select();

		/* Copy the text inside the text field */
		document.execCommand("copy");
		
		$('#copied').html("Copied...");
		setTimeout(function(){
			$('#copied').html("&nbsp;");
		}, 2000);
		/* Alert the copied text */
		//alert("Copied the text: " + copyText.val());
		copyText.disabled = true;
	});

	priv.click(function(e){
		if (pass.val() == ""){
			swal( {
				text: "To share this note, you must either make it public, or password protect it.",
				icon: "info"
			})
			.then((confirm) => {
				if (confirm){
					passwordCon.attr('style', 'display: block;');
					inputLink.val("");
					setLink();
				}
			});
			//alert("");

		}
		setMode(1);
	});

	genLink.click(function(e){
		
		getData().done(function($data) {
			if($data.mode == 2){
				
			}else {
				//alert("To share this note, you must either make it public, or password protect it.");
				swal( {
					text: "To share this note, you must either make it public, or password protect it.",
					icon: "info"
				})
			}
		});
	});

	savePass.click(function(e){

		setPass();
		generateLink();
		setLink();
		
		getData().done(function($data) {
			displayLink($data);
		});

	});

	optionBut.click(function(e){

		getData();

	});
	
	function generateLink(){
		var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "view/" + id.val();
		inputLink.val(url);
	}
	
	function displayLink($datas){
		
		var datas = [];
		datas = $datas;

		inputLink.val(datas.url);

		if(datas.mode == "1"){
			priv.prop('checked', true);
			passwordCon.attr('style', 'display: block;');
			pass.val(datas.password);
			passText.html("Password: " + datas.password);
			
		}else if (datas.mode == "2") {
			pub.prop('checked', true);
			passwordCon.attr('style', 'display: none;');
		}
					
	}

	function setMode(mode){
		$.ajax({
			type:'GET',
			url: "/ajax/notes/",
			data:{
				id: id.val(),
				mode: mode,
				action: "setMode"
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



	function setLink(){
		$.ajax({
			type:'GET',
			url: "/ajax/notes/",
			data:{
				id: id.val(),
				link: inputLink.val(),
				action: "setLink"
			},
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (response) {
				if (response) {

				} else {

					console.log("An error occured while adding link to this note!");
				}
			}
		});
	}


	function setPass(){
		$.ajax({
			type:'GET',
			url: "/ajax/notes/",
			data:{
				id: id.val(),
				password: pass.val(),
				action: "setPass"
			},
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (response) {
				if (response) {

				} else {

					console.log("An error occured while adding password to this note");
				}
			}
		});
	}


	function getData(){
		return $.ajax({
			type:'GET',
			url: "/ajax/notes/",
			data:{
				id: id.val(),
				action: "getData"
			},
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (response) {
				if (response) {
					
				} else {
					console.log("An error occured while retrieving data of this note!");
				}
			}
		});
	}

	getData().done(function($data) {
		displayLink($data);
	});
		
	
	function uniqueId () {
		// desired length of Id
		var idStrLen = 32;
		// always start with a letter -- base 36 makes for a nice shortcut
		var idStr = (Math.floor((Math.random() * 25)) + 10).toString(36) + "_";
		// add a timestamp in milliseconds (base 36 again) as the base
		idStr += (new Date()).getTime().toString(36) + "_";
		// similar to above, complete the Id using random, alphanumeric characters
		do {
			idStr += (Math.floor((Math.random() * 35))).toString(36);
		} while (idStr.length < idStrLen);

		return (idStr);
	}
	
	
	//} #endregion Options
	
	/**Reload page */
    function reload(){
        window.location = "/notes/";
    }

	function isTouchDevice(){
        return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
    }
	
    if(isTouchDevice()===false) {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    }


   
	/**load tabs*/
	navigate();

	/**Add confirmation message */
	function confirmDelete(msg){
		if ( confirm(msg)){
			return true;
		}else {
			return false;
		}
		
	}
	
	function showLoader(){
        $('.loader_con').css("background", "#efefef!important");
		loader.css("display", "block");
	}

    function hideLoader(){
        $('body').css("background", "#fcbb01!important");
		loader.css("display", "none");
	}

	jQuery(window).load(function () {
		
		hideLoader();
		$('#content').css("display", "block");
		

	});
	
	hideLoader();
	//end of document ready

	$('#changetheme').change(function(e){
		if ($(this).prop('checked') == true){
			changeTheme(1);
			$('.theme-value').text('On');
		}else{
			changeTheme(0);
			$('.theme-value').text('Off');
		}
	})


	function changeTheme(value){
		$.ajax({
			type:'GET',
			url: "/ajax/accounts/",
			data:{
				value: value,
			},
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (response) {
				if (response) {
					swal( {
						text: "Theme successfully changed!. Your page will reload.",
						icon: "success",
						closeOnClickOutside: false,
					})
					.then((confirm) => {
						if (confirm){
							window.location.reload();
						}
					});
				} else {

					console.log("An error occured while adding password to this note");
				}
			}
		});
	}
});