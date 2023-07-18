define([
    'ko',
    'jquery'
], function (ko, $) {
    return function () {
        var self = this;

        self.fristname = ko.observable('');
        self.lastname = ko.observable('');
        self.id = ko.observable('');
        self.address = ko.observable('');
        self.city = ko.observable('');
        self.age = ko.observable('');

        self.tesst = function () {
            var id = $('input[name=delete]:checked').val();
            self.callApi('/rest/V1/well_trained/customer_training/delete/'+id, {}, 'delete');
        };

        self.submitForm = function () {
            // Xử lý logic khi form được submit
            var url = '/rest/V1/well_trained/customer_training/create',
                data = {
                    "frist_name": self.fristname(),
                    "last_name": self.lastname(),
                    "address": self.address(),
                    "city": self.city(),
                    "age": self.age()
                },
                method = 'post';
            if(self.id()){
                url = '/rest/V1/well_trained/customer_training/update';
                $.extend(data, {
                    'id': self.id()
                });
                method = 'put';
            }
            self.callApi(url, JSON.stringify(data), method);
        };

        self.callApi = function (url, data, method) {
            var type = method;
            $.ajax({
                url: url,
                data: data,
                type: method,
                dataType: 'json',
                contentType: 'application/json',
                context: this,
                success: function (result) {
                    if(type === 'post' || type === 'put' || type === 'delete'){
                        $("#message").html(result["mess"]);
                        self.callApi('/rest/V1/well_trained/customer_training/get', {}, 'get');
                    }else{
                        var table = $("<table><tr><th>Id</th><th>Full Name</th><th>Address</th><th>City</th><th>Age</th><th>Action</th></tr>");
                        $.each(result, function( index, value ) {
                            table.append("<tr><td>" + value['id'] + "</td><td>" + value["frist_name"] + " " + value["last_name"] + "</td><td>" + value["address"] + "</td><td>" + value["city"] + "</td><td>" + value["age"] + "</td><td><input type=\"radio\" id='delete-"+value['id']+"' name=\"delete\" value='"+value['id']+"'><label for='delete-"+value['id']+"'>Delete</label></td></tr>");
                        });
                        $("#customer-training").html(table);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        };
        self.callApi('/rest/V1/well_trained/customer_training/get', {}, 'get');
    };
});
