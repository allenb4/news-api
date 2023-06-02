<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Http\Requests\User\UserPreferenceRequest;

class UserPreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->preferences()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserPreferenceRequest $request)
    {
        foreach ($request->input('preferences') as $preference) {
            UserPreference::updateOrCreate(
                ['user_id' => $request->user()->id, 'key' => $preference['key']],
                ['value' => $preference['value']]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => __('general.action_success', ['model' => 'User preference', 'action' => 'updated'])
        ]);
    }
}
