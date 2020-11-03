<?php

namespace App\Http\Controllers;

use App\Jobs\ContactFormJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactFormRequest;

/**
 * Class ContactController
 * Handles all contact form requests
 *
 * @author  Dylan Millikin <dylan.millikin@gmail.com>
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    /**
     * Basic contact form request.
     * Request has already been validated in ContactFormRequest
     *
     * @param ContactFormRequest $request
     *
     * @return JsonResponse
     */
    public function contact(ContactFormRequest $request)
    {
        // save the form data to DB. $request is already validated via ContactFormRequest
        $contact = Contact::create($request->all());

        //dispatch the mailing job
        $this->dispatchNow(new ContactFormjob($contact));

        // if the form was submitted via ajax, return an appropriate JSON
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        // if javascript is disabled, lets offer a fallback for graceful degradation.
        return view('success');
    }
}
