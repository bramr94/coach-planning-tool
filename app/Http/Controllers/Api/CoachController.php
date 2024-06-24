<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CoachRequest;
use App\Http\Resources\CoachResource;
use App\Models\Appointment;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoachController extends Controller
{
    public function index(CoachRequest $request): AnonymousResourceCollection
    {
        $coaches = Coach::query()
            ->with('schedules.appointments', function (Builder|HasMany $query) use ($request) {
                /** @var Appointment $query */
                $query->whereBetween('date', [$request->get('start_date'), $request->get('end_date')]);
            })
            ->paginate(config('api.pagination.per_page'));

        return CoachResource::collection($coaches);
    }

    public function show(CoachRequest $request, Coach $coach): CoachResource
    {
        $coach->load(['schedules.appointments' => function (Builder|HasMany $query) use ($request) {
            $query->whereBetween('date', [$request->get('start_date'), $request->get('end_date')]);
        }]);

        return CoachResource::make($coach);
    }
}
