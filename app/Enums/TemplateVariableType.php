<?php

namespace App\Enums;

use App\Helpers\AppHelper;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Language;
use App\Models\Order;
use BenSampo\Enum\Enum;

class TemplateVariableType extends Enum
{
    /** ORDER **/
    const ORDER_ID = 'ORDER_ID';

    const ORDER_STATUS = 'ORDER_STATUS';

    const CLIENT_NAME = 'CLIENT_NAME';

    const ORDER_AGENT = 'ORDER_AGENT';

    /** EXPENSE **/
    const EXPENSE_ID = 'EXPENSE_ID';

    const ASSOCIATION_NAME = 'ASSOCIATION_NAME';

    /** INVOICE **/
    const INVOICE_ID = 'INVOICE_ID';

    public static function getTemplateVariablesList(Order $order): array
    {
        return [
            self::ORDER_ID => $order->id,
            self::ORDER_STATUS => $order->status,
            self::INVOICE_ID => '',
            self::CLIENT_NAME => $order->customer ? $order->customer->name : ' ',
            self::ORDER_AGENT => $order->agent ? $order->agent->name : ' ',
        ];
    }

    public static function getTemplateVariablesListExpense(Expense $expense): array
    {
        $lang = Language::whereCode(AppHelper::getLanguageForMobile())->first()->id;
        if ($lang == 'ar')
            $title = $expense->association->meta['translate']['title_ar'];
        else
            $title = $expense->association->meta['translate']['title_en'];

        return [
            self::EXPENSE_ID => $expense->id,
            self::INVOICE_ID => '',
            self::ASSOCIATION_NAME => $title,
            self::ORDER_ID => '',
            self::ORDER_STATUS => '',
            self::CLIENT_NAME => '',
            self::ORDER_AGENT => '',
        ];
    }

    public static function getTemplateVariablesListInvoice(Invoice $invoice): array
    {
        return [
            self::INVOICE_ID => $invoice->id,
            self::EXPENSE_ID => '',
            self::ASSOCIATION_NAME => '',
            self::ORDER_ID => $invoice->order->id,
            self::ORDER_STATUS => $invoice->order->status ?? ' ',
            self::CLIENT_NAME => $invoice->order->customer?->name ?? ' ',
            self::ORDER_AGENT => $invoice->order->agent?->name ?? ' ',
        ];
    }
}
