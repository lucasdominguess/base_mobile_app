<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/todo.css', 'resources/js/todo.js'])
</head>
<body>
    <div class="app-container">
        <h1 class="app-title">Todo List</h1>

        <div class="input-group">
            <input type="text" id="nameInput" class="todo-input" placeholder="Enter name">
            <button id="saveBtn" class="btn btn-primary">Save</button>
        </div>

        <button id="loadBtn" class="btn btn-secondary">Load Saved Names</button>

        <ul id="todoList" class="todo-list">

        </ul>

        <hr class="divider">

        <div id="div-btns">

            <button id="vibrateBtn" class="btn btn-action">Test Device Vibration API</button>

            <button id="logBtn" class="btn btn-action">Test Log Telegram</button>

            <button id="deleteAllBtn" class="btn btn-action">Delete All</button>
        </div>
    </div>

    </body>
