function validate1(val) {
    const v1 = document.getElementById("fname");
    const v2 = document.getElementById("lname");
    const v3 = document.getElementById("email");
    const v4 = document.getElementById("mob");

    let flag1 = v1.value.trim() !== "";
    let flag2 = v2.value.trim() !== "";
    let flag3 = v3.value.trim() !== "";
    let flag4 = v4.value.trim() !== "";

    v1.style.borderColor = flag1 ? "green" : "red";
    v2.style.borderColor = flag2 ? "green" : "red";
    v3.style.borderColor = flag3 ? "green" : "red";
    v4.style.borderColor = flag4 ? "green" : "red";

    return flag1 && flag2 && flag3 && flag4;
}

function validate2(val) {
    const v1 = document.getElementById("cname");
    const v2 = document.getElementById("zip");
    const v3 = document.getElementById("state");
    const v4 = document.getElementById("city");

    let flag1 = v1.value.trim() !== "";
    let flag2 = v2.value.trim() !== "";
    let flag3 = v3.value.trim() !== "";
    let flag4 = v4.value.trim() !== "";

    v1.style.borderColor = flag1 ? "green" : "red";
    v2.style.borderColor = flag2 ? "green" : "red";
    v3.style.borderColor = flag3 ? "green" : "red";
    v4.style.borderColor = flag4 ? "green" : "red";

    return flag1 && flag2 && flag3 && flag4;
}

$(document).ready(function () {
    let current_fs, next_fs, previous_fs;

    $(".next").click(function () {
        const stepId = $(this).attr('id');
        let valid = false;

        if (stepId === "next1") {
            valid = true;
        } else if (stepId === "next2") {
            valid = validate1();
        } else if (stepId === "next3") {
            valid = validate2();
        }

        if (valid) {
            current_fs = $(this).closest("fieldset");
            next_fs = current_fs.next("fieldset");

            current_fs.removeClass("show");
            next_fs.addClass("show");

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            current_fs.animate({ opacity: 0 }, {
                duration: 400,
                step: function (now) {
                    current_fs.css({ display: 'none', position: 'relative' });
                    next_fs.css({ display: 'block', opacity: 1 });
                }
            });
        }
    });

    $(".prev").click(function () {
        current_fs = $(this).closest("fieldset");
        previous_fs = current_fs.prev("fieldset");

        current_fs.removeClass("show");
        previous_fs.addClass("show");

        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        current_fs.animate({ opacity: 0 }, {
            duration: 400,
            step: function (now) {
                current_fs.css({ display: 'none', position: 'relative' });
                previous_fs.css({ display: 'block', opacity: 1 });
            }
        });
    });

    $('.radio-group .radio').click(function () {
        $('.radio-group .radio').removeClass('selected');
        $(this).addClass('selected');
    });
});

