<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Mensuel - FitTrack Pro</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4361ee;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4361ee;
        }
        
        .title {
            font-size: 28px;
            margin: 10px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #4361ee;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: #4361ee;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">FitTrack Pro</div>
        <div class="title">Rapport Mensuel</div>
        <div>{{ $user->name }}</div>
        <div>{{ $monthStart->format('d/m/Y') }} - {{ $monthEnd->format('d/m/Y') }}</div>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_workouts'] }}</div>
            <div class="stat-label">Séances</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_exercises'] }}</div>
            <div class="stat-label">Exercices différents</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['total_weight']) }} kg</div>
            <div class="stat-label">Poids total soulevé</div>
        </div>
    </div>
    
    <h3>Détail des séances</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Exercice</th>
                <th>Séries</th>
                <th>Répétitions</th>
                <th>Poids (kg)</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performances as $perf)
            <tr>
                <td>{{ \Carbon\Carbon::parse($perf->date)->format('d/m/Y') }}</td>
                <td>{{ $perf->exercise->name }}</td>
                <td>{{ $perf->sets_completed }}</td>
                <td>{{ $perf->reps_completed }}</td>
                <td>{{ $perf->weight_used ?? '-' }}</td>
                <td>
                    @if($perf->duration_seconds)
                        {{ floor($perf->duration_seconds / 60) }}min {{ $perf->duration_seconds % 60 }}s
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Rapport généré le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
        <p>FitTrack Pro - Votre compagnon d'entraînement</p>
    </div>
</body>
</html>