<?php

namespace App\Mail;

use App\Models\Setting;
use App\Models\BatchStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice 	= $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->view('view.name');
        $settings = Setting::first();
        $batchStudent       = BatchStudent::with('batch','payments','batch_fee')->find($this->invoice['student_enrollment_id']);
       
        $invoiceDetails['actual_fees']   = $batchStudent->batch->fees;
        $invoiceDetails['total_payable'] = $batchStudent->total_payable;
        $invoiceDetails['discount']      = ($invoiceDetails['actual_fees']>$invoiceDetails['total_payable'])?($invoiceDetails['actual_fees']-$invoiceDetails['total_payable']):0;
        $invoiceDetails['total_paid']   = $batchStudent->total_paid;
        $invoiceDetails['balance']       = $batchStudent->balance;        
        $invoiceDetails['payments']      = $batchStudent->payments;
       // dd($invoiceDetails);
        return $this->subject($settings['company_name'].' payment invoice')
            ->markdown('mails.payment-invoice')
            ->with([
                'invoice' => $this->invoice,
                'settings' => $settings,
                'invoiceDetails'=>$invoiceDetails
            ]);
    }
}
