@php
use App\Helpers\AppHelper;
use App\Enums\OrderStatus;
@endphp
@if(App::getLocale() == 'en')
    <style>
        .date {
            display: flex;
            gap: 10px;
            flex-direction: row-reverse;
            justify-content: start;
        }
    </style>
@endif
@if(count(($orders))>0)

    <section class=" flex-column d-flex align-items-center justify-content-center flex-fill w-100">
        <div class="d-flex flex-column h-100 w-100 ">
            <div class="d-flex flex-column  justify-content-between flex-fill a">
                <table class="table my-2" id="table-id">
                    <thead>
                    <tr>
                        <th>{{__('Number')}}</th>
                        <th>{{__('customer name')}}</th>
                        <th>{{__('Phone')}}</th>
                        <th>{{__('weight')}}</th>
                        <th>{{__('Value')}}</th>
                        <th>{{__('Address')}}</th>
                        <th>{{__('Created date')}}</th>
                        <th>{{__('Start at')}}</th>
                        <th>{{__('Finish at')}}</th>
                        <th>{{__('status')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($orders as $order)
                        <tr>

                            <td class="is_number">
                                <span class="text-dark is_number">{{$order->id}}</span>
                            </td>
                            <td class="is_number">
                                <span class=" is_number">{{$order->customer?->name ?? ' '}}</span>
                            </td>

                            <td class="is_number dir-ltr text-end">
                                <span class=" is_number ">{{$order->customer?->phone ?? ' '}}</span>
                            </td>
                            <td class="is_number">{{$order->weight}}Kg</td>
                            <td class="is_number">
                                <span
                                    class="fw-bold is_number text-dark">{{ $order->value == "" ? "---" : $order->value." " . $currency}}</span>
                            </td>
                            <td class="is_number">

                                <a href=https://www.google.com/maps/{{"@".$order->location->getLat()}},{{$order->location->getLng()}},128m/data=!3m1!1e3
                                   class="text-muted text-decoration-none"
                                   target="_blank">{{__('Address accompanying the order')}}</a>
                            </td>
                            <td class="is_number created_at">{{AppHelper::changeDateFormat($order->created_at)}}</td>
                            <td class="is_number start_at">{{ $order->start_at == "" ? "---" :AppHelper::changeDateFormat($order->start_at)}}</td>
                            <td class="is_number ends_at">{{ $order->ends_at == "" ? "---" :AppHelper::changeDateFormat($order->ends_at)}}</td>

                            <td class="is_number  buttons-in-tables">

                                @if($order->status == OrderStatus::CREATED)
                                    <span type="button"
                                          class="btn btn-sm  created ">{{__('Created')}}</span>
                                @elseif($order->status == OrderStatus::ASSIGNED)
                                    <span type="button"
                                          class="btn btn-sm assigned ">{{__('Assigned')}}</span>
                                @elseif($order->status == OrderStatus::ACCEPTED)
                                    <span type="button"
                                          class="btn btn-sm accepted ">{{__('Accepted')}}</span>
                                @elseif($order->status == OrderStatus::DECLINE)
                                    <span type="button"
                                          class="btn btn-sm decline ">{{__('Declined')}}</span>
                                @elseif($order->status == OrderStatus::CANCEL)
                                    <span type="button"
                                          class="btn btn-sm cancel ">{{__('Canceled')}}</span>
                                @elseif($order->status == OrderStatus::DELIVERING)
                                    <span type="button"
                                          class="btn btn-sm delivering ">{{__('Delivering')}}</span>
                                @elseif($order->status == OrderStatus::FAILED)
                                    <span type="button"
                                          class="btn btn-sm failed ">{{__('Failed')}}</span>
                                @elseif($order->status == OrderStatus::SUCCESSFUL)
                                    <span type="button"
                                          class="btn btn-sm successful ">{{__('Successful')}}</span>
                                @elseif($order->status == OrderStatus::POSTPONED)
                                    <span type="button"
                                          class="btn btn-sm postponed ">{{__('Postponed')}}</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class='pagination-container w-100 pb-4 py-4'>
                    <div class="row pagination  justify-content-center">
                        <div class="col-4 col-md-3 col-lg-2  d-flex align-items-center justify-content-evenly  ">
                            <div class="pagination-number d-flex align-items-center justify-content-around flex-fill">
                                @if($orders->nextPageUrl())
                                    <a href="{{$orders->nextPageUrl()}}"
                                       class="number text-decoration-none is_number next-page-url "
                                    >{{$orders->currentPage() + 1}}</a>
                                @endif
                                <a type="button"
                                   class="active currentPage pe-none number text-decoration-none  mx-2 is_number "
                                >{{$orders->currentPage()}}
                                </a>
                                @if($orders->previousPageUrl())
                                    <a href="{{$orders->previousPageUrl()}}"
                                       class="number text-decoration-none is_number previous-page-url"
                                    >{{$orders->currentPage() - 1}}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <div
        class="empty-order-box d-flex align-items-center justify-content-center gap-2 h-100 w-100 flex-column ">
        <p class="fs-1 mb-0 text-muted">{{__('Oh Unfortunately')}}</p>


    </div>
@endif

<script>
    ends_at_order = document.querySelectorAll(".ends_at")
    start_at_order = document.querySelectorAll(".start_at")
    created_at_order = document.querySelectorAll(".created_at")

    function formatDate(date, lang) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            hours = d.getHours(),
            minutes = d.getMinutes();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        if (hours.length < 2)
            hours = '0' + hours;
        if (minutes.length < 2)
            minutes = '0' + minutes;
        let dateYY = [year, month, day].join('-'),
            dateHH = [hours, minutes].join(':');
        return `<span class="dir-ltr date"><span>${dateHH}</span> <span>${dateYY}</span></span>`
    }

    ends_at_order.forEach(e => {
        if (e.innerHTML !== "---") {
            let localDate = new Date(e.innerHTML)
            e.innerHTML = formatDate(localDate)
        }
    })
    start_at_order.forEach(e => {
        if (e.innerHTML !== "---") {
            let localDate = new Date(e.innerHTML)
            e.innerHTML = formatDate(localDate)
        }
    })
    created_at_order.forEach(e => {
        if (e.innerHTML !== "---") {
            let localDate = new Date(e.innerHTML)
            e.innerHTML = formatDate(localDate)
        }
    })

</script>
