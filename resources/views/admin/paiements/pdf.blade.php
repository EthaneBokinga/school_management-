<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Paiements</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4e73df;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #4e73df;
            margin: 0;
            font-size: 20pt;
        }
        
        .info-box {
            background-color: #f8f9fc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 10px;
            background-color: #4e73df;
            color: white;
            border-right: 2px solid white;
        }
        
        .stat-item:last-child {
            border-right: none;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #4e73df;
            color: white;
        }
        
        table th, table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RAPPORT DES PAIEMENTS</h1>
        <p>Année Scolaire {{ $anneeActive->libelle }}</p>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <strong>Total Collecté</strong><br>
            <span style="font-size: 14pt;">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="stat-item">
            <strong>Reste à Collecter</strong><br>
            <span style="font-size: 14pt;">{{ number_format($totalReste, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="stat-item">
            <strong>Nombre de Paiements</strong><br>
            <span style="font-size: 14pt;">{{ $paiements->count() }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Étudiant</th>
                <th>Classe</th>
                <th class="text-right">Montant Payé</th>
                <th class="text-right">Reste</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $paiement->inscription->etudiant->nom_complet }}</strong><br>
                    <small>{{ $paiement->inscription->etudiant->matricule }}</small>
                </td>
                <td>{{ $paiement->inscription->classe->nom_classe }}</td>
                <td class="text-right">{{ number_format($paiement->montant_paye, 0, ',', ' ') }}</td>
                <td class="text-right">{{ number_format($paiement->reste_a_payer, 0, ',', ' ') }}</td>
                <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #f8f9fc; font-weight: bold;">
            <tr>
                <td colspan="3" class="text-right">TOTAUX:</td>
                <td class="text-right">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ number_format($totalReste, 0, ',', ' ') }} FCFA</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Ce document a été généré automatiquement par le système de gestion scolaire.</p>
        <p><em>Confidentiel - Ne pas reproduire sans autorisation</em></p>
    </div>
</body>
</html>