<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .box { border: 1px solid #eee; padding: 30px; }
        .title { color: #f97316; font-size: 28px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f8f8; padding: 10px; text-align: left; border-bottom: 2px solid #eee; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
<div class="box">
    <div class="title">ISI BURGER</div>
    <p>Facture N° : <strong>#{{ $commande->id }}</strong></p>
    <p>Client : {{ $commande->user->name }}</p>
    <p>Date : {{ $commande->created_at->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
        <tr>
            <th>Désignation</th>
            <th>Qté</th>
            <th>Prix</th>
        </tr>
        </thead>
        <tbody>
        @foreach($commande->burgers as $burger)
            <tr>
                <td>{{ $burger->nom }}</td>
                <td>{{ $burger->pivot->quantite }}</td>
                <td>{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total">TOTAL : {{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
</div>
</body>
</html>
