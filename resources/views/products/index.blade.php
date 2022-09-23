@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <option value="">Select a Variant</option>
                        @foreach ($variants as $row)
                            <option value="{{ $row->id }}">{{ $row->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From"
                            class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
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

                        @if (isset($products))
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $item->product_data->id }}</td>
                                    <td>{{ $item->product_data->title }} <br> Created at :
                                        {{ date('d-M-Y', strtotime($item->product_data->created_at)) }}</td>
                                    <td>{{ Str::limit($item->product_data->description, 50) }}</td>
                                    <td>
                                        <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                            <dt class="col-sm-3 pb-0">
                                                {{ !empty($item->product_variant_one_data->variant) ? $item->product_variant_one_data->variant : '' }}
                                                {{ !empty($item->product_variant_two_data->variant) ? '/ ' . $item->product_variant_two_data->variant : '' }}
                                                {{ !empty($item->product_variant_three_data->variant) ? '/ ' . $item->product_variant_three_data->variant : '' }}
                                            </dt>
                                            <dd class="col-sm-9">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-4 pb-0">Price : {{ number_format($item->price, 2) }}
                                                    </dt>
                                                    <dd class="col-sm-8 pb-0">InStock :
                                                        {{ number_format($item->stock, 2) }}
                                                    </dd>
                                                </dl>
                                            </dd>
                                        </dl>
                                        <button onclick="$('#variant').toggleClass('h-auto')"
                                            class="btn btn-sm btn-link">Show more</button>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                        </div>
                                    </td>
                                </tr>
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
                    <p>Showing {{ $dist_prod }} to {{ $dist_prod }} out of {{ $dist_prod }}</p>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
