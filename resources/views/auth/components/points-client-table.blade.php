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
@if(count(($points))>0)

    <section class=" flex-column d-flex align-items-center justify-content-center flex-fill w-100">
        <div class="d-flex flex-column h-100 w-100 ">
            <div class="d-flex flex-column  justify-content-between flex-fill pagination a">
                <table class="table my-2" id="table-id">
                    <thead>
                    <tr>
                        <th>{{__('count')}}</th>
                        <th>{{__('used')}}</th>
                        <th>{{__('ends at')}}</th>
                        <th>{{__('status')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($points as $point)
                        <tr>
                            <td class="is_number">
                                @if($point->count > 300)
                                    <span class="high is_number count"
                                          data-target="{{$point->count}}">0</span>
                                @elseif($point->status <300)
                                    <span class="low is_number count"
                                          data-target="{{$point->count}}">0</span>
                                @endif

                            </td>
                            <td class="is_number">
                                @if($point->used == 1)
                                    <svg width="19" height="19" viewBox="0 0 33 33" fill="none" style="transform: rotate(180deg)"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16.1124" cy="16.1884" r="16" fill="#00A912"/>
                                        <path d="M9.51978 16.7061L13.5698 20.7561L22.7052 11.6207"
                                              stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                @else
                                    <svg width="19" height="19" viewBox="0 0 33 33" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16.2183" cy="16.1884" r="16" fill="#EB5757"/>
                                        <path d="M11.6506 20.7561L20.786 11.6207" stroke="white"
                                              stroke-width="2" stroke-linecap="round"/>
                                        <path d="M20.7859 20.7561L11.6506 11.6207" stroke="white"
                                              stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                @endif
                            </td>
                            <td class="is_number ends_at">{{$point->ends_at == "" ? "---" : \App\Helpers\AppHelper::changeDateFormat($point->ends_at)}}</td>
                            <td>
                                @if($point->status == \App\Enums\PointStatus::ACTIVE)
                                    <span>{{__('Active')}}</span>
                                @elseif($point->status == \App\Enums\PointStatus::FINISH)
                                    <span>{{__('Finish')}}</span>
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
                                @if($points->nextPageUrl())
                                    <a href="{{$points->nextPageUrl()}}"
                                       class="number text-decoration-none is_number next-page-url "
                                    >{{$points->currentPage() + 1}}</a>
                                @endif
                                <a type="button"
                                   class="active currentPage pe-none number text-decoration-none  mx-2 is_number "
                                >{{$points->currentPage()}}
                                </a>
                                @if($points->previousPageUrl())
                                    <a href="{{$points->previousPageUrl()}}"
                                       class="number text-decoration-none is_number previous-page-url"
                                    >{{$points->currentPage() - 1}}
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


    </div>
@endif


<script>
    ends_at_order = document.querySelectorAll(".ends_at")

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

</script>
