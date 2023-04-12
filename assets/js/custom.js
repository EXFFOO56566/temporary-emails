/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

$(document).ready(function () {
    "use strict";

    $("#name").on("change", function () {
        $.ajax({
            type: 'GET',
            url: checkslug,
            data: {
                name: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#slug').val(data.slug);
            }
        });
    });

    $("#title").on("change", function () {
        $.ajax({
            type: 'GET',
            url: checkslug_title,
            data: {
                title: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#slug').val(data.slug);
            }
        });
    });

    $('body').on('click', '.confirm', function () {
        var id = $(this).attr("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00674f",
            cancelButtonColor: "#f64e60",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete" + id).submit();
            }
        });
    });

    try {
        $.uploadPreview({
            input_field: "#profile-upload",
            preview_box: "#profile-preview",
            no_label: true
        });
    } catch (error) { }

    try {
        $.uploadPreview({
            input_field: "#favicon-upload",
            preview_box: "#favicon-preview",
            no_label: true
        });

        $.uploadPreview({
            input_field: "#site-logo-upload",
            preview_box: "#site-logo-preview",
            no_label: true
        });
    } catch (error) { }


    $(".check_imap").on("click", function () {
        $(this).attr('disabled', 'disabled');
        $("#log_info").html('');
        $(".log").css('display', 'block');
        var _token = $("input[name='_token']").val();
        var host = $("input[name='imap_host']").val();
        var port = $("input[name='imap_port']").val();
        var user = $("input[name='imap_user']").val();
        var pass = $("input[name='imap_pass']").val();
        var encryption = $("#encryption").val();
        var certificate = $("input[name='imap_certificate']:checked").val();

        $("#log_info").append('<div class="info">Connecting...</div>');
        $.ajax({
            url: check_link,
            type: 'POST',
            data: { _token: _token, host: host, port: port, user: user, pass: pass, encryption: encryption, certificate: certificate },
            success: function (data) {
                $('.check_imap').removeAttr('disabled', 'disabled');
                $("#log_info").html('');
                $("#log_info").append(data);
            },
            error: function (data) {
                $('.check_imap').removeAttr('disabled', 'disabled');
                $("#log_info").append(data);
            }

        });
    });


    $('#language').on('change', function () {
        const lang = $(this).val();
        console.log(lang);
        if (lang) {
            $.ajax({
                url: BASE_URL + '/posts/getcategory/' + lang,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if ($.isEmptyObject(data.message)) {
                        console.log("dddd");
                        $('#category').empty();
                        $.each(data, function (key, value) {
                            console.log("ssss");
                            $('#category').append('<option value="' + key + '">' + value + '</option>');
                        });
                    } else {
                        $('#category').empty();
                        $('#category').append('<option value="" selected disabled>Choose</option>');
                        alert(data.message);
                    }
                }
            });
        } else {
            $('#category').empty();
        }
    });



});
