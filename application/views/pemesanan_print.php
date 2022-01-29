<script>
    window.print();
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table width="100%" style="text-align:left;font-size: 18px;">
        <?php foreach ($header['data'] as $row) : ?>
            <tr>
                <th width="15%;">Kode&nbsp;Pemesanan</th>
                <th width="5%">:</th>
                <th><?= $row->kode_pesan ?></th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>:</th>
                <th><?= $row->tanggal ?></th>
            </tr>
            <tr>
                <th>Nama&nbsp;Toko</th>
                <th>:</th>
                <th><?= $row->nama ?></th>
            </tr>
            <tr>
                <th>Keterangan</th>
                <th>:</th>
                <th><?= $row->keterangan ?></th>
            </tr>
        <?php endforeach ?>
    </table>
    <br><br>
    <table width="100%" border="1" style="text-align:left;font-size: 15px;">
        <thead>
            <tr>
                <th>Nama&nbsp;Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="3">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
            </tr>
            <?php
            $grandTotal = 0;
            foreach ($detail['data'] as $row) :
                $grandTotal = $grandTotal + $row->total
                ?>
                <tr>
                    <td><?= $row->barang ?></td>
                    <td><?= $row->jumlah ?></td>
                    <td><?= "Rp " . number_format($row->harga, 0, ',', '.'); ?></td>
                    <td><?= "Rp " . number_format($row->total, 0, ',', '.'); ?></td>
                    <td><?= $row->keterangan ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th colspan="3">Grand Total</th>
                <th colspan="2"><?= "Rp " . number_format($grandTotal, 0, ',', '.'); ?></th>
            </tr>
            </tr>
        </tfoot>
    </table>
</body>

</html>