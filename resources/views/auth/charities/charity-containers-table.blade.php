@php
    use App\Helpers\AppHelper;
    use App\Enums\ContainerType;
    use App\Enums\ContainerStatus;
    use App\Enums\DischargeShift;
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
@if(count(($containers))>0)

    <section class=" flex-column d-flex align-items-center justify-content-center flex-fill w-100">
        <div class="d-flex flex-column h-100 w-100 ">
            <div class="d-flex flex-column  justify-content-between flex-fill a">
                <table class="table my-2" id="table-id">
                    <thead>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('code')}}</th>
                        <th>{{__('Address')}}</th>
                        <th>{{__('date')}}</th>
                        <th>{{__('type')}}</th>
                        <th>{{__('status')}}</th>
                        <th>{{__('Discharge shift')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($containers as $container)
                        <tr>
                            <td class="is_number">{{$container->id}}</td>
                            <td class="is_number">{{$container->code}}</td>
                            <td class="is_number">
                                <a href="https://www.google.com/maps/{{"@".$container->location->getLat()}},{{$container->location->getLng()}},128m/data=!3m1!1e3"
                                   class="text-muted text-decoration-none" target="_blank">
                                    {{$container->location_description}}
                                </a>
                            </td>
                            <td class="is_number created_at">{{AppHelper::changeDateFormat($container->created_at)}}</td>

                            <td class="is_number">
                                @if($container->type == ContainerType::CLOTHES)
                                    <span type="button"
                                          class="btn btn-sm warning-btn small-one">{{__('Clothes')}}</span>
                                @elseif($container->type == ContainerType::SHOES)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Shoes')}}</span>
                                @elseif($container->type == ContainerType::PLASTIC)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Plastic')}}</span>
                                @elseif($container->type == ContainerType::GLASS)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Glass')}}</span>
                                @endif
                            </td>

                            <td class="is_number">
                                @if($container->status == ContainerStatus::ON_THE_FIELD)
                                    <span type="button"
                                          class="btn btn-sm warning-btn small-one">{{__('On the field')}}</span>
                                @elseif($container->status == ContainerStatus::HANGING)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Hanging')}}</span>
                                @elseif($container->status == ContainerStatus::IN_THE_WAREHOUSE)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('In the warehouse')}}</span>
                                @elseif($container->status == ContainerStatus::IN_MAINTENANCE)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('In maintenance')}}</span>
                                @elseif($container->status == ContainerStatus::SCRAP)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Scrap')}}</span>
                                @endif
                            </td>

                            <td class="is_number">
                                @if($container->discharge_shift == DischargeShift::MORNING_SHIFT)
                                    <span type="button"
                                          class="btn btn-sm warning-btn small-one">{{__('Morning shift')}}</span>
                                @elseif($container->discharge_shift == DischargeShift::EVENING_SHIFT)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Evening shift')}}</span>
                                @elseif($container->discharge_shift == DischargeShift::NIGHT_SHIFT)
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Night shift')}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>


                </table>
                <div class='pagination-container pb-4 py-4'>
                    <div class="row pagination  justify-content-center">
                        <div
                            class="col-4 col-md-3 col-lg-2  d-flex align-items-center justify-content-evenly  ">

                            <div
                                class="pagination-number d-flex align-items-center justify-content-around flex-fill">
                                @if($containers->nextPageUrl())
                                    <a href="{{$containers->nextPageUrl()}}"
                                       class="number text-decoration-none is_number">{{$containers->currentPage() + 1}}</a>
                                @endif
                                <a href=""
                                   class="active pe-none number text-decoration-none currentPage mx-2 is_number">{{$containers->currentPage()}}</a>
                                @if($containers->previousPageUrl())
                                    <a href="{{$containers->previousPageUrl()}}"
                                       class="number text-decoration-none is_number">{{$containers->currentPage() - 1}}</a>
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

    created_at_order.forEach(e => {
        let localDate = new Date(e.innerHTML)
        e.innerHTML = formatDate(localDate)
    })

</script>
