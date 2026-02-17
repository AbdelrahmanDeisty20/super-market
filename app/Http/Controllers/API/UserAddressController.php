<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Http\Resources\API\UserAddressResource;
use App\Models\UserAddress;
use App\Service\UserAddressService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    use ApiResponse;

    protected $addressService;

    public function __construct(UserAddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Display a listing of the user's addresses.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $addresses = $this->addressService->getUserAddresses($request->user());
        $message = $addresses->isEmpty() ? __('messages.No addresses found yet') : __('messages.Addresses fetched successfully');
        return $this->success(UserAddressResource::collection($addresses), $message);
    }

    /**
     * Store a newly created address.
     *
     * @param UserAddressRequest $request
     * @return JsonResponse
     */
    public function store(UserAddressRequest $request): JsonResponse
    {
        $address = $this->addressService->storeAddress($request->user(), $request->validated());
        return $this->success(new UserAddressResource($address), __('messages.Address stored successfully'), 201);
    }

    /**
     * Display the specified address.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        $address = UserAddress::where('user_id', $request->user()->id)->findOrFail($id);
        return $this->success(new UserAddressResource($address), __('messages.Address fetched successfully'));
    }

    /**
     * Update the specified address.
     *
     * @param UserAddressRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserAddressRequest $request, $id): JsonResponse
    {
        $address = UserAddress::where('user_id', $request->user()->id)->findOrFail($id);
        $address = $this->addressService->updateAddress($address, $request->validated());
        return $this->success(new UserAddressResource($address), __('messages.Address updated successfully'));
    }

    /**
     * Remove the specified address.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $address = UserAddress::where('user_id', \auth()->id())->findOrFail($id);
        $this->addressService->deleteAddress($address);
        return $this->success([], \__('messages.Address deleted successfully'));
    }

    public function deleteAll(Request $request): JsonResponse
    {
        $this->addressService->deleteAllAddresses($request->user());
        return $this->success([], \__('messages.All addresses deleted successfully'));
    }
}
