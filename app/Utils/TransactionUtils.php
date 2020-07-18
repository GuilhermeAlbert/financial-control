<?php

namespace App\Utils;

/*
 * Transactions utils
 *
 * Use method: TransactionUtils::DEBIT;
 */

class TransactionUtils
{
    /**
     * Transactions IDs
     */
    const DEBIT    = 1;
    const CREDIT   = 2;
    const TRANSFER = 3;

    /**
     * Transactions keys
     */
    const DEBIT_KEY    = "debit";
    const CREDIT_KEY   = "credit";
    const TRANSFER_KEY = "transfer";
}
