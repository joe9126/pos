<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <title> Laravel mail Send Syetem </title>

    <style>
        body {
            background-color: #a4a4d0;
        }

        .card {
            width: 500px;
            height: auto;
            min-height: 250px;
            border-radius: 15px;
            background-color: #fff;
            padding: 10px 10px;
            margin: 10px 10px;
            justify-content: flex-start;
            align-items: center;
        }

        /* Inline CSS for table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 5px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #bbb5b5;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body style="background-color: #afafb4; display:flex; justify-content:center; align-items:center;">
    <div
        style=" width: 500px; height: auto; min-height: 250px; border-radius: 5px; background-color: #fff; padding: 30px 30px; margin: auto; margin-top:30px; margin-bottom: 30px;
             justify-content: flex-start;  align-items: center;">
        <h5>Dear Admin,</h5>
        <p>I hope this email finds you well. I'm writing to remind you that restocking is required for the following
            items in our inventory:</p>

        <table style=" width: 100%; border-collapse: collapse; margin: 5px 5px;">
            <thead style="background-color: #a4a4d0;  padding: 8px; border-bottom: 1px solid #ddd;">
                <tr style="padding: 8px; border-bottom: 1px solid #ddd;">
                    <th>No</th>
                    <th>SKU</th>
                    <th>Item description</th>
                    <th>Stock Qty</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $key => $item)
                    <tr style="padding: 8px; border-bottom: 1px solid #ddd;">
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Please review the list above and take necessary actions to replenish the stock to ensure smooth operations.
        </p>

        <h5>Best regards,</h5>
        <h5>{{ Auth::user()->name }}</h5>
    </div>
</body>

</html>
