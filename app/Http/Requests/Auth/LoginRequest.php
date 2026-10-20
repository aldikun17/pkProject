<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey()); //records/counts login failed attempts

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) { //  
            return; //return none if under 5 attempts
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey()); //calculate how many seconds remains until the lockout expires. 

        throw ValidationException::withMessages([ //laravel error exception
            'email' => trans('auth.throttle', [ //gets the error from throttle
                'seconds' => $seconds, //gets the seconds
                'minutes' => ceil($seconds / 60), //converts total seconds into minutes, rounded up to the nearest whole number.

            ]),
        ]);
    }


    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
        /*Email will be converted into lowercase and retrives the ip address
         if user email is JAYBUGS22@GMAIL.COM will convert it to  jaybugs22@gmail.com
         so: jaybugs22@gmail.com|192........
        */


        /*
          Str::transliterate() replaces non-Latin special characters or accented letters with standard ASCII equivalents (for example, converting é to e or ñ to n).How throttleKey() pieces it all together:$this->string('email'): Gets the email entered by the user.Str::lower(...): Turns all letters into lowercase (USER@domain.com $\rightarrow$ user@domain.com).

          Str::transliterate(...): Removes special accents/diacritics (üsér@domain.com $\rightarrow$ user@domain.com)..$this->ip(): Retrieves the client's incoming IP address (e.g., 192.168.1.50) and glues it to the end with a |.
        */
    }
}
