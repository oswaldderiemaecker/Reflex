$(document).ready(function() {
    "use strict";

    $('.datepicker').datepicker({
        startDate: 'now',
        language: 'es',
        format: 'dd/mm/yyyy',
        daysOfWeekDisabled: '0'
    });

    $('.timepicker').timepicker({
        showInputs: false,
        showMeridian: false,
        defaultTime: 'current'
    });

    $('#schedule_refresh').on('click', function() {
        console.log('refreshing calendar');
        $('#calendar').fullCalendar('refetchEvents');
    });

    $("#clear_schedule").click(function() {
        $(".timepicker").val('');
    });

    $("#submit_marketing").click(function() {
        var data_form = $('#form_marketing').serialize();
        console.log(data_form);

        $.ajax({
            type: "PUT",
            url: "/api/clients/"+client_id,
            data: data_form,
            success: function(data) {
                console.log(data);
            }
        });

        $('#marketing-modal').modal('hide');
        toastr.success('Se actualizo la información correctamente!', doctor_name);
        return false;
    });

    $("#submit_note").click(function() {

        if (($('#note_description').val() == '') || $('note_date').val() == '') {
            $('#message').removeClass('hide');
        } else {
            var data_form = $('#form_note').serialize();
            console.log(data_form);

            $.ajax({
                type: "POST",
                url: "/api/notes",
                data: data_form,
                success: function(data) {
                    console.log(data);
                    loadNotes(1);

                    $('#note_description').val('');
                    $('#note_date').val('');
                    $('#message').addClass('hide');
                }
            });

            $('#note-modal').modal('hide');
            toastr.success('Se agrego una nota correctamente!', doctor_name);
        }
        return false;
    });

    loadNotes(1);

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function(ele) {
            console.log("The element has been checked")
        },
        onUncheck: function(ele) {
            console.log("The element has been unchecked")
        }
    });


    $("#submit_schedule").click(function() {
        var zone_id = $('#zone_id').val();
        var client_id = $('#client_id').val();

        var lunes_inicio = $('#lunes_inicio').val();
        var lunes_fin = $('#lunes_fin').val();

        var martes_inicio = $('#martes_inicio').val();
        var martes_fin = $('#martes_fin').val();

        var miercoles_inicio = $('#miercoles_inicio').val();
        var miercoles_fin = $('#miercoles_fin').val();

        var jueves_inicio = $('#jueves_inicio').val();
        var jueves_fin = $('#jueves_fin').val();

        var viernes_inicio = $('#viernes_inicio').val();
        var viernes_fin = $('#viernes_fin').val();

        $.ajax({
            type: "POST",
            url: "/api/schedules",
            data: "zone_id=" + zone_id + "&client_id=" + client_id + "&day=1&start_time=" + lunes_inicio + "&finish_time=" + lunes_fin,
            success: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "/api/schedules",
            data: "zone_id=" + zone_id + "&client_id=" + client_id + "&day=2&start_time=" + martes_inicio + "&finish_time=" + martes_fin,
            success: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "/api/schedules",
            data: "zone_id=" + zone_id + "&client_id=" + client_id + "&day=3&start_time=" + miercoles_inicio + "&finish_time=" + miercoles_fin,
            success: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "/api/schedules",
            data: "zone_id=" + zone_id + "&client_id=" + client_id + "&day=4&start_time=" + jueves_inicio + "&finish_time=" + jueves_fin,
            success: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "/api/schedules",
            data: "zone_id=" + zone_id + "&client_id=" + client_id + "&day=5&start_time=" + viernes_inicio + "&finish_time=" + viernes_fin,
            success: function(data) {
                console.log(data);
                $('#calendar').fullCalendar('refetchEvents');
            }
        });

        $('#schedule-modal').modal('hide');
        toastr.success('Se actualizó el horario correctamente!', doctor_name);

        return false;
    });
});


function loadNotes(page) {
    $.ajax({
        type: "GET",
        url: "/api/notes?zone_id=" + zone_id +"&client_id="+client_id+"&user_id="+user_id+ "&page=" + page,
        contentType: "application/json; charset=utf-8",
        data: "{}",
        dataType: "json",
        success: function(result) {
            displayNotePagination(result);
            displayAllNotes(result.data);
        },
        "error": function(result) {
            console.log(result.responseText);
        }
    });
}


function displayNotePagination(result) {

    $('#note_pagination').empty();

    for (var i = 0; i < result.last_page; i++) {
        var itemHtml = ["<li>",
            "<a href='#' onClick='loadNotes(" + (i + 1) + ");return false;' >" + (i + 1) + "</a>",
            "</li>"
        ].join("\n");

        $("#note_pagination").append(itemHtml);

    }
}

function displayAllNotes(list) {

    $('#list_note').empty();
    $.each(list, function(index, element) {
        displayNote(element);
    });
}

function displayNote(element) {
    var itemHtml = ["<li>",
        //  "<i class='fa fa-fw fa-file-text-o'></i>",
        "<span class='text'>",
        element.description,
        "</span>",
        "<small class='label label-warning'>",
        element.note_type.name,
        "</small>",
        "<small class='label label-info'><i class='fa fa-clock-o'></i>",
        moment(element.date, 'YYYY-MM-DD').lang('es').fromNow(),
        "</small>",
        "<div class='tools'>",
        //  "<i class='fa fa-edit'></i>",
        "<i class='fa fa-trash-o' onClick='deleteNote(\"" + element.uuid + "\")'></i>",
        "</div>",
        "</li>"
    ].join("\n");

    $("#list_note").append(itemHtml);
}


function deleteNote(uuid) {

    bootbox.confirm("Estas seguro?", function(result) {

        if(result)
        {
            $.ajax({
            type: "DELETE",
            url: "/api/notes/" + uuid,
            contentType: "application/json; charset=utf-8",
            data: "{}",
            dataType: "json",
            success: function(result) {
                toastr.success('Se elimino la nota correctamente!', doctor_name);
                loadNotes(1);

            },
            "error": function(result) {
                console.log(result.responseText);
            }
        });
        }
    });
}
