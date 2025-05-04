<?php

namespace App\Http\Resources\ContainerDetails;

use App\Http\Resources\Container\SimpleContainerResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\ContainerDetails;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ContainerDetails
 */
class ContainerDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'agent' => $this->getAgentResource(),
            'container' => $this->getContainerResource(),
            'weight' => $this->weight,
            'value' => $this->value,
            'date' => $this->date,
        ];
    }

    protected function getAgentResource(): ?array
    {
        if (!$this->agent)
            return null;

        $agent = new SimpleUserResource($this->agent);

        return $agent->jsonSerialize();
    }

    protected function getContainerResource(): ?array
    {
        if (!$this->container)
            return null;

        $container = new SimpleContainerResource($this->container);

        return $container->jsonSerialize();
    }
}
