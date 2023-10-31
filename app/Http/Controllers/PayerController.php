<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayerRequest;
use App\Models\Payer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

class PayerController extends ApiBaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $column = $request->get('order_by');

        return $this->sendResponse(
            'Success on retrieve Payers.',
            Payer::where('user_id', Auth::user()->id)->when($column, function (Builder $query) use ($column) {
                $query->orderBy($column);
            })->get()
        );
    }

    /**
     * @param PayerRequest $request
     * @return JsonResponse
     */
    public function store(PayerRequest $request): JsonResponse
    {
        try {
            $payer = Payer::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

            if ($payer instanceof Payer) {
                return $this->sendResponse(
                    'Success on create Payer.',
                    $payer,
                    status_code: Response::HTTP_CREATED
                );
            }

            return $this->sendErrorResponse(
                'Failed on create Payer.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (PDOException) {
            return $this->sendErrorResponse(
                'User already has one Payer with this email.',
                status_code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * @param int $payer_id
     * @return JsonResponse
     */
    public function destroy(int $payer_id): JsonResponse
    {
        if (!(($payer = Auth::user()->payers()->where('id', $payer_id))->first()) instanceof Payer) {
            return $this->sendErrorResponse('Payer not found for authenticated User.');
        }

        try {
            $payer->delete();
            return $this->sendResponse('Success on delete Payer.');
        } catch (PDOException) {
            // Caso o Pagador exista porém não está relacionado com o Usuário autenticado.
            return $this->sendErrorResponse('Payer not found for authenticated User.');
        }
    }

    /**
     * @param PayerRequest $request
     * @param int $payer_id
     * @return JsonResponse
     */
    public function update(PayerRequest $request, int $payer_id)
    {
        if (!(($payers = Auth::user()->payers()->where('id', $payer_id)->first()) instanceof Payer)) {
            return $this->sendErrorResponse('Payer not found for authenticated User.');
        }

        if (!$payers->update($request->validated())) {
            return $this->sendErrorResponse(
                'Failed on update Payer.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->sendResponse(
            'Success on update Payer.',
            $payers,
            status_code: Response::HTTP_CREATED
        );
    }
}
