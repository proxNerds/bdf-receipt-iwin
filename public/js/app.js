var App = App || {};
App = {
    GLOBAL: {
        isMobile:
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                navigator.userAgent,
            ),
        baseURL: "",
        //baseURL: $('#proxyFrameContent').data('pf-proxy-url'),
        APIKey: "TklWRUEuSVQgVjd8TlZJVHN0YW5kYXJkcw==",
        nlList: 0,
        communityMember: 0,
    },

    SalesForce: {
        init: function () {
            // get profile id (if user is logged)
            App.SalesForce.checkUser();

            $(".imageModalBtn").on("click tap", function (event) {
                // da sistemare
                event.preventDefault();
                var num = $(this).data("num");
                /*$('#output_image1').css('width', '100%');
                $('#output_image1').css('max-width', '100%');
                $('#output_image1').css('max-height', '100%');*/
                //console.log('imageModalBtn'+num+' clicked');

                $("[id^=imagepreview]").addClass("hidden");
                $("#imagepreview" + num).removeClass("hidden");
                $(".overlayer").fadeIn();
                $("body").addClass("vex-open");
                //$('#staticBackdrop').modal('show');
            });

            $(".closeBtn").on("click tap", function () {
                $(".overlayer").fadeOut();
                $("body").removeClass("vex-open");
            });

            $(".overlayer").on("click tap", function () {
                $(".overlayer").fadeOut();
                $("body").removeClass("vex-open");
            });
        },

        checkUser: function () {
            $.ajax({
                url: App.GLOBAL.baseURL + "sales-force/checkuser",
                type: "POST",
                dataType: "json",
                data: {
                    dummy: "dummydata",
                },

                success: function (data, status, jqXHR) {
                    // console.log("status--->", jqXHR.status);
                    // console.log("success");
                    // console.log(data.Data);
                    if (jqXHR.status === 200 && data.errors.length === 0) {
                        if (data.Data.length === 0) {
                            App.SalesForce.setView(true);
                            // console.log("status = 200 data->vuoto");
                        } else {
                            App.SalesForce.setUserData(data.Data);
                            // console.log("status = 200");
                        }
                    } else {
                        App.SalesForce.setView(false);
                        // console.log("status != 200");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // console.log("error");
                    // console.log(jqXHR);
                    App.SalesForce.setView(false);
                },
            });
        },
        setUserData: function (userData) {
            // console.log("setUserData");
            // console.log(userData);
            $.each(userData, function (key, value) {
                switch (key) {
                    case "Email":
                        $("#email").val(value);
                        $("#email").attr("readonly", true);
                        break;
                    case "Firstname":
                        $("#firstname").val(value);
                        $("#firstname").attr("readonly", true);
                        break;
                    case "Lastname":
                        $("#lastname").val(value);
                        $("#lastname").attr("readonly", true);
                        break;
                    case "Birthday":
                        if (value != "" && value != null) {
                            var t = value.split(/[- :]/);
                            if (t[0] != "" || t[1] != "" || t[2] != "") {
                                var dateString = t[0] + "-" + t[1] + "-" + t[2];
                                $("#birthdate").val(dateString);
                                $("#dob").val(dateString);
                                $("#dob").attr("readonly", true);
                            }
                        }
                        break;
                    case "LogonGuid":
                        $("#crm_id").val(value);
                        $("#is_registered").val(1);
                        break;
                    case "Salutation":
                        $("#salutation").val(value);
                        break;
                    case "list:NIVEA_E_Newsletter":
                        if (value == 1) {
                            App.GLOBAL.nlSubscriber = 1;
                        }
                        break;
                    case "list:NIVEA_Email":
                        if (value == 1) {
                            App.GLOBAL.nlList = 1;
                        }
                        break;
                    case "list:NIVEA_Community":
                        if (value == 1) {
                            App.GLOBAL.communityMember = 1;
                        }
                        break;
                    case "ListNL":
                        if (value == 1) {
                            App.GLOBAL.nlSubscriber = 1;
                        }
                        break;
                    case "ListEmail":
                        if (value == 1) {
                            App.GLOBAL.nlList = 1;
                        }
                        break;
                    case "ListCommunity":
                        if (value == 1) {
                            App.GLOBAL.communityMember = 1;
                        }
                        break;
                    default:
                }
            });
            //});

            App.SalesForce.setView(true);
        },
        setView: function (logged) {

            if (!logged) {
                $("#loginMessage").removeClass("hidden");

                let loginUrl = document.getElementById("loginUrl");
                loginUrl.href =
                    "https://www.nivea.it/session/signin?returnUrl=" +
                    location.href;


            }
            // console.log(logged + " : " + App.GLOBAL.communityMember);
            // if (!logged) {
            //     console.log("not logged");
            //     $("#notlogged").removeClass("hidden");
            //     let linklogin = document.getElementById("loginBtn");
            //     let linkRegister = document.getElementById("registerBtn");
            //     linklogin.href =
            //         "https://www.nivea.it/session/signin?returnUrl=" +
            //         location.href;
            //     linkRegister.href =
            //         "https://www.nivea.it/session/signin?type=signup&returnUrl=" +
            //         location.href;
            //     $("#logged").empty();
            //     return false;
            // } else if (logged && !App.GLOBAL.communityMember) {
            //     console.log("logged but not in community");
            //     $("#notConfirmed").removeClass("hidden");
            //     $("#logged").empty();
            //     let linkProfile = document.getElementById("profileBtn");
            //     linkProfile.href =
            //         location.href + "#layer=Account/Profile/Profile";
            //     return false;
            // } else if (logged && App.GLOBAL.communityMember) {
            //     console.log("logged and in community");
            //     $("#logged").removeClass("hidden");
            // }

            $("#logged").removeClass("hidden");

            if (App.GLOBAL.nlList) {
                $("#newsletterCheckbox").hide();
            }
            // if ($("#birthdate").val() != "") {
            $("#privacyAgeCheck").hide();
            // }
        },
    },
    Forms: {
        init: function () {
            App.Forms.handleCheckBoxes();
            App.Forms.handleSubmit();
        },
        preview_img: function (event, num) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById("output_image" + num);
                var output_modal = document.getElementById(
                    "imagepreview" + num,
                );
                output_modal.src = reader.result;
                output.src = reader.result;
            };
            $("#imageModalBtn" + num).removeClass("hidden");
            //alert($('.imageModalBtn').find("[data-num='" + num + "']").data('num'));
            reader.readAsDataURL(event.target.files[0]);
        },

        handleSubmit: function () {
            $("#submitBtn").on("click tap", function (e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).prop("disabled", true);
                // $(this).prop("disabled") === true
                //     ? $(this).css("background-color", "#7383ab")
                //     : $(this).css("background-color", "#0032a0");

                oldText = $(this).text();

                $(this).text("in elaborazione");
                var spinner =
                    '<span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>';
                $(spinner).appendTo("#submitBtn");

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

                var formData = new FormData();
                //check file size
                const fi1 = document.getElementById("receipt_img1_url");
                const fi2 = document.getElementById("receipt_img2_url"); // file uppload
                if (
                    fi2 !== null &&
                    $("#receipt_img2_url").get(0).files.length > 0
                ) {
                    var file2 = $("#receipt_img2_url").get(0).files[0];
                    formData.append("receipt_img2_url", file2);
                }

                if (
                    fi1 !== null &&
                    $("#receipt_img1_url").get(0).files.length > 0
                ) {
                    var file1 = $("#receipt_img1_url").get(0).files[0];
                    formData.append("receipt_img1_url", file1);
                }

                f1size = false;
                f2size = false;

                // Check if any file is selected.
                if (fi1 !== null && fi1.files.length > 0) {
                    for (i = 0; i <= fi1.files.length - 1; i++) {
                        fsize = fi1.files.item(i).size;
                        file = Math.round(fsize / 1024);
                        // The size of the file.
                        if (file >= 4096) {
                            f1size = true;
                        }
                    }
                } else if (fi2 !== null && fi2.files.length > 0) {
                    for (j = 0; j <= fi2.files.length - 1; j++) {
                        fsize2 = fi2.files.item(j).size;
                        file2 = Math.round(fsize2 / 1024);
                        // The size of the file.
                        if (file2 >= 4096) {
                            f2size = true;
                        }
                    }
                }

                if (f1size || f2size) {
                    // error handling to fix for the new layout
                    html =
                        "<ul><li>Verifica che le dimensioni delle immagini rispettino i requisiti</li><ul>";
                    $("#submitBtn-step2").prop("disabled", false);
                    App.Plugins.displayVexAlert(html);
                    return false;
                }
                // end file uppload

                var receiptTotal =
                    $("#inputEuro").val() + "," + $("#inputCentesimi").val();
                if ($("#inputCentesimi").val() === "") {
                    var receiptTotal = $("#inputEuro").val() + ",00";
                }
                //formData.append('receipt_img2_url',file2);
                // console.log(receiptTotal);
                formData.append("is_registered", $("#is_registered").val());
                formData.append("firstname", $("#firstname").val());
                formData.append("lastname", $("#lastname").val());
                formData.append("email", $("#email").val());
                formData.append("dob", $("#dob").val());
                formData.append("phone", $("#phone").val());
                formData.append("birthdate", $("#birthdate").val());
                formData.append("crm_id", $("#crm_id").val());
                formData.append("receipt_number", $("#receipt_number").val());
                formData.append("receipt_total", receiptTotal);
                formData.append("receipt_hour", $("#receipt_hour").val());
                formData.append("receipt_minute", $("#receipt_minute").val());

                const receipt_date_val = $("#receipt_date").val()
                const t = receipt_date_val.split(/[- :]/);
                const receipt_dateString = t[2] + "/" + t[1] + "/" + t[0];
                formData.append("receipt_date", receipt_dateString);

                formData.append(
                    "privacy_tc",
                    $("input[name=privacy_tc_check]").val(),
                );
                formData.append("privacy_age", $("#privacy_age").val());
                formData.append("newsletter", $("#newsletter").val());
                formData.append("_token", CSRF_TOKEN);

                var contestFormContainer = document.getElementById(
                    "contestForm-container",
                );
                var checkPriv = document.getElementById("privacy_tc_check");

                var loser = document.getElementById("loser");

                //AJAX START
                $.ajax({
                    url: App.GLOBAL.baseURL + "participate",
                    type: "POST",
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        var count = 0;
                        $(".spinner-border").remove();
                        $("#submitBtn").text(oldText);
                        if (data.errors) {
                            count = Object.keys(data.errors).length;
                        }
                        if (count > 0) {
                            $(".spinner-border").remove();
                            $("#submitBtn").text(oldText);

                            $.each(data.errors, function (key, value) {
                                // handle invalid-tooltips (under inputs) msg response
                                $(".invalidFormInput").each(function () {
                                    if ($(this).attr("id") === key + "_err") {
                                        $(this).text("");
                                        $(this).append(value);

                                        $("#" + key).addClass("is-invalid");
                                        $("#" + key + "_err").show();
                                        // set label tag in red
                                        $("." + key).addClass("is-invalid");
                                    }
                                    if (key === "crm_id") {
                                        $("#email").addClass("is-invalid");
                                        $(".email").addClass("is-invalid");
                                        $("#loginUrl").attr(
                                            "href",
                                            "https://www.nivea.it/session/signin?returnUrl=" +
                                            location.href,
                                        );
                                    }

                                    if (key === "privacy_tc") {
                                        $("#privacylabel").css("color", "red");
                                    }

                                    if (key === "birthdate") {
                                        // console.log(key, value);
                                        $("#privacyAgelabel").css(
                                            "color",
                                            "red",
                                        );
                                    }

                                    if (key === "receipt_total") {
                                        $("#inputEuro").addClass("is-invalid");
                                        $(".inputEuro").addClass("is-invalid");
                                        $("#inputCentesimi").addClass(
                                            "is-invalid",
                                        );
                                        $(".inputCentesimi").addClass(
                                            "is-invalid",
                                        );
                                    }
                                });
                            });

                            return false;
                        }

                        // window.location.href = data.typ_win_url[0];

                        const isRegistered = $("#is_registered").val();
                        const subscriptionBlock = document.getElementById("subscriptionBlock");
                        const registrationCTA = document.getElementById("registrationCTA");
                        let registrationUrl = 'https://www.nivea.it/session/signin?type=signup&email=' + $("#email").val() + '&returnUrl';

                        if (data.won[0]) { //if winner show

                            const winner = document.getElementById("winner");

                            console.log("won");
                            //window.location.href= data.typ_win_url[0];
                            contestFormContainer.classList.add("d-none");
                            winner.classList.remove("d-none");
                            $(".wincode").empty().html(data.winCode[0]);

                            winner.classList.add("d-flex");
                        } else {
                            console.log("lost");

                            //-----redirect to data.typ_loose_url[0]
                            contestFormContainer.classList.add("d-none");
                            loser.classList.remove("d-none");
                            loser.classList.add("d-flex");

                            // window.location.href = data.typ_loose_url[0];
                        }

                        //if user is not registered show subscription block
                        if (isRegistered == 0) {
                            console.log("not registered");
                            registrationCTA.href = registrationUrl;

                            subscriptionBlock.classList.remove("d-none");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#internalErrorMsg").text("");

                        $(".spinner-border").remove();
                        $("#submitBtn").text(oldText);
                        // console.log(jqXHR);
                        // console.log(textStatus);
                        // console.log(errorThrown);

                        var count = 0;
                        if (jqXHR.responseJSON == undefined) {
                            $("#submitBtn").prop("disabled", false);

                            $("#internalErrorMsg").append(
                                "Si è verificato un problema, riprovare più tardi.",
                            );

                            return false;
                        } else {
                            $("#internalErrorMsg").append(errorThrown);
                        }

                        /* POSSIBLE ERRORS TODO*/
                        /*
                        'not_active' : 'The selected sweepstake is not active'
                        'not_started' : 'The selected sweepstake is not started'
                        'ended' : 'The selected sweepstake is ended'
                        'user_maxplays_all', 'User reached maximum number of plays allowed ([numero max giocate impostate nel db])'
                        'user_maxplays_day' : 'User reached maximum number of plays allowed for today ([numero max giocate impostate nel db])'
                        'user_maxwins', 'User reached maximum number of wins allowed ([numero max giocate impostate nel db])'
                        */
                    },
                }); //AJAX END
                document
                    .getElementById("contestForm-container")
                    .scrollIntoView();
            });
        },

        handleCheckBoxes: function () {
            $("#privacy_age").val(0);

            $("input[type=checkbox]").on("change", function () {
                if ($(this).hasClass("checked")) {
                    $(this).removeClass("checked");
                    $(this).removeClass("is-valid");
                    if ($(this).attr("id") == "privacy_age_check") {
                        $("#privacyAgelabel").css("color", "red");
                    }
                    if ($(this).attr("id") == "privacy_tc_check") {
                        $("#privacylabel").css("color", "red");
                    }

                    $(this).val(0);
                } else {
                    $(this).addClass("checked");
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    // console.log("checkbox", $(this).id);
                    if ($(this).attr("id") == "privacy_tc_check") {
                        $("#privacylabel").css("color", "#0032a0");
                    }
                    if ($(this).attr("id") == "privacy_age_check") {
                        $("#privacyAgelabel").css("color", "#0032a0");
                    }
                    $(this).val(1);
                }

                if ($("input:checked[name='privacy_age_check']").length > 0) {
                    $("#privacy_age").val(1);
                } else {
                    $("#privacy_age").val(0);
                }
            });
        },
        handleKeyStrokes: function (evt) {
            var charCode = evt.which ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
            return true;
        },
        handleMaxNumber: function (evt, input) {
            var charCode = evt.which ? evt.which : event.keyCode;
            var val = $(input).val();
            var length = val.length;

            if (length == 0) {
                if (charCode > 31 && (charCode < 48 || charCode > 50))
                    return false;
                return true;
            } else {
                if (val.charAt(0) == "2") {
                    if (charCode > 31 && (charCode < 48 || charCode > 51))
                        return false;
                    return true;
                } else {
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                    return true;
                }
            }
        },
        handleMaxNumberMin: function (evt, input) {
            var charCode = evt.which ? evt.which : event.keyCode;
            var val = $(input).val();
            var length = val.length;
            if (length == 0) {
                if (charCode > 31 && (charCode < 48 || charCode > 53))
                    return false;
                return true;
            } else {
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }
        },
    },
    Plugins: {
        init: function () {
            this.handlePlaceholder();
            this.handleFormElementFocus();
            this.handleButtonDisabled();
            this.handleTooltips();
            this.handleTooltipImgDestryOnClose();
            this.handleInputUiValidation();
            this.handleSubmitDisabledBtn();
            this.handleDatePicker();
        },

        hasParticipated: function (crm_id, contest_id) {
            $.ajax({
                url: App.GLOBAL.baseURL + "hasParticipated",
                type: "POST",
                dataType: "json",
                data: {
                    crm_id: crm_id,
                    contest_id: contest_id,
                },

                success: function (data, status, jqXHR) {
                    // console.log("status--->", jqXHR.status);
                    // console.log("success");
                    // console.log(data.Data);
                    if (jqXHR.status === 200 && data.errors.length === 0) {
                        if (data.Data.length === 0) {
                            App.SalesForce.setView(true);
                            // console.log("status = 200 data->vuoto");
                        } else {
                            App.SalesForce.setUserData(data.Data);
                            // console.log("status = 200");
                        }
                    } else {
                        App.SalesForce.setView(false);
                        // console.log("status != 200");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // console.log("error");
                    // console.log(jqXHR);
                    App.SalesForce.setView(false);
                },
            });
        },

        //

        // keep submit Btn disabled until all inputs are not anymore is-invalid
        handleSubmitDisabledBtn: function () {
            $("input").on("input", function (e) {
                e.preventDefault();
                $("#submitBtn").prop("disabled", false);
                // $("#submitBtn").css("background-color", "#0032a0");
            });

            $("input").change(function (e) {
                e.preventDefault();
                $("#submitBtn").prop("disabled", false);
                // $("#submitBtn").css("background-color", "#0032a0");
            });
        },

        handleInputUiValidation: function () {
            $("input[type=text],input[type=email]").on("input", function (e) {
                // console.log("***");
                e.preventDefault();
                // console.log("eeeeeee", this.classList);

                if (this.id === "inputCentesimi" || this.id === "inputEuro") {
                    $("#receipt_total_err").hide();
                }
                if (this.id === "inputCentesimi" || this.id === "inputEuro") {
                    $("#receipt_total_err").hide();
                }

                if (
                    this.id === "receipt_hour" ||
                    this.id === "receipt_minute"
                ) {
                    $("#receipt_date_range_err").hide();
                }

                $("#receipt_duplicate_err").hide();
                $("#" + this.id + "_err").hide();
                $(this).removeClass("is-invalid");
                // aggiungi is-valid per controllare input state
                $(this).addClass("is-valid");
                // remove is-invalid class to current label tag
                $("." + this.id).removeClass("is-invalid");
            });

            $("input[type=file]").on("change", function (e) {
                e.preventDefault();
                $("#" + this.id + "_err").hide();
                $(this).removeClass("is-invalid");
            });

            $("input[type=datetime],input[type=date]").on("change", function (e) {
                e.preventDefault();
                $("#" + this.id + "_err").hide();
                $("#receipt_date_range_err").hide();
                $(this).removeClass("is-invalid");
                // remove class is-invalid on label datePicker
                $("." + this.id).removeClass("is-invalid");
            });
        },

        handlePlaceholder: function () {
            if ($.isFunction($.fn.placeholder)) {
                $("input, textarea, select").placeholder({
                    customClass: "placeholded",
                });
            }
        },
        handleFormElementFocus: function () {
            $("input, textarea, select").on("focus", function () {
                $(this).parent().removeClass("has-error");
            });
        },
        handleButtonDisabled: function () {
            $(".buttonDisabled").on("click tap", function (e) {
                e.preventDefault();
            });
        },
        handleTooltips: function () {
            $('[data-toggle="popover"]').popover({
                html: true,
                trigger: "hover  focus",
                container: "body",
            });
            $('[data-toggle="tooltip"]').tooltip({
                container: "body",
            });
            $('[data-toggle="popover-image"]').popover({
                html: true,
                container: "body",
                trigger: "hover  focus",
                content: function () {
                    return '<img src="' + $(this).data("img") + '" />';
                },
            });
        },

        handleTooltipImgDestryOnClose: function () {
            $('[data-toggle="popover"]').on("show.bs.popover", function () {
                // $(this).data("content");
                // console.log("pieno", $(this).data("content"));
            });
            $('[data-toggle="popover"]').on("hidden.bs.popover", function () {
                // $(this).data("content", "");
                // console.log($(this).data("content"));
            });
        },

        handleDatePicker: function () {
            // if ($("#receipt_date").length > 0) {
            //     $("#receipt_date").datepicker({
            //         changeMonth: true,
            //         changeYear: true,
            //         minDate: new Date(2019, 04, 01, 0, 0, 0),
            //         dateFormat: "dd/mm/yy",
            //     });
            // }
            // if ($("#dob").length > 0) {
            //     $("#dob").datepicker({
            //         changeMonth: true,
            //         changeYear: true,
            //         startDate:'1920-01-01',
            //         // minDate: new Date(1920, 01, 01, 0, 0, 0),
            //         dateFormat: "dd/mm/yy",
            //     });
            // }
        },
    },
    Setup: function () {
        App.SalesForce.init();
        App.Forms.init();
        App.Plugins.init();
    },
};
