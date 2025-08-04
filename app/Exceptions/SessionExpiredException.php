<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SessionExpiredException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): RedirectResponse
    {
        // Clear any existing session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect to login with message
        return redirect()->guest(route('login'))
            ->with('status', 'Your session has expired. Please login again.');
    }
}
