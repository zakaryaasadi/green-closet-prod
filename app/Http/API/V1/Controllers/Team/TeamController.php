<?php

namespace App\Http\API\V1\Controllers\Team;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Team\TeamRepository;
use App\Http\API\V1\Requests\Team\GetTeamByGeoRequest;
use App\Http\API\V1\Requests\Team\StoreTeamRequest;
use App\Http\API\V1\Requests\Team\UpdateTeamRequest;
use App\Http\Resources\Team\TeamResource;
use App\Models\Order;
use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

/**
 * @group Team
 * APIs for teams
 */
class TeamController extends Controller
{
    protected TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->teamRepository = $teamRepository;
        $this->authorizeResource(Team::class);
    }

    /**
     * Show all Teams
     *
     * This endpoint lets you show all Teams
     *
     * @responseFile storage/responses/teams/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by association_id.
     * @queryParam filter[search] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id, name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->teamRepository->index();

        return $this->showAll($paginatedData->getData(), TeamResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific team
     *
     * This endpoint lets you show specific team
     *
     * @responseFile storage/responses/teams/show.json
     *
     * @param Team $team
     * @return JsonResponse
     */
    public function show(Team $team): JsonResponse
    {
        return $this->showOne($this->teamRepository->show($team), TeamResource::class);
    }

    /**
     * Add team
     *
     * This endpoint lets you add team
     *
     * @responseFile storage/responses/teams/store.json
     *
     * @param StoreTeamRequest $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $team = $this->teamRepository->storeTeam($data);

        return $this->showOne($team, TeamResource::class, __('The team added successfully'));
    }

    /**
     * Update specific team
     *
     * This endpoint lets you update specific team
     *
     * @responseFile storage/responses/teams/update.json
     *
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team): JsonResponse
    {
        $data = collect($request->validated());
        $teamUpdated = $this->teamRepository->updateTeam($team, $data);

        return $this->showOne($teamUpdated, TeamResource::class, __("Team's information updated successfully"));
    }

    /**
     * Delete specific team
     *
     * This endpoint lets you delete specific team
     *
     * @responseFile storage/responses/teams/delete.json
     *
     * @param Team $team
     * @return JsonResponse
     */
    public function destroy(Team $team): JsonResponse
    {
        $this->teamRepository->delete($team);
        $team->agents()->update(['team_id' => null]);

        return $this->responseMessage(__('Team deleted successfully'));
    }

    /**
     * Get Team by Geo
     *
     * This endpoint lets Get Team by Geo
     *
     * @responseFile storage/responses/teams/geo.json
     *
     * @param GetTeamByGeoRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function getTeamByGeo(GetTeamByGeoRequest $request, Order $order): JsonResponse
    {
        $this->authorize('viewAny', Team::class);
        $teams = $this->teamRepository->getTeamByGeo($request, $order);

        return $this->response('Team By Geo', $teams);
    }
}
