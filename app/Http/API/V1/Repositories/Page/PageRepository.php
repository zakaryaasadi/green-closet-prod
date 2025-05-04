<?php

namespace App\Http\API\V1\Repositories\Page;

use App\Enums\SectionType;
use App\Filters\CountryCustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\Event\SimpleEventResource;
use App\Http\Resources\News\SimpleNewsResource;
use App\Http\Resources\Offer\SimpleOfferResource;
use App\Http\Resources\Order\SimpleOrderResource;
use App\Http\Resources\Partner\SimplePartnerResource;
use App\Mail\ContactFromClient;
use App\Models\Association;
use App\Models\Event;
use App\Models\Language;
use App\Models\News;
use App\Models\Offer;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Section;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\FileManagement;
use Illuminate\Support\Facades\Mail;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class PageRepository extends BaseRepository
{
    use FileManagement, ApiResponse;

    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('language_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['title', 'default_page_title', 'slug', 'meta_tags'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('country_id'),
            AllowedSort::field('language_id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Page::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function homePage($dataRequest): array
    {
        $data = collect($dataRequest);
        $clientCountry = AppHelper::getCoutnryForMobile();

        $lastOrder = null;
        $userPoints = 0;

        if ($data->has('user_id')) {
            if ($data->get('user_id') == null)
                $userPoints = 0;
            else {
                $user = User::whereId($data->get('user_id'))->first();
                $userPoints = $user?->activePoints($clientCountry->id);
                $userOrders = $user?->orders()->where('country_id', '=', $clientCountry->id);
                if ($userOrders && $userOrders->count() > 0)
                    $lastOrder = new SimpleOrderResource($userOrders->orderByDesc('id')->first());
            }
        }


        $allEvents = [];
        $events = Event::where('country_id', $clientCountry->id)->latest()->take(5)->get();
        foreach ($events as $item) {
            $allEvents[] = new SimpleEventResource($item);
        }

        $allOffers = [];
        $offers = Offer::where('country_id', $clientCountry->id)->latest()->take(5)->get();
        foreach ($offers as $item) {
            $allOffers[] = new SimpleOfferResource($item);
        }

        $allNews = [];
        $news = News::where('country_id', $clientCountry->id)->latest()->take(5)->get();
        foreach ($news as $item) {
            $allNews[] = new SimpleNewsResource($item);
        }

        $allAssociations = [];
        $associations = Association::where('country_id', $clientCountry->id)->latest()->take(5)->get();
        foreach ($associations as $association) {
            $allAssociations[] = new SimpleAssociationResource($association);
        }

        $allPartners = [];
        $partners = Partner::where('country_id', $clientCountry->id)->latest()->take(5)->get();
        foreach ($partners as $item) {
            $allPartners[] = new SimplePartnerResource($item);
        }


        return [
            'points' => $userPoints,
            'events' => $allEvents,
            'offers' => $allOffers,
            'associations' => $allAssociations,
            'news' => $allNews,
            'partners' => $allPartners,
            'lastOrder' => $lastOrder,
        ];
    }

    /**
     * @throws IPinfoException
     */
    public function contactUs(): array
    {
        $country = AppHelper::getCoutnryForMobile();
        $email = Setting::where(['country_id' => $country->id])->first()->email;
        $location = Setting::where(['country_id' => $country->id])->first()->location;
        $phone = Setting::where(['country_id' => $country->id])->first()->phone;

        return [
            'email' => $email,
            'location' => $location,
            'phone' => $phone,
        ];
    }

    /**
     * @throws IPinfoException
     */
    public function howWeWorkPage(): array
    {
        $country = AppHelper::getCoutnryForMobile();
        $language = AppHelper::getLanguageForMobile();
        $section = Section::where(
            [
                'country_id' => $country->id,
                'language_id' => Language::whereCode($language)->first()->id,
                'type' => SectionType::HOW_WE_WORK_MOBILE,
            ])->first();
        $structure = $section?->structure ?? null;

        return [
            'section' => $structure,
        ];
    }

    /**
     * @throws IPinfoException
     */
    public function sendMail($data): \Illuminate\Http\JsonResponse
    {
        $user = \Auth::user();

        $country = AppHelper::getCoutnryForMobile();
        $email = Setting::where(['country_id' => $country->id])->first()?->mail_receiver
            ?? Setting::where(['country_id' => null])->first()?->mail_receiver;

        if (!$email) {
            $email = config('app.mail_to');
        }
        $sendData = [
            'mail' => $data['mail'] ?? '',
            'message' => $data['message'] ?? '',
            'user' => $user?->name,
            'user_phone' => $user?->phone,
        ];
        Mail::to($email)->send(new ContactFromClient($sendData));

        return $this->responseMessage(__('Mail Sent Successfully'));

    }
}
