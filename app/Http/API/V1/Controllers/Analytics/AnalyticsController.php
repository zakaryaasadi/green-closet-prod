<?php

namespace App\Http\API\V1\Controllers\Analytics;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Analytics\AnalyticsRepository;
use App\Http\API\V1\Requests\Analytics\AnalyticsRequest;
use App\Models\Analytics;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

/**
 * @group Analytics
 * APIs for analytics settings
 */
class AnalyticsController extends Controller
{
    protected AnalyticsRepository $analyticsRepository;

    public function __construct(AnalyticsRepository $analyticsRepository)
    {
        $this->middleware('auth:sanctum');
        $this->analyticsRepository = $analyticsRepository;
        $this->authorizeResource(Analytics::class);
    }

    /**
     * Analytics all Orders
     *
     * This endpoint lets you analytics all orders
     *
     * @responseFile storage/responses/analytics/analytics-orders.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsOrdersStatus(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsOrdersStatus($data);
    }

    /**
     * Analytics Containers details
     *
     * This endpoint lets you analytics Containers
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     *
     * @responseFile storage/responses/analytics/analytics-containers-details.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainersDetails(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsContainersDetails($data);
    }

    /**
     * Failed Orders Report
     *
     * This endpoint lets you Failed Orders Report
     *
     * @responseFile storage/responses/analytics/failed-orders-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function failedOrdersReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = $analytics->validated();

        return $this->analyticsRepository->failedOrdersReport($data);
    }

    /**
     * Analytics
     *
     * This endpoint lets you analytics
     *
     * @responseFile storage/responses/analytics/analytics.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analytics(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = collect($analytics->validated());

        return $this->analyticsRepository->analytics($data);
    }

    /**
     * Analytics Containers status
     *
     * This endpoint lets you analytics Containers status
     *
     *
     * @responseFile storage/responses/analytics/analytics-containers-status.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainersStatus(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsContainersStatus($data);
    }

    /**
     * Analytics Containers type
     *
     * This endpoint lets you analytics Containers type
     *
     *
     * @responseFile storage/responses/analytics/analytics-containers-type.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainersType(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsContainersType($data);
    }

    /**
     * Analytics Containers not visited
     *
     * This endpoint lets you analytics Containers not visited
     *
     *
     * @responseFile storage/responses/analytics/analytics-containers-not-visited.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainersNotVisited(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsContainersNotVisited($data);
    }

    /**
     * Analytics Containers for each association
     *
     * This endpoint lets you Analytics Containers for each association
     *
     *
     * @responseFile storage/responses/analytics/analytics-associations-containers.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function numberOfContainersForEachAssociation(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);

        $data = $analytics->validated();

        return $this->analyticsRepository->numberOfContainersForEachAssociation($data);
    }

        /**
     * Analytics Container Weights
     *
     * This endpoint lets you Analytics Container Weights
     *
     *
     * @responseFile storage/responses/analytics/analytics-container-weights.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainerWeights(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsContainersWeighs($data);
    }

    /**
     * Analytics Containers for each team
     *
     * This endpoint lets you Analytics Containers for each team
     *
     *
     * @responseFile storage/responses/analytics/analytics-team-containers.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function weightsOfContainersForEachTeam(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsContainersWeightByTeams($data);
    }

    /**
     * Analytics Orders weight for each item
     *
     * This endpoint lets you Analytics Orders weight for each item
     *
     *
     * @responseFile storage/responses/analytics/analytics-items-orders.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function weightOfOrdersForItems(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsWeightOrdersForItems($data);
    }

    /**
     * Analytics Number Of Orders For items
     *
     * This endpoint lets you Analytics number of orders for each item
     *
     *
     * @responseFile storage/responses/analytics/analytics-number-orders.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function numberOfOrdersForItems(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsNumberOfOrdersForItems($data);
    }

    /**
     * Analytics weight Of Orders For teams
     *
     * This endpoint lets you Analytics weight of orders for each team
     *
     *
     * @responseFile storage/responses/analytics/analytics-weight-orders-for-teams.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function weightOfOrdersForTeams(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsOrdersWeightByTeams($data);
    }

    /**
     * Daily Report
     *
     * This endpoint lets you daily report
     *
     *
     * @responseFile storage/responses/analytics/daily-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function dailyReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->dailyReport($data);
    }

    /**
     * Daily Report Orders
     *
     * This endpoint lets you daily report for orders
     *
     *
     * @responseFile storage/responses/analytics/daily-report-orders.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function dailyReportOrders(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->dailyReportOrders($data);
    }

    /**
     * Daily Report Containers
     *
     * This endpoint lets you daily report for containers
     *
     *
     * @responseFile storage/responses/analytics/daily-report-containers.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function dailyReportContainers(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->dailyReportContainers($data);
    }

    /**
     * Analytics container unloading
     *
     * This endpoint lets you Analytics container unloading
     *
     *
     * @responseFile storage/responses/analytics/analytics-containers-unloading.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsContainersUnloading(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->analyticsContainersUnloading($data);
    }

    /**
     * Analytics best containers
     *
     * This endpoint lets you Analytics  best containers
     *
     *
     * @responseFile storage/responses/analytics/analytics-best-containers.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function bestContainers(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->bestContainers($data);
    }

    /**
     * Analytics containers count in area
     *
     * This endpoint lets you Analytics  containers count in area
     *
     *
     * @responseFile storage/responses/analytics/analytics-containers-count-area.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function dailyReportContainersCount(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->dailyReportContainersCount($data);
    }

    /**
     * Analytics agent
     *
     * This endpoint lets you Analytics agent
     *
     *
     * @responseFile storage/responses/analytics/analytics-agents.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function analyticsAgents(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = collect($analytics->validated());

        return $this->analyticsRepository->analyticsAgents($data);
    }

    /**
     * Analytics agents daily
     *
     * This endpoint lets you Analytics agents daily
     *
     *
     * @responseFile storage/responses/analytics/analytics-agents-daily.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function dailyAgentsReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->dailyAgentsReport($data);
    }

    /**
     * Analytics countries report
     *
     * This endpoint lets you Analytics countries report
     *
     *
     * @responseFile storage/responses/analytics/analytics-countries-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function countriesReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->countriesReport($data);
    }

    /**
     * Analytics provinces report
     *
     * This endpoint lets you Analytics provinces report
     *
     *
     * @responseFile storage/responses/analytics/analytics-provinces-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function provincesReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->provincesReport($data);
    }

    /**
     * Analytics associations report
     *
     * This endpoint lets you Analytics associations report
     *
     *
     * @responseFile storage/responses/analytics/analytics-associations-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function associationsReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->associationsReport($data);
    }

    /**
     * Analytics locations report
     *
     * This endpoint lets you Analytics locations report
     *
     *
     * @responseFile storage/responses/analytics/analytics-locations-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function getLocationsReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->getLocationsReport($data);
    }

    /**
     * Analytics user report
     *
     * This endpoint lets you Analytics users report
     *
     *
     * @responseFile storage/responses/analytics/analytics-users-report.json
     *
     * @param AnalyticsRequest $analytics
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function usersReport(AnalyticsRequest $analytics): JsonResponse
    {
        $this->authorize('analytics', Analytics::class);
        $data = $analytics->validated();

        return $this->analyticsRepository->usersReport($data);
    }
}
