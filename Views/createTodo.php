<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new todo</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
    <main class="container">
        <h1 class="title">Create new Todo</h1>
        <form class="todo-form" id="createTodoForm" action="/save" method="post">
            <div class="formGroup">
                <label for="title">Title</label>
                <input required type="text" name="title" id="titleCreate">
            </div>
            <div class="formGroup">
                <label for="description">Description</label>
                <textarea required name="description" id="titleDescription" rows="4" ></textarea>                    
            </div>
            <button id="submit" type="submit">Create</button>
            <?php
                if(!empty($_GET["error"]) && $_GET["error"] === "fieldsarerequired"){
                    echo "
                    <p class='form-error'>All the fields are required</p>
                    ";
                }
            ?>
        </form>
    </main>    
</body>
</html>