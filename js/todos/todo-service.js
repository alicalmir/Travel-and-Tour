$(document).ready(function() {
    // Load todos on page load
    loadTodos();

    // Submit the form to add a new todo
    $('#addTodoForm').submit(function(event) {
        event.preventDefault();

        var todo = {
            title: $('#todoTitle').val(),
            description: $('#todoDescription').val()
        };

        addTodoAJAX(todo);
    });

    // Handle click event on todo checkbox to mark as completed
    $(document).on('click', 'li', function() {
        var todoId = $(this).data('id');
        toggleTodoAJAX(todoId);
    });
});

function loadTodos() {
    $.ajax({
        url: 'https://bookingtrips-b98c7c869cca.herokuapp.com/todos',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            displayTodos(response.todos);
        },
        error: function() {
            alert('Error loading todos.');
        }
    });
}

function displayTodos(todos) {
    var todoList = $('#todoList');
    todoList.empty();

    for (var i = 0; i < todos.length; i++) {
        var todo = todos[i];

        // Create todo card
        var todoCard = $('<div class="todo-card"></div>');
        var title = $('<h3></h3>').text(todo.title);
        var description = $('<p></p>').text(todo.description);

        todoCard.append(title, description);

        if (todo.completed) {
            todoCard.addClass('completed');
        }

        todoList.append(todoCard);
    }
}


function addTodoAJAX(todo) {
    $.ajax({
        url: 'https://bookingtrips-b98c7c869cca.herokuapp.com/add_todo',
        type: 'POST',
        data: todo,
        dataType: 'json',
        success: function(response) {
            loadTodos();
            $('#todoTitle').val('');
            $('#todoDescription').val('');
        },
        error: function() {
            alert('Error adding todo.');
        }
    });
}

function toggleTodoAJAX(todoId) {
    $.ajax({
        url: '/todos/' + todoId,
        type: 'PUT',
        dataType: 'json',
        success: function(response) {
            loadTodos();
        },
        error: function() {
            alert('Error toggling todo.');
        }
    });
}
