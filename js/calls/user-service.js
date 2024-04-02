var UserService = {
    init: function () {
        $("#register-form").validate({
            submitHandler: function (form, event) {
                event.preventDefault();
                var entity = Object.fromEntries(new FormData(form).entries());
                UserService.register(entity);
            },
        });
    },
    register: function (entity) {
        $.ajax({
            url: "https://bookingtrips-b98c7c869cca.herokuapp.com/register",
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
