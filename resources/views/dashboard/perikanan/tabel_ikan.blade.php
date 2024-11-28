<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perikanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Perikanan</h1>
        <p>Informasi mengenai perkiraan harga ikan terkini</p>
        <a href="{{ route('dashboard') }}">Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Ikan</th>
                    <th>Jumlah (kg)</th>
                    <th>Harga/kg (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ikan Nila</td>
                    <td>500</td>
                    <td>25,000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Ikan Lele</td>
                    <td>350</td>
                    <td>20,000</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Ikan Mas</td>
                    <td>400</td>
                    <td>30,000</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Ikan Gurame</td>
                    <td>250</td>
                    <td>40,000</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
