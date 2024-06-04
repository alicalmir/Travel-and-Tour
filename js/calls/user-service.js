var UserService = {
    init: function () {
        $("#register-form").validate({
            submitHandler: function (form, event) {
                event.preventDefault();
                var entity = Object.fromEntries(new FormData(form).entries());
                UserService.register(entity);
            }
        });
    },
    register: function (entity) {
        $.ajax({
            url: "https://665e5edee990e77d3544f75e--eclectic-cocada-04df81.netlify.app/register",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function () {
                toastr.success("Registration successful");
                setTimeout(function () {
                    window.location.replace("login.html"); 
                }, 2000);
            },
            error: function () {
                toastr.error("Registration failed");
            },
        });
    },
};
