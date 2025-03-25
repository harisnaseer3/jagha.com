@extends('layouts.app')
@section('content')
    <style>
        .backup-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: linear-gradient(to right, #fcd454, #b79c35);
        }
        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            background: linear-gradient(to right, #fcd454, #b79c35);
            border: none;
            margin-bottom: 10px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
            border: none;
        }
        .btn-success {
            background: #28a745;
            color: white;
            border: none;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
        }
    </style>
    <div class="backup-container">
        <h2>Database Backups</h2>
        <form action="{{ route('backups.create') }}" method="POST">
            @csrf
            <button type="submit" class="mb-3 btn theme-blue">Create Backup Now</button>
        </form>
        <table class="table mt-3 theme-blue">
            <thead>
            <tr class="theme-blue">
                <th>Date</th>
                <th>Filename</th>
                <th>Filesize</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($backupFiles as $backup)
                <tr>
                    <td>{{ $backup['date'] }}</td>
                    <td>{{ $backup['filename'] }}</td>
                    <td>{{ $backup['filesize'] }}</td>
                    <td>
                        <form action="{{ route('backups.restore', $backup['filename']) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Restore</button> <!--🔄 -->
                        </form>
                        <form action="{{ route('backups.delete', $backup['filename']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button> <!--❌ -->
                        </form>
                        <a href="{{ route('backups.download', $backup['filename']) }}" class="btn btn-primary">Download</a> <!-- ⬇ -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
