<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <style>
        @page {
            margin: 2cm;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4e73df;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4e73df;
            margin: 0;
            font-size: 24pt;
        }
        
        .header h2 {
            color: #666;
            margin: 5px 0;
            font-size: 14pt;
        }
        
        .info-section {
            background-color: #f8f9fc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .info-label {
            display: table-cell;
            width: 40%;
            font-weight: bold;
            color: #4e73df;
        }
        
        .info-value {
            display: table-cell;
            width: 60%;
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
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        
        .moyenne-cell {
            font-weight: bold;
            font-size: 12pt;
        }
        
        .moyenne-success {
            color: #1cc88a;
        }
        
        .moyenne-danger {
            color: #e74a3b;
        }
        
        .appreciation {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            display: inline-block;
        }
        
        .appreciation-tb {
            background-color: #1cc88a;
            color: white;
        }
        
        .appreciation-b {
            background-color: #36b9cc;
            color: white;
        }
        
        .appreciation-ab {
            background-color: #4e73df;
            color: white;
        }
        
        .appreciation-p {
            background-color: #f6c23e;
            color: white;
        }
        
        .appreciation-i {
            background-color: #e74a3b;
            color: white;
        }
        
        .summary-box {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        
        .summary-box h3 {
            margin: 0 0 10px 0;
            font-size: 16pt;
        }
        
        .summary-box .moyenne-generale {
            font-size: 32pt;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }
        
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 60%;
            margin: 40px auto 5px auto;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <h1>BULLETIN DE NOTES</h1>
        <h2>Année Scolaire {{ $anneeActive->libelle }}</h2>
    </div>

    <!-- Informations de l'élève -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nom et Prénom:</div>
            <div class="info-value">{{ $etudiant->nom_complet }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Matricule:</div>
            <div class="info-value">{{ $etudiant->matricule }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Classe:</div>
            <div class="info-value">{{ $inscription->classe->nom_classe }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date de naissance:</div>
            <div class="info-value">{{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : '-' }}</div>
        </div>
    </div>

    <!-- Notes par matière -->
    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th style="text-align: center;">Coefficient</th>
                <th style="text-align: center;">Moyenne</th>
                <th style="text-align: center;">Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPoints = 0;
                $totalCoefficients = 0;
            @endphp
            
            @foreach($moyennesParMatiere as $matiere => $data)
                @php
                    $moyenne = $data['moyenne'];
                    $coefficient = $data['coefficient'];
                    $totalPoints += $moyenne * $coefficient;
                    $totalCoefficients += $coefficient;
                    
                    if($moyenne >= 16) {
                        $appreciation = 'Très Bien';
                        $appreciationClass = 'appreciation-tb';
                    } elseif($moyenne >= 14) {
                        $appreciation = 'Bien';
                        $appreciationClass = 'appreciation-b';
                    } elseif($moyenne >= 12) {
                        $appreciation = 'Assez Bien';
                        $appreciationClass = 'appreciation-ab';
                    } elseif($moyenne >= 10) {
                        $appreciation = 'Passable';
                        $appreciationClass = 'appreciation-p';
                    } else {
                        $appreciation = 'Insuffisant';
                        $appreciationClass = 'appreciation-i';
                    }
                @endphp
                
                <tr>
                    <td><strong>{{ $matiere }}</strong></td>
                    <td style="text-align: center;">{{ $coefficient }}</td>
                    <td style="text-align: center;" class="moyenne-cell {{ $moyenne >= 10 ? 'moyenne-success' : 'moyenne-danger' }}">
                        {{ number_format($moyenne, 2) }}/20
                    </td>
                    <td style="text-align: center;">
                        <span class="appreciation {{ $appreciationClass }}">{{ $appreciation }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Moyenne générale -->
    <div class="summary-box">
        <h3>MOYENNE GÉNÉRALE</h3>
        <div class="moyenne-generale">{{ number_format($moyenneGenerale, 2) }}/20</div>
        <p style="margin: 5px 0;">
            @if($moyenneGenerale >= 16)
                Mention: TRÈS BIEN
            @elseif($moyenneGenerale >= 14)
                Mention: BIEN
            @elseif($moyenneGenerale >= 12)
                Mention: ASSEZ BIEN
            @elseif($moyenneGenerale >= 10)
                Mention: PASSABLE
            @else
                Mention: INSUFFISANT
            @endif
        </p>
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Le Directeur</strong></p>
            <div class="signature-line"></div>
        </div>
        <div class="signature-box">
            <p><strong>Le Parent/Tuteur</strong></p>
            <div class="signature-line"></div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Bulletin généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p><em>Ce document est confidentiel et ne peut être reproduit sans autorisation.</em></p>
    </div>
</body>
</html>