<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="test">
        <input type="text" >
        <input type="submit">
    </form>
    <script>
        document.getElementById('test').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const input = form.querySelector('input[name="message"]');
        const message = input.value.trim();
        }if(message) {
            try {
                const response = await fetch('/api/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        session_id: form.querySelector('input[name="session_id"]').value,
                        message: message
                    })
                });
            }
    })
    </script>
</body>
</html>