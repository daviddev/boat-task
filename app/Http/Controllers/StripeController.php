<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stripe\StripeCheckoutRequest;
use App\Models\Boat;
use App\Repositories\UserRepository;
use Laravel\Cashier\Checkout;
use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
use Laravel\Cashier\Exceptions\InvalidCustomer;

class StripeController extends Controller
{
    /**
     * StripeController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(private UserRepository $userRepository)
    {
        //
    }

    /**
     * Stripe single charge checkout.
     *
     * @param StripeCheckoutRequest $request
     * @param Boat $boat
     * @return Checkout
     * @throws CustomerAlreadyCreated
     */
    public function chargeCheckout(StripeCheckoutRequest $request, Boat $boat): Checkout
    {
        $validated = $request->validated();
        $user = $this->userRepository->getUserByEmail($validated['email']);
        if (!$user) {
            $user = $this->userRepository->createUser($validated);
        }
        try {
            $user->asStripeCustomer();
        } catch (InvalidCustomer $e) {
            $user->createAsStripeCustomer(
                ['email' => $user->email]
            );
        }

        return $user->checkoutCharge($boat->price * 100, 'Boat Product', 1, [
            'success_url' => url("/show/{$boat->id}"),
            'cancel_url' => url("/show/{$boat->id}"),
        ]);
    }
}
