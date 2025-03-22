<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Task Manager</title>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">  
    <style>  
        body {  
            max-width: 600px;  
            margin: 20px auto;  
        }  
        .task.done {  
            text-decoration: line-through;  
        }  
        .task {  
            display: flex;  
            justify-content: space-between;  
            align-items: center;  
            margin: 5px 0;  
        }  
        .task button {  
            margin-left: 10px;  
        }  
    </style>  
</head>  
<body>  
    <h1>Task Manager</h1>  
    <input type="text" id="task-input" placeholder="Add a new task">  
    <button id="add-task">Add Task</button>  
    <div id="tasks-container"></div>  

    <script>  
        document.getElementById('add-task').onclick = function() {  
            const taskInput = document.getElementById('task-input');  
            const taskText = taskInput.value.trim();  

            if (!taskText) {  
                alert("Task cannot be empty!");  
                return;  
            }  

            const xhttp = new XMLHttpRequest();  
            xhttp.open("POST", "tasks.php?action=add", true);  
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  
            xhttp.send("task=" + encodeURIComponent(taskText));  

            location.reload(); // Reload to refresh the task list  
        };  

        function toggleTask(taskId) {  
            const xhttp = new XMLHttpRequest();  
            xhttp.open("POST", "tasks.php?action=toggle", true);  
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  
            xhttp.send("id=" + taskId);  

            location.reload(); // Reload to refresh the task list  
        }  

        function deleteTask(taskId) {  
            const xhttp = new XMLHttpRequest();  
            xhttp.open("POST", "tasks.php?action=delete", true);  
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  
            xhttp.send("id=" + taskId);  

            location.reload(); // Reload to refresh the task list  
        }  

        function loadTasks() {  
            const xhttp = new XMLHttpRequest();  
            xhttp.onreadystatechange = function() {  
                if (this.readyState == 4 && this.status == 200) {  
                    const tasks = JSON.parse(this.responseText);  
                    const container = document.getElementById('tasks-container');  
                    tasks.forEach(task => {  
                        const taskDiv = document.createElement('div');  
                        taskDiv.classList.add('task');  
                        if (task.done) {  
                            taskDiv.classList.add('done');  
                        }  
                        taskDiv.innerHTML = `  
                            <span onclick="toggleTask(${task.id})">${task.text}</span>  
                            <button onclick="deleteTask(${task.id})">Delete</button>  
                        `;  
                        container.appendChild(taskDiv);  
                    });  
                }  
            };  
            xhttp.open("GET", "tasks.php?action=get", true);  
            xhttp.send();  
        }  

        window.onload = loadTasks;  
    </script>  
</body>  
</html>  