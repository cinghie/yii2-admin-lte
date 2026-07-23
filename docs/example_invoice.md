Invoice Example
=======================

AdminLTE 2 invoice layout (`section.invoice`).  
API aligned with `cinghie\adminlte3\widgets\Invoice` (CRM / fiscal fields, encoding, no demo data).

```
<?php use cinghie\adminlte\widgets\Invoice; ?>

<?= Invoice::widget([
    'companyName' => 'Acme Inc.',
    'companyLogo' => '<i class="fa fa-globe"></i>', // or image URL
    'invoiceDate' => '23/07/2026',
    'invoiceFromName' => 'Acme Inc.',
    'invoiceFromAddress' => '795 Folsom Ave, Suite 600',
    'invoiceFromAddressInfo' => 'San Francisco, CA 94107',
    'invoiceFromPhone' => '+1 555 000 111',
    'invoiceFromEmail' => 'billing@acme.example',
    'invoiceFromVatCode' => 'IT12345678901',
    'invoiceFromTaxCode' => 'ABCDEF12G34H567I',
    'invoiceFromSdi' => 'XXXXXXX',
    'invoiceFromPec' => 'acme@pec.example',
    'invoiceFromWebsite' => 'https://acme.example',
    'invoiceToName' => 'John Doe',
    'invoiceToAddress' => '221B Baker Street',
    'invoiceToAddressInfo' => 'London',
    'invoiceToPhone' => '+44 20 0000 0000',
    'invoiceToEmail' => 'john@example.com',
    'invoiceToVatCode' => '',
    'invoiceToTaxCode' => '',
    'invoiceNumber' => 'INV-2026-001',
    'invoiceType' => 'TD01',
    'invoiceOrderID' => 'ORD-9988',
    'invoicePaymentDue' => '30/07/2026',
    'invoicePaid' => '',
    'invoiceSent' => '23/07/2026',
    'invoiceAccount' => 'ACCT-1234',
    'invoicePaymentMethod' => 'Bank transfer',
    'invoicePaymentMethodCode' => 'MP05',
    'invoiceNotes' => "Payment within 7 days.\nThank you.",
    'invoiceItems' => [
        [
            'product' => 'Service A',
            'serial' => 'SKU-001',
            'description' => 'Monthly support',
            'product_price' => '€50.00',
            'quantity' => 2,
            'subtotal' => '€100.00',
        ],
        [
            'description' => 'License B',   // used as product if "product" empty
            'serial' => 'SKU-002',
            'unit_price' => '€200.00',
            'qty' => 1,
            'amount' => '€200.00',
        ],
    ],
    'invoiceSubtotal' => '€300.00',
    'invoiceTax' => '€66.00',
    'invoiceTaxLabel' => '22%',
    'invoiceShipping' => '',
    'invoiceTotal' => '€366.00',
    'showActions' => true,
    'printUrl' => null,                 // null → javascript:window.print()
    'pdfUrl' => ['/invoice/pdf', 'id' => 1],
]) ?>
```

## Line item keys

| Key | Aliases |
|-----|---------|
| product | falls back to `description` |
| description / detail | detail column |
| serial | |
| product_price | `unit_price`, `price` |
| quantity | `qty` |
| subtotal | `amount` |

Use `Invoice::normalizeItem($row)` to normalize a single item array.

## Notes

- Empty properties are omitted (no AdminLTE demo filler).
- Text is HTML-encoded; `companyLogo` accepts an image URL or a single `<i class="…">` icon.
- Labels use `Yii::t('traits', …)` / `Yii::t('crm', …)` where available.
