function expand_div(id) {
    $.ajax({

        type: "GET",
        url: '/getone',
        data: "id=" + id, // appears as $_GET['id'] @ your backend side
        success: function(response) {
            console.log(response)
            $('#' + id).html(response);
        }

    });
}

function new_form() {
    $("#new_box").html("<form id='new_form' action='/save' method='post'> " +
        "<br><textarea class='well' name='idescription' id='idescription' style='width: 97%'>Description</textarea><br>" +
        "<select name='ipriority' id='ipriority' class='form-control' style='width: 97%'>" +
            "<option selected disabled>Priority</option>" +
            "<option value='5'>5</option>" +
        "<option value='4'>4</option>" +
        "<option value='3'>3</option>" +
        "<option value='2'>2</option>" +
        "<option value='1'>1</option>" +
        "</select><br>" +
        // "<input type='submit' value='Submit' name='button_submit'>"
        "<br><input id='submit' onclick='gogogo()' type='button' value='Submit' class='btn btn-default btn-lg'>" +
        "</form>");

    $("#idescription")
        .focus(function() {
            if (this.value === this.defaultValue) {
                this.value = '';
            }
        })
        .blur(function() {
            if (this.value === '') {
                this.value = this.defaultValue;
            }
        });
}

function gogogo() {

    /* stop form from submitting normally */
    // event.preventDefault();

    /* get the action attribute from the <form action=""> element */
    // var $form = $( this ),
    //     url = $form.attr( 'action' );
    //
    /* Send the data using post with element id name and name2*/
    // var posting = $.post( url, { description: $('#description').val(), priority: $('#priority').val() } );

    $.ajax({
        type: "GET",
        url: "/save",
        data: {
            description: document.getElementById("idescription").value,
            priority: document.getElementById("ipriority").value
        },
        success: function(response) {
            $("#screen").append(response);
            $("#new_box").html("<button type='button' class='btn btn-default btn-lg' id='new_button' onclick='new_form()'><span class='glyphicon glyphicon-floppy-saved' aria-hidden='true'></span> New Goal </button>");
        }

    });

    $.ajax({
        type: 'GET',
        url: '/getdone',
        success: function(response){
            $('#left_panel').html(response);
        }
    });

    /* Alerts the results */
}

// document.getElementById("logout_button").onclick = function () {
//     location.href = "/logout";
// };

$(document).on('click', '.head', function() {
    var clicks = $(this).data('clicks');
    if (clicks) {
        $(this.parentNode).css("height", "50px");
        $(this.parentNode).find(".inner_p").css("visibility", "hidden");
    } else {
        $(this.parentNode).css("height","110px");
        $(this.parentNode).find(".inner_p").css("visibility", "visible");
    }
    $(this).data("clicks", !clicks);
});

function done(e){
    var idd = e.parentNode.parentNode.getAttribute('id');

    $.ajax({
        type: 'GET',
        url: '/update',
        data: {
            id: idd
        },
        success: function (){

            // var neww = e.parentNode.parentNode.cloneNode(true);
            // neww.removeChild(neww.childNodes[3]);
            // // $('#screen2').prepend(a);
            // var container = document.getElementById('screen2');
            // container.insertBefore(neww, container.firstChild);
            //
            // // container.append(neww);
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        }
    })

    $.ajax({
        type: 'GET',
        url: '/getdone',
        success: function(response){
            $('#left_panel').html(response);
        }
    });

}

