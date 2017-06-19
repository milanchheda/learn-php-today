<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feedback');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeFeedback(Request $request)
    {
        $this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email',
    		'message' => 'required'
    	]);

        Feedback::create($request->all());
        return json_encode(array('status' => 1, 'message' => 'Thank you for your feedback!'));
        // return back()->with('success', 'Thank you for your feedback!');
    }
}
