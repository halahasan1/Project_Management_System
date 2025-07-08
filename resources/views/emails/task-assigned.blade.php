<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Task Assigned</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f9fc; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

        <h2 style="color: #2c3e50; text-align: center;">📌 You Have a New Task!</h2>

        <hr style="border: none; border-top: 1px solid #e1e4e8; margin: 20px 0;">

        <p><strong>📝 Task Name:</strong> {{ $task->name }}</p>
        <p><strong>📄 Description:</strong> {{ $task->description ?? 'No description provided.' }}</p>
        <p><strong>⏰ Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}</p>

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ url('/tasks/' . $task->id) }}" style="background-color: #3498db; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">View Task</a>
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #999; text-align: center;">
            This is an automated message. Please do not reply.
        </p>
    </div>

</body>
</html>
