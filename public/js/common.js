function numericFilter(txb) {
   txb.value = txb.value.replace(/[^0-9]/ig, "");
}
function wowMsg(str, subjtitle) {
    if (typeof (subjtitle) == "undefined")
        subjtitle = "Message Box";
    var unique_id = $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: subjtitle,
        // (string | mandatory) the text inside the notification
        text: str,
        // (string | optional) the image to display on the left
        // image: './assets/img/avatar1.jpg',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: true,
        // (int | optional) the time you want it to be alive for before fading out
        time: '',
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
    });

    // You can have it return a unique id, this can be used to manually remove it later using
    setTimeout(function () {
        $.gritter.remove(unique_id, {
            fade: true,
            speed: 'slow'
        });
    }, 8000);
}

//  $("#manuModal").on("hide.bs.modal", function(event) {
//	$('#manuModal .modal-body').html('Loading....');
//        $('#manuModal h4.modal-title').html('Modal title');
//        $('#manuModal .modal-body').html('');
//        if($('#manuModal .modal-footer').length == 0){
//        $('#manuModal .modal-body').after('<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary">Save changes</button></div>');
//    }
//});

$('.switch-status.change-request').on('switchChange.bootstrapSwitch', function (e, state) {
    var _this = $(this);
    var _id = _this.data("id");
    var url = _this.data("url");
    var field = _this.data("field");
    var table = _this.closest("section.content").data("table");
    if (e.target.checked == true) {
        var changedval = 1;
    } else {
        var changedval = 0;
    }
     var defaultMsg = 'Do you really want to process this action !';
    $.confirm({
        title: 'Alert',
        content: defaultMsg,
        icon: 'fa fa-exclamation-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        theme: 'supervan',
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-blue',
                action: function () {
                    if (url == undefined) {
                        url = baseurl + 'admin/' + table + '/change-flag/';
                    }
                    if (field == undefined) {
                        field = 'status';
                    }
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {id: _id,field:field, status: changedval},
                        dataType: 'json',
                        headers: {
                            "accept": "application/json",
                        },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', CLIENT_TOKEN);
                        },
                        complete: function () {
                        },
                        success: function (record) {
                            wowMsg(record.message);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            cancelAction: {
                text: 'Cancel',
                action: function () {
                   if (changedval == 1) {
                        _this.bootstrapSwitch('state', false,'skip');
                    } else {
                        _this.bootstrapSwitch('state', true,'skip');
                    }
                }
            }
        }
    });



});
$(document).on('click', '.confirmDeleteBtn', function () {

    var _this = $(this);
    var _id = _this.data("id");
    var url = _this.data("url");
    var message = _this.data("message");
    var title = _this.data("title");

        if (message == undefined) {
            if (title == undefined) {
                message = 'Are you sure want to delete this record ?';
            }else{
                message = 'Are you sure want to delete '+title+'?';
            }
        }

    $.confirm({
        title: 'Alert',
        content: message,
        icon: 'fa fa-exclamation-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        theme: 'supervan',
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-blue',
                action: function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            "accept": "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (record) {

                            wowMsg(record.message);
                            $(".row-" + record.data.id).remove();
                            setTimeout(function(){ location.reload();
                             }, 2000);


                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            cancelAction: {
                text: 'Cancel',
            }
        }
    });



});


/*function confirmAction(link, msg) {
    var defaultMsg = 'Are you sure want to delete this ' + msg + ' !';
    swal({
        title: "Are you sure?",
        text: defaultMsg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel !",
        closeOnConfirm: true,
        closeOnCancel: true
    },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = link;
                }
            });

    return false;
}
*/
function confirmDelete(elem, title) {
    var title = title;
    var message = $(elem).data("message");
    if (message != undefined) {
            title = message;
        }else{
            title = 'Are you sure want to delete '+title+'?';
        }
    $.confirm({
        title: 'Alert',
        content: title,
        icon: 'fa fa-exclamation-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        theme: 'supervan',
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-blue',
                action: function () {
                    var action = $(elem).prev('form').attr('action');
                    if (action.indexOf('delete') > -1) {
                        $(elem).prev('form').submit();
                    }
                }
            },
            cancelAction: {
                text: 'Cancel'
            }
        }
    });
}

function confirmRemove(elem, title) {
    $.confirm({
        title: 'Alert',
        content: 'Are you sure want to delete '+title+'?',
        icon: 'fa fa-exclamation-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        theme: 'supervan',
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-blue',
                action: function () {
                   if (elem.length > 0) {
                        elem.remove();
                    }
                }
            },
            cancelAction: {
                text: 'Cancel'
            }
        }
    });
}


$(document).on('click', '.confirmDeleteAjax', function (event) {
    event.preventDefault();
    var _this = $(this);
    var title = _this.data('title');
    $.confirm({
        title: 'Alert',
        content: 'Are you sure want to delete '+title+'?',
        icon: 'fa fa-exclamation-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        theme: 'supervan',
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-blue',
                action: function () {
                   $.ajax({
                        url: _this.attr('href'),
                        type: 'DELETE',
                        dataType: "json",
                        headers: {
                            "accept": "application/json",
                        },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', CLIENT_TOKEN);
                        },
                        success: function (response) {
                            if(response.status == true){
                                _this.closest('.deletedRow').remove();
                            }
                          wowMsg(response.message);
                        },
                       complete: function() {
                        },
                    });
                }
            },
            cancelAction: {
                text: 'Cancel'
            }
        }
    });
});

$("#quickStartForm").submit(function (event) {
    event.preventDefault();
    l = Ladda.create(document.querySelector('.l-button'));
    l.start();
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'none');
    var form = $(this);
    $.ajax({
        url: form.attr("action"),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (responce) {
            if (responce.status === true) {
                form[0].reset();
                $.alert({
                        title: 'Success!',
                        icon: 'fa fa-info',
                        content: responce.errors,
                        type: 'green',
                        theme: 'light',
                        buttons: {
                            Okay: function(){
                                window.location.reload(true);
                            }
                        }
                    });

            } else {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $(".print-error-msg").find("ul").append(printErrorMsg(responce.errors));
            }
            l.stop();

        }, error: function (data) {
            var errors = data.responseJSON;
            //console.log(errors);
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $(".print-error-msg").find("ul").append(printErrorMsg(errors));
            l.stop();
        }

    });
});

function printErrorMsg(msg) {
    var html = '';
    console.log(msg);
    $.each(msg, function (key, value) {
        if (typeof value == 'object') {
            $.each(value, function (key2, value2) {
                html += '<li>' + value2 + '</li>';
            });
        } else {
            html += '<li>' + value + '</li>';
        }
    });
    return html;
}


