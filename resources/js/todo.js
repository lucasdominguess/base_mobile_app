// extracted script from welcome.blade.php
async function saveName() {
    const name = document.getElementById('nameInput').value.trim();
    if (!name) {
        alert('Please enter a name');
        return;
    }

    try {
        const response = await fetch('/api/save_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name })
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Server error');
        alert(data.message);
        document.getElementById('nameInput').value = '';
    } catch (error) {
        alert('Request failed: ' + error.message);
    }
}
async function loadNames() {
    try {
        const response = await fetch('/api/list_users', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Server error');
        const list = document.getElementById('todoList');
        list.innerHTML = '';
        data.items.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name;
            list.appendChild(li);
        });
    } catch (error) {
        alert('Request failed: ' + error.message);
    }
}

async function deleteAllNames() {
    try {
        const response = await fetch('/api/delete_all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Server error');
        alert(data.message);

    } catch (error) {
        alert('Request failed: ' + error.message);
    }
}
async function vibrateDeviceTest() {
            try {
            const response = await fetch('/api/test_vibration', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Server error');
            }

            alert(data.message);

        } catch (error) {
            alert('Request failed: ' + error.message);
        }
    }

async function logTelegram() {
    try {
        const response = await fetch('/api/test_log_telegram', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Server error');
        alert(data.message);
    } catch (error) {
        alert('Request failed: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveBtn').addEventListener('click', saveName);
    document.getElementById('loadBtn').addEventListener('click', loadNames);
    document.getElementById('deleteAllBtn').addEventListener('click', deleteAllNames);
    document.getElementById('vibrateBtn').addEventListener('click', vibrateDeviceTest);
    document.getElementById('logBtn').addEventListener('click', logTelegram);

});




