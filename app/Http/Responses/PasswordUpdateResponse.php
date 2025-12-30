<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse as PasswordUpdateResponseContract;

class PasswordUpdateResponse implements PasswordUpdateResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     * 
     * Redirect to custom route with custom status string
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect(route('admin'))->with('status', __('passwords.passwordUpdated'));
    }
}