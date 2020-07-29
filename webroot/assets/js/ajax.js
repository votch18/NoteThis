if (window.getSelection && document.createRange) {
    saveSelection = function (containerEl) {
        var range = window.getSelection().getRangeAt(0);
        var preSelectionRange = range.cloneRange();
        preSelectionRange.selectNodeContents(containerEl);
        preSelectionRange.setEnd(range.startContainer, range.startOffset);
        var start = preSelectionRange.toString().length;

        return {
            start: start,
            end: start + range.toString().length
        }
    };

    restoreSelection = function (containerEl, savedSel) {
        var charIndex = 0, range = document.createRange();
        range.setStart(containerEl, 0);
        range.collapse(true);
        var nodeStack = [containerEl], node, foundStart = false, stop = false;

        while (!stop && (node = nodeStack.pop())) {
            if (node.nodeType == 3) {
                var nextCharIndex = charIndex + node.length;
                if (!foundStart && savedSel.start >= charIndex && savedSel.start <= nextCharIndex) {
                    range.setStart(node, savedSel.start - charIndex);
                    foundStart = true;
                }
                if (foundStart && savedSel.end >= charIndex && savedSel.end <= nextCharIndex) {
                    range.setEnd(node, savedSel.end - charIndex);
                    stop = true;
                }
                charIndex = nextCharIndex;
            } else {
                var i = node.childNodes.length;
                while (i--) {
                    nodeStack.push(node.childNodes[i]);
                }
            }
        }

        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
} else if (document.selection) {
    saveSelection = function (containerEl) {
        var selectedTextRange = document.selection.createRange();
        var preSelectionTextRange = document.body.createTextRange();
        preSelectionTextRange.moveToElementText(containerEl);
        preSelectionTextRange.setEndPoint("EndToStart", selectedTextRange);
        var start = preSelectionTextRange.text.length;

        console.log(start + " : " + selectedTextRange.text.length);
        return {
            start: start,
            end: start + selectedTextRange.text.length
        }


    };

    restoreSelection = function (containerEl, savedSel) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(containerEl);
        textRange.collapse(true);
        textRange.moveEnd("character", savedSel.end);
        textRange.moveStart("character", savedSel.start);
        textRange.select();
    };
}

function createLink(matchedTextNode) {
    var el = document.createElement("a");
    var url = matchedTextNode.data;
    var href = "";

    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;

    var exp2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;


    if (url.match(exp)) {
        href = $.trim(url);

    } else if (url.match(exp2)) {
        href = "http://" + $.trim(url);
    }
    el.target = "_blank";
    el.href = href;
    el.appendChild(matchedTextNode);
    return el;
}

function createImage(filename) {
    var el = document.createElement("img");

    el.src = "/assets/img/" + filename;
    return el;
}

function shouldLinkifyContents(el) {
    return el.tagName != "A";
}

function surroundInElement(el, regex, surrounderCreateFunc, shouldSurroundFunc) {
    var child = el.lastChild;
    while (child) {
        if (child.nodeType == 1 && shouldSurroundFunc(el)) {
            surroundInElement(child, regex, createLink, shouldSurroundFunc);
        } else if (child.nodeType == 3) {
            surroundMatchingText(child, regex, surrounderCreateFunc);
        }
        child = child.previousSibling;
    }
}

function surroundMatchingText(textNode, regex, surrounderCreateFunc) {
    var parent = textNode.parentNode;
    var result, surroundingNode, matchedTextNode, matchLength, matchedText;
    while (textNode && (result = regex.exec(textNode.data))) {
        matchedTextNode = textNode.splitText(result.index);
        matchedText = result[0];
        matchLength = matchedText.length;
        textNode = (matchedTextNode.length > matchLength) ?
            matchedTextNode.splitText(matchLength) : null;
        surroundingNode = surrounderCreateFunc(matchedTextNode.cloneNode(true));
        parent.insertBefore(surroundingNode, matchedTextNode);
        parent.removeChild(matchedTextNode);
    }

    var urlRegex2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

    while (textNode && (result = urlRegex2.exec(textNode.data))) {
        matchedTextNode = textNode.splitText(result.index);
        matchedText = result[0];
        matchLength = matchedText.length;
        textNode = (matchedTextNode.length > matchLength) ?
            matchedTextNode.splitText(matchLength) : null;
        surroundingNode = surrounderCreateFunc(matchedTextNode.cloneNode(true));
        parent.insertBefore(surroundingNode, matchedTextNode);
        parent.removeChild(matchedTextNode);
    }
}

var textbox = document.getElementById("editor");
var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;


function updateLinks() {
    var savedSelection = saveSelection(textbox);
    surroundInElement(textbox, urlRegex, createLink, shouldLinkifyContents);
    restoreSelection(textbox, savedSelection);
}

function editorChange() {

}

function updateImage() {
    var savedSelection = saveSelection(textbox);
    textbox.appendChild(createImage(getFileName()));
    restoreSelection(textbox, savedSelection);
}

var $textbox = $(textbox);

$(document).ready(function () {
    //declare elements
    var editor = $("#editor");
    var id = $("#id");
    var lastText = editor.text();

    $textbox.focus();

    var keyTimer = null, keyDelay = 1000;

    $textbox.keyup(function () {
        if (keyTimer) {
            window.clearTimeout(keyTimer);
        }
        var $this = $(this);
        $this.data('before', $this.html());

        keyTimer = window.setTimeout(function () {
            var $this = $(this);
            if ($this.data('before') !== $this.html()) {
                $this.data('before', $this.html());


                updateLinks();
                //updateLinks();
                keyTimer = null;
            }
        }, keyDelay);
    });

    $('#uploadimage')
        .submit(function (e) {

            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            console.log(percentComplete);

                            if (percentComplete === 100) {
                                console.log("uploaded");
                            }

                        }
                    }, false);

                    return xhr;
                },
                url: '/ajax/notes/uploads/',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response) {
                        console.log(response);
                        updateImage();
                        save();

                    } else {

                        console.log("Error closing this note");
                    }
                }
            });
            e.preventDefault();
        });


    //save data to the database
    function save() {
        $.ajax({
            type: 'GET',
            url: "/ajax/notes/",
            data: {
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

});

$(function () {
    $("#file").change(function () {
        $("#message").empty(); // To remove the previous error message
        alert("heere");

        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $('#previewing').attr('src', 'noimage.png');
            $("#message").html("<p id='error' class='alert alert-danger'>Please Select A valid Image File</p><span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        }
        else {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);


        }
    });
});

function imageIsLoaded(e) {
    $("#file").css("color", "green");
    $('#image_preview').css("display", "block");
    $('#previewing').attr('src', e.target.result);
    $('#previewing').attr('width', '250px');
    $('#previewing').attr('height', '230px');
}

function getFileName() {
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

