function confirmDelete(msg){
    if ( confirm(msg)){
        return true;
    }else {
        return false;
    }
}


(function($) {
        $('#fileInput').on('change', function (e) {

            $.each(e.originalEvent.srcElement.files, function(i, file) {


                var img = $("<img id='user_img'>");
                var reader = new FileReader();

                reader.onloadend = function () {
                    $(img).attr('src', reader.result);
                }
                reader.readAsDataURL(file);
                $("#preview").html("");
                $("#user_img").after(img);
                $("#preview").append(img);
            });
        });

    var editor = $("#editor");


    $('body').on('focus', '[contenteditable]', function() {
        var $this = $(this);
        $this.data('before', $this.html());
        return $this;
    }).on('blur keyup paste input', '[contenteditable]', function() {
        var $this = $(this);
        if ($this.data('before') !== $this.html()) {
            $this.data('before', $this.html());
            $this.trigger('change');
            //console.log('change');
        }
        return $this;
    });




    var div = document.getElementById('editor');
        setTimeout(function() {
        div.focus();
    }, 0);



    function convert()
    {
		var str = editor.text();

        var text=str.replace(/(<\/?(?:a|p|img)[^>]*>)|<[^>]+>/ig, '$1');
        var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		
		var arr;
		
		
        if (text.match(exp)){
           
			arr = text.split(" ");
			 console.log("match" + arr[0]);
        }
        var text1=text.replace(exp, "<a target='_blank' href='$1'>$1</a>");
        var exp2 =/(^|[^\/])(www\.[\S]+(\b|$))/gim;

        //var pos = editor.html(window.getSelection().anchorOffset);
        document.getElementById("editor").innerHTML=text1.replace(exp2, '$1<a target="_blank" href="http://$2">$2</a>');

        //setCaretPos(editor, pos);
    }
	
	 function detectlink(str)
    {

        var text=str.replace(/(<\/?(?:a|p|img)[^>]*>)|<[^>]+>/ig, '$1');
        var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		
		var arr;
		
		
        var text1=text.replace(exp, "<a target='_blank' href='$1'>$1</a>");
        var exp2 =/(^|[^\/])(www\.[\S]+(\b|$))/gim;

		
		//detect match and validate if valid url
        if (text.match(exp) || text.match(exp2)){
           
			arr = text.split(" ");
			
			for(var x = 0; x < arr.length; x++){
				if (arr[x].match(exp) || arr[x].match(exp2)){
					if(arr[x] != arr[arr.length-1]){
						setTimeout(convert(), 1000);
						console.log("match: " + arr[x]);
					}
					
				}
			}
			
			 
        }
		
        //var pos = editor.html(window.getSelection().anchorOffset);
        //document.getElementById("editor").innerHTML=text1.replace(exp2, '$1<a target="_blank" href="http://$2">$2</a>');

        //setCaretPos(editor, pos);
    }
	
	
	setTimeout(convert(), 500);

    editor.click(function(e){

        //open links in content editable to new document
		//console.log($(e.target).text());
        if ($(e.target).is('a')) {
            window.open(e.target);
        }

    });

    editor.on('change', function(e){

        //$('#editor').linkify();
        //convert(editor.html());
        detectlink(editor.text());

    });

    //new tab
    $('#new').on('click', function (e) {
        convert($('#editor').html());

        var tab = $("<li class='nav-item'><a class='nav-link' href='#'><span class='pr-4' id='note-title'>New note</span><button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></a></li>");
        $('#new').insertBefore("#one");
        $("#notes").append(tab);
    });


	/*

    function getCaretCharacterOffsetWithin(element) {
        var caretOffset = 0;
        var doc = element.ownerDocument || element.document;
        var win = doc.defaultView || doc.parentWindow;
        var sel;
        if (typeof win.getSelection != "undefined") {
            sel = win.getSelection();
            if (sel.rangeCount > 0) {
                var range = win.getSelection().getRangeAt(0);
                var preCaretRange = range.cloneRange();
                preCaretRange.selectNodeContents(element);
                preCaretRange.setEnd(range.endContainer, range.endOffset);
                caretOffset = preCaretRange.toString().length;
            }
        } else if ( (sel = doc.selection) && sel.type != "Control") {
            var textRange = sel.createRange();
            var preCaretTextRange = doc.body.createTextRange();
            preCaretTextRange.moveToElementText(element);
            preCaretTextRange.setEndPoint("EndToEnd", textRange);
            caretOffset = preCaretTextRange.text.length;
        }
        return caretOffset;
    }

    function showCaretPos() {
        var el = document.getElementById("editor");

        //console.log("Caret position: " + getCaretCharacterOffsetWithin(el)) ;
    }

    function setCaretPos(element, pos){
        var el = element;
        var range = document.createRange();
        var sel = window.getSelection();
        range.setStart(el.childNodes[0], pos);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
    }

    document.body.onkeyup = showCaretPos;
    document.body.onmouseup = showCaretPos;

	*/

})(jQuery);


