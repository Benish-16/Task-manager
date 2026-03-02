@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Task #{{ $task->id }} - {{ $task->title }}</title>
<style>
    body {
        font-family: DejaVu Sans, Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: white;
        color: #2f3640;
    }

    .page {
        padding: 32px;
    }

    .container {
        width: 100%;
        background: #ffffff;
        padding: 32px 32px 26px;
        border-radius: 14px;
        box-sizing: border-box;
        border: 1px solid #e5e8ef;
    }



    .header {
        margin-bottom: 28px;
        padding-bottom: 14px;
        border-bottom: 2px solid #eef1f6;
    }

    .header h1 {
        font-size: 26px;
        margin: 0;
        color: #1e3799;
        font-weight: 700;
    }

    .header small {
        color: #8395a7;
        font-size: 12px;
    }

 

    .task-info {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .info-box {
        width: 48%;
        background:white;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid #edf0f6;
        box-sizing: border-box;
        margin-top:10px;
        padding-top: 5px;
    }

    .label {
        font-size: 11px;
        font-weight: 600;
        color: #8395a7;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .value {
        font-size: 15px;
        color: #2f3640;
        font-weight: 600;
    }



    .status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        color: #ffffff;
        font-weight: 700;
        font-size: 12px;
        text-transform: capitalize;
    }

    .status-pending {
        background-color: #718093;
    }

    .status-in_progress {
        background-color: #f39c12;
    }

    .status-completed {
        background-color: #2ecc71;
    }

  

    .task-description {
        background: white;
        padding: 18px ;
        border-radius: 12px;
        border: 1px solid #edf0f6;
        padding-top:5px;
    }

    .task-description .label {
        font-size: 13px;
        color: #1e3799;
        margin-bottom: 10px;
    }

    .task-description .value {
        font-size: 14px;
        line-height: 1.7;
        color: #353b48;
        font-weight: 500;
    }



    .footer {
        margin-top: 32px;
        padding-top: 12px;
        text-align: center;
        font-size: 11px;
        color: #8395a7;
        border-top: 1px solid #edf0f6;
    }
</style>
</head>
<body>
<div class="page">
    <div class="container">

        <h1>{{ $task->title }}</h1>

        <div class="task-info">

            <div class="info-box">
                <div class="label">Status</div>
                <div class="value">
                    <span class="status status-{{ $task->status }}">
                        {{ ucfirst(str_replace('_',' ',$task->status)) }}
                    </span>
                </div>
            </div>

            <div class="info-box">
                <div class="label">Priority</div>
                <div class="value">{{ ucfirst($task->priority) }}</div>
            </div>

            <div class="info-box">
                <div class="label">Assigned To</div>
                <div class="value">{{ $task->assignedUser->name ?? 'N/A' }}</div>
            </div>

            <div class="info-box">
                <div class="label">Created By</div>
                <div class="value">{{ $task->creator->name ?? 'N/A' }}</div>
            </div>

            <div class="info-box">
                <div class="label">Due Date</div>
                <div class="value">
                    {{ $task->due_date ? Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Created At</div>
                <div class="value">
                    {{ $task->created_at ? Carbon::parse($task->created_at)->format('d M Y') : 'N/A' }}
                </div>
            </div>

        </div>

        <div class="task-description">
            <div class="label">Description</div>
            <div class="value">
                {{ $task->description ?? 'No description provided.' }}
            </div>
        </div>

        <div class="footer">
            Generated on {{ now()->format('d M Y H:i') }}
        </div>

    </div>
</div>
</body>
</html>