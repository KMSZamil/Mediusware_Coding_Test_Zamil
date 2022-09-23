@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="{{ route('product_filter') }}" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control"
                        value="{{ isset(request()->title) ? request()->title : '' }}">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <option value="" disabled>Select a Variant</option>
                        @foreach ($variants as $item)
                            <option disabled>{{ $item[0]->title }}</option>
                            @foreach ($item as $row)
                                <option value="{{ $row->variant_id }}"
                                    {{ isset(request()->variant) && $row->variant_id == request()->variant ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $row->variant }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From"
                            class="form-control" value="{{ isset(request()->price_from) ? request()->price_from : '' }}">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control"
                            value="{{ isset(request()->price_to) ? request()->price_to : '' }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control"
                        value="{{ isset(request()->date) ? date('Y-m-d', strtotime(request()->date)) : '' }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Variant</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @if (isset($product_data))
                            @foreach ($product_data as $items)
                                @foreach ($items as $item)
                                    <tr>
                                        @if ($loop->first)
                                            <td rowspan="{{ count($items) }}">{{ $item->product_data->id }}</td>
                                            <td rowspan="{{ count($items) }}">{{ $item->product_data->title }} <br>
                                                Created
                                                at :
                                                {{ date('d-M-Y', strtotime($item->product_data->created_at)) }}</td>
                                            <td rowspan="{{ count($items) }}">
                                                {{ Str::limit($item->product_data->description, 50) }}</td>
                                        @endif
                                        <td>
                                            <dl class="row mb-0" style="height: 20px; overflow: hidden"
                                                id="variant{{ $item->product_data->id }}">
                                                <dt class="col-sm-3 pb-0">
                                                    {{ !empty($item->product_variant_one_data->variant) ? $item->product_variant_one_data->variant : '' }}
                                                    {{ !empty($item->product_variant_two_data->variant) ? ' / ' . $item->product_variant_two_data->variant : '' }}
                                                    {{ !empty($item->product_variant_three_data->variant) ? ' / ' . $item->product_variant_three_data->variant : '' }}
                                                </dt>
                                                <dd class="col-sm-9">
                                                    <dl class="row mb-0">
                                                        <dt class="col-sm-4 pb-0">Price :
                                                            {{ number_format($item->price, 2) }}
                                                        </dt>
                                                        <dd class="col-sm-8 pb-0">InStock :
                                                            {{ number_format($item->stock, 2) }}
                                                        </dd>
                                                    </dl>
                                                </dd>
                                            </dl>
                                            @if ($loop->last)
                                                <button
                                                    onclick="$('#variant{{ $item->product_data->id }}').toggleClass('h-auto')"
                                                    class="btn btn-sm btn-link">Show more</button>
                                            @endif
                                        </td>
                                        @if ($loop->first)
                                            <td rowspan="{{ count($items) }}">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('product.edit', 1) }}"
                                                        class="btn btn-success">Edit</a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {{ $products->links() }}
            </div>

        </div>
        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->currentPage() }} to {{ $products->count() }} out of {{ $products->total() }}
                    </p>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
