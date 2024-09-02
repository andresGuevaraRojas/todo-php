<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit todo <?php echo $todo->id;?> </title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
    <main class="container">
        <h1 class="title">Edit Todo</h1>
        <form class="todo-form" id="createTodoForm" action="/update" method="post">
            <div class="formGroup">
                <label for="title">Title</label>
                <input  type="text" name="title" id="titleCreate" value="<?php echo $todo->title; ?>">
            </div>
            <div class="formGroup">
                <label for="description">Description</label>
                <textarea  name="description" id="titleDescription" rows="4"><?php echo $todo->description; ?></textarea>                    
            </div>
            <div class="formGroup">
                <label for="status">Status</label>
                <select name="status" id="titleStatus">
                    <option <?php if($todo->status === "PENDING"){echo "selected";} ?> value="PENDING">Pending</option>
                    <option <?php if($todo->status === "IN_PROGRESS"){echo "selected";} ?> value="IN_PROGRESS">In progress</option>
                    <option <?php if($todo->status === "DONE"){echo "selected";} ?> value="DONE">Done</option>
                </select>            
            </div>
            <input value="<?php echo $todo->id?>" name="id" type="hidden"/>
            <button id="submit" type="submit">Edit</button>
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