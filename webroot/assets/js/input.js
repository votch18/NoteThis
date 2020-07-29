function confirmDelete(msg) {
    if (confirm(msg)) {
        return true;
    } else {
        return false;
    }
}


$(document).ready(function () {

    (function ($) {

        //declare elements
        var editor = $("#editor");
        var id = $("#id");


        //add change event
        $('body').on('focus', '[contenteditable]', function () {
            var $this = $(this);
            $this.data('before', $this.html());
            return $this;
        }).on('blur keyup paste input', '[contenteditable]', function () {
            var $this = $(this);
            if ($this.data('before') !== $this.html()) {
                $this.data('before', $this.html());
                $this.trigger('change');
            }
            return $this;
        });


        editor.click(function (e) {

            if ($(e.target).is('a')) {
                window.open(e.target);
            }

        });


        editor.on('change', function (e) {

            if ($(this).children().length < 1) {
                console.log('editable is blank, insert a div' + $(this).children().length);
                $(this).append($('<div>&nbsp;</div>'));
                //e.preventDefault();
            }


            var title = $("#t_" + id.val());


            //getTitle();
            //alert(_title);

            save();

        });


    })(jQuery);

//end of document ready

});