<?php
require "utils.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Todos</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">My Todo List</h1>
        <a class="add-new-todo" href="/create">Add new todo</a>
        <main class="todos-container">
            <section class="todos" id="todos">
            <?php                
                foreach ($todos as $todo) {
                    $status = getTodoStatus($todo);
                    $classStatus = getClassNameStatus($todo);
                    echo("                        
                        <details class='todo'>
                            <summary class='card-header'>
                                <div class='todo-title-container'>
                                    <span class='card-title todo-title'>$todo->title</span>
                                    <span class='todo-status $classStatus'>$status</span>
                                </div>
                                <div class='card-actions'>
                                    <a class='todo-action' href='/edit?id=$todo->id'>Edit</a>
                                    <form action='/delete' method='post'>
                                        <button type='submit' class='todo-action'>Delete</button>
                                        <input value='$todo->id' name='id' type='hidden'/>
                                    </form>                                    
                                </div>                            
                            </summary>
                            <div class='card-body'>
                                <p>$todo->description</p>
                            </div>                            
                        </details>                                    
                    ");
                }
            ?>
            </section>            
        </main>
    </div>
</body>
</html>