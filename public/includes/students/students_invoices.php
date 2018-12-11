<table class='user_invoices'>
    <thead>
    <tr>
        <th class="note">Rechn.Nr.</th>
        <th class="note">Preis</th>
        <th class="note">Erstellt</th>
        <th class="note">Bezahlt</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (\src\helpers\Helper::getAjaxData("invoices") as $k => $v) : ?>
        <tr>
            <td><a target='_blank' href='invoices/<?= $v['invoice_path'] ?>'><?= $v['invoice_number'] ?></a></td>
            <td><?= $v['invoice_total'] ?></td>
            <td><?= date('d.m.Y - H:i', strtotime($v['invoice_created'])) ?></td>
            <td><?= (strtotime($v['invoice_paydate']) != 0) ? date('d.m.Y - H:i', strtotime($v['invoice_paydate'])) : "offen" ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>