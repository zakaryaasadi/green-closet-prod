<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Activity;
use App\Models\Association;
use App\Models\Order;
use App\Models\User;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Activity
 */
class OrderLogActivityResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'causer' => $this->getSimpleUserResource(),
            'action' => $this->description,
            'old' => $this->getOldStatus(),
            'current' => $this->getCurrentStatus(),
            'date' => $this->created_at,
        ];
    }

    public function getOldStatus(): ?array
    {
        $properties = collect($this->properties);
        if ($properties->has('old')) {
            $olds = [];
            $old = collect($properties->get('old'));
            foreach ($old->keys() as $key) {
                $value = $old->get($key);
                if ($key == 'agent_id') {
                    $key = 'agent';
                    $value = new SimpleUserResource(User::whereId($old->get('agent_id'))->first());
                }
                if ($key == 'customer_id') {
                    $key = 'customer';
                    $value = new SimpleUserResource(User::whereId($old->get('customer_id'))->first());
                }
                if ($key == 'association_id') {
                    $key = 'association';
                    $value = new SimpleAssociationResource(Association::whereId($old->get('association_id'))->first());
                }
                if ($key == 'image') {
                    $key = 'image';
                    $value = Order::getDisk()->url($old->get('image'));
                }
                $olds[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }

            return $olds;
        }
        else
            return null;
    }

    public function getCurrentStatus(): ?array
    {
        $properties = collect($this->properties);
        if ($properties->has('attributes')) {
            $currents = [];
            $current = collect($properties->get('attributes'));
            foreach ($current->keys() as $key) {
                $value = $current->get($key);
                if ($key == 'agent_id') {
                    $key = 'agent';
                    $value = new SimpleUserResource(User::whereId($current->get('agent_id'))->first());
                }
                if ($key == 'customer_id') {
                    $key = 'customer';
                    $value = new SimpleUserResource(User::whereId($current->get('customer_id'))->first());
                }
                if ($key == 'association_id') {
                    $key = 'association';
                    $value = new SimpleAssociationResource(Association::whereId($current->get('association_id'))->first());
                }
                if ($key == 'image') {
                    $key = 'image';
                    $value = Order::getDisk()->url($current->get('image'));
                }
                $currents[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }

            return $currents;
        }
        else
            return null;
    }

    public function getSimpleUserResource(): ?SimpleUserResource
    {
        if (!$this->causer)
            return null;

        return new SimpleUserResource($this->causer);
    }
}
