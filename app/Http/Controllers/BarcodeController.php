<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarcodeRequest;
use App\Models\Barcode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BarcodeController extends ApiBaseController
{
    /**
     * @param BarcodeRequest $request
     * @return JsonResponse
     */
    public function store(BarcodeRequest $request): JsonResponse
    {
        $barcode = Barcode::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

        if ($barcode instanceof Barcode) {
            return $this->sendResponse('Success on create Barcode.', status_code: Response::HTTP_CREATED);
        }

        return $this->sendErrorResponse(
            'Failed on create Barcode.',
            status_code: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * @param Request $request
     * @param int|null $payer_id
     * @return JsonResponse
     */
    public function index(Request $request, ?int $payer_id = null): JsonResponse
    {
        $baseQuery = Barcode::where('user_id', Auth::user()->id);

        if ($column = $request->get('order_by')) {
            if ((new Barcode())->isFillable($column)) {
                $baseQuery->orderBy($column);
            }
        }

        if ($payer_id !== null) {
            $baseQuery->where('payer_id', $payer_id);
        }

        if (!(($barcodes = $baseQuery->get()) instanceof Collection)) {
            return $this->sendErrorResponse(
                'Failed on retrieve Barcodes.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->sendResponse('Success on retrieve Barcodes', $barcodes);
    }

    /**
     * @param BarcodeRequest $request
     * @param int $barcode_id
     * @return JsonResponse
     */
    public function update(BarcodeRequest $request, int $barcode_id): JsonResponse
    {
        if (!(($barcode = Auth::user()->barcodes()->where('id', $barcode_id)->first()) instanceof Barcode)) {
            return $this->sendErrorResponse('Barcode not found for authenticated User.');
        }

        if (!$barcode->update($request->validated())) {
            return $this->sendErrorResponse(
                'Failed on update Barcode.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->sendResponse(
            'Success on update Barcode.',
            $barcode,
            status_code: Response::HTTP_CREATED
        );
    }

    /**
     * @param int $barcode_id
     * @return JsonResponse
     */
    public function destroy(int $barcode_id): JsonResponse
    {
        if (!(($barcode = Auth::user()->barcodes()->where('id', $barcode_id)->first())) instanceof Barcode) {
            return $this->sendErrorResponse('Barcode not found for authenticated User.');
        }

        if (!$barcode->delete()) {
            return $this->sendErrorResponse(
                'Failed on delete Barcode.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->sendResponse('Success on delete barcode.');
    }
}
