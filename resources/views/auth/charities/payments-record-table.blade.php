@if(count(($expenses))>0)

    <section class=" flex-column d-flex align-items-center justify-content-center flex-fill w-100">
        <div class="d-flex flex-column h-100 w-100 ">
            <div class="d-flex flex-column  justify-content-between flex-fill pagination a">
                <table class="table my-2" id="table-id">
                    <thead>
                    <tr>

                        <th>{{__('invoice number')}}</th>
                        <th>{{__('number of orders')}}</th>
                        <th>{{__('Order weights')}}</th>
                        <th>{{__('Containers Number')}}</th>
                        <th>{{__('Containers weight')}}</th>
                        <th>{{__('Total weights')}}</th>
                        <th>{{__('Value')}}</th>
                        <th>{{__('Created date')}}</th>
                        <th>{{__('status')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($expenses as $expense)
                        <tr>
                            <td class="is_number">
                                <span class="text-dark is_number">{{$expense->id}}</span>
                            </td>
                            <td class="is_number">
                                <span class=" is_number">{{$expense->orders_count}}</span>
                            </td>
                            <td class="is_number ">
                                <span class=" is_number ">{{$expense->orders_weight}}Kg</span>
                            </td>
                            <td class="is_number">{{$expense->containers_count}}</td>
                            <td class="is_number ">
                                <span class=" is_number ">{{$expense->containers_weight}}Kg</span>
                            </td>
                            <td class="is_number ">
                                <span class=" is_number ">{{$expense->weight}}Kg</span>
                            </td>
                            <td class="is_number">
                                <span class=" is_number text-dark  fw-bold">{{ $expense->value == "" ? "---" : $expense->value . ' ' . $currency}}</span>
                            </td>
                            <td class="is_number">{{$expense->created_at}}</td>
                            <td class="is_number">
                                @if($expense->status == '1')
                                    <span type="button"
                                          class="btn btn-sm warning-btn small-one">{{__('Processing')}}</span>
                                @elseif($expense->status == '2')
                                    <span type="button"
                                          class="btn btn-sm done-btn small-one">{{__('Payed')}}</span>
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
                                @if($expenses->nextPageUrl())
                                    <a href="{{$expenses->nextPageUrl()}}"
                                       class="number text-decoration-none is_number">{{$expenses->currentPage() + 1}}</a>
                                @endif
                                <a href=""
                                   class="active pe-none number text-decoration-none currentPage mx-2 is_number">{{$expenses->currentPage()}}</a>
                                @if($expenses->previousPageUrl())
                                    <a href="{{$expenses->previousPageUrl()}}"
                                       class="number text-decoration-none is_number">{{$expenses->currentPage() - 1}}</a>
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

