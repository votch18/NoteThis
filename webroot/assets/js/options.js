$(document).ready(function () {


    /**Add confirmation message */
    function confirmDelete(msg) {
        if (confirm(msg)) {
            return true;
        } else {
            return false;
        }

    }

});