<?php

namespace App\Services;

use App\Interfaces\Services\AccountInterface;
use App\Jobs\SendTransactionNotification;
use App\Utils\StorageUtils;
use PDF;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\String\b;

class AccountService implements AccountInterface
{
    // Protected variable context
    protected $service;
    protected $domPDF;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(PDF $domPDF)
    {
        $this->domPDF = $domPDF;
    }

    /**
     * Make a debit operation from account
     * @param App/Account $account
     * @param Decimal $balance
     * @return void
     */
    public function debit($account, $balance)
    {
        $account->balance -= $balance;
        $account->save();
    }

    /**
     * Make a credit operation for account
     * @param App/Account $account
     * @param Decimal $balance
     * @return void
     */
    public function credit($account, $balance)
    {
        $account->balance += $balance;
        $account->save();
    }

    /**
     * Send a notification to user
     * @param App/Extract $extract
     * @return Job 
     */
    public function notifyUser($extract)
    {
        $transaction = $extract->transaction()->first();
        $sourceAccount = $extract->sourceAccount()->first();
        $sourceAccountPerson = null;
        $sourceAccountUser = null;

        if ($sourceAccount) {
            $sourceAccountPerson = $sourceAccount->person()->first();
            $sourceAccountUser = $sourceAccountPerson->user()->first();
        }

        $destinationAccount =  $extract->destinationAccount()->first();
        $destinationAccountPerson = null;
        $destinationAccountUser = null;

        if ($destinationAccount) {
            $destinationAccountPerson =  $destinationAccount->person()->first();
            $destinationAccountUser =  $destinationAccountPerson->user()->first();
        }

        $pdf = PDF::loadView('notification', [
            'extract'                  => $extract,
            'sourceAccount'            => $sourceAccount,
            'sourceAccountPerson'      => $sourceAccountPerson,
            'sourceAccountUser'        => $sourceAccountUser,
            'destinationAccount'       => $destinationAccount,
            'destinationAccountPerson' => $destinationAccountPerson,
            'destinationAccountUser'   => $destinationAccountUser,
            'transaction'              => $transaction
        ]);

        $fileName = StorageUtils::defineFileName();
        $storagePathToSave = $fileName . ".pdf";

        $pdf->setPaper('a4', 'landscape')->setWarnings(false);
        $content = $pdf->download()->getOriginalContent();

        Storage::disk('local')->put($storagePathToSave, $content);
        $url = Storage::url($storagePathToSave);

        return SendTransactionNotification::dispatch($url);
    }
}
