<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Contact;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::whereIn('id', [8, 9, 10, 11])
            ->where('keyword', '!=', '')
            ->where('answer', '!=', '')
            ->get();

        $contacts = Contact::whereNotNull('answer')->get();

        return view('faq', compact('faqs', 'contacts'));
    }
}