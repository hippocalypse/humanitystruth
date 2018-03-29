<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
    
    public function verify(Request $request) {
        //throttle
        //validate? or just get?
        //null column if it exists in our database and send approval notification
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd("HERE");
        //throttle
        $this->validate($request, [
            'subscribe' => 'required|string|email|max:255|unique:users'
        ]);
        
        $subscription = NewsletterSubscription::create([
            'email', $request->subscribe
        ]);
        
        dispatch(new SendNewsletterVerificationEmail($subscription));

        return json_encode(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //throttle
        //validation and auth check
        //destroy their subscription
    }
}
